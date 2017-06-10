<?php
namespace App\Application\Services\Tenant;

use Illuminate\Console\Events\ArtisanStarting;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleExceptionEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\EventDispatcher\EventDispatcher;
use App\Domain\Tenant\Entities\Tenant;
use App\Domain\Tenant\Contracts\TenantRepositoryContract;
use App\Domain\Tenant\Events\TenantActivatedEvent;
use App\Domain\Tenant\Events\TenantResolvedEvent;
use App\Domain\Tenant\Events\TenantNotResolvedEvent;
use App\Domain\Tenant\Exceptions\TenantNotResolvedException;
use App\Domain\Tenant\Exceptions\TenantDatabaseNameEmptyException;
use Doctrine\ORM\EntityManagerInterface;
use LaravelDoctrine\ORM\IlluminateRegistry;
use Doctrine\ORM\EntityManager;



/**
 * Class TenantResolveService
 *
 * @package App\Application\Services\Tenant
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class TenantResolveService
{
	#region properties
	/**
	 * @var Application|null
	 */
	protected $app = null;

	/**
	 * @var TenantRepositoryContract|null
	 */
	protected $tenantRepository = null;

	/**
	 * @var Request|null
	 */
	protected $request = null;

	/**
	 * @var null
	 */
	protected $activeTenant = null;

	/**
	 * @var bool
	 */
	protected $consoleDispatcher = false;

	/**
	 * @var null
	 */
	protected $defaultConnection = null;

	/**
	 * @var null|string
	 */
	protected $tenantConnection = null;
	#endregion

	/**
	 * TenantResolveService constructor.
	 * @param Application $app
	 * @param TenantRepositoryContract $tenantRepository
	 */
	public function __construct(Application $app, TenantRepositoryContract $tenantRepository)
	{
		$this->app = $app;
		$this->tenantRepository = $tenantRepository;
		$this->defaultConnection = $this->app['db']->getDefaultConnection();
		$this->tenantConnection = 'envtenant';
		config()->set('database.connections.' . $this->tenantConnection, config('database.connections.' . $this->defaultConnection));
	}

	/**
	 * @param Tenant $activeTenant
	 */
	public function setActiveTenant(Tenant $activeTenant)
	{
		$this->activeTenant = $activeTenant;

		if ($activeTenant->getSubDomain() != env('DOMAIN_NAME'))
		{
			$this->setDefaultConnection($activeTenant);
			event(new TenantActivatedEvent($activeTenant));
		}
	}

	/**
	 * @return null
	 */
	public function getActiveTenant()
	{
		return $this->activeTenant;
	}

	/**
	 * @return mixed
	 */
	public function getAllTenants()
	{
		return $this->tenantRepository->findAll();
	}

	/**
	 * @param $callback
	 */
	public function mapAllTenants($callback)
	{
		$tenants = $this->getAllTenants();
		foreach($tenants as $tenant)
		{
			$this->setActiveTenant($tenant);
			$callback($tenant);
		}
	}


	public function reconnectDefaultConnection()
	{
		$this->setDefaultConnection($this->tenantConnection);
	}


	public function reconnectTenantConnection()
	{
		$this->setDefaultConnection($this->getActiveTenant());
	}


	public function resolveTenant()
	{
		$this->registerTenantConsoleArgument();
		$this->registerConsoleStartEvent();
		$this->registerConsoleTerminateEvent();
		$this->resolveRequest();
	}

	public function isResolved()
	{
		return ! is_null($this->getActiveTenant());
	}

	/**
	 * @throws TenantNotResolvedException
	 */
	protected function resolveRequest()
	{

		if ($this->app->runningInConsole())
		{
			$domain = (new ArgvInput())->getParameterOption('--tenant', null);
			try
			{
				if(is_null($domain))
				{
					throw new \Exception();
				}

				/** @var Tenant $tenant */
				$tenant = $this->tenantRepository->findBySubDomain($domain);
			}
			catch (\Exception $e)
			{
				$tenant = null;
				echo $e->getMessage();
			}
		}
		else
		{
			$this->request = $this->app->make(Request::class);
			$domain = $this->request->getHost();
			$subdomain = explode('.', $domain)[0];

			if($subdomain != env('DOMAIN_NAME'))
			{
				/** @var Tenant $tenant */
				$tenant = $this->tenantRepository->findBySubDomain($subdomain);
			}
			else
				{
					/** @var Tenant $tenant */
					$tenant = $this->tenantRepository->findBySubDomain(env('DOMAIN_NAME'));
				}


			if (empty($tenant->getConnection()) || ( ! empty($tenant->getConnection()) && $tenant->getConnection() === 'pending'))
				$tenant = null;

			if ($tenant instanceof Tenant) {
				$this->setActiveTenant($tenant);
				event(new TenantResolvedEvent($tenant));
				return;
			}

			event(new TenantNotResolvedEvent($domain));

			if ( ! $this->app->runningInConsole()) {
				throw new TenantNotResolvedException($domain);
			}


		}
		return;
	}

	/**
	 * @param Tenant $activeTenant
	 * @throws TenantDatabaseNameEmptyException
	 */
	protected function setDefaultConnection(Tenant $activeTenant)
	{
		$hasConnection 	= ! empty($activeTenant->getConnection());
		$connection 	= $hasConnection ? $activeTenant->getConnection() : $this->tenantConnection;
		$databaseName 	= ($hasConnection && ! empty($activeTenant->getTenantDatabase())) ? $activeTenant->getTenantDatabase() : '';
		$databasePrefix = ($hasConnection && ! empty($activeTenant->getSubDomain())) ? config()->get('database.connections.' . $connection . '.database_prefix') : '';

		if ($hasConnection && empty($activeTenant->getSubDomain()))
		{
			throw new TenantDatabaseNameEmptyException();
		}

		#region Default laravel DatabaseManager
		config()->set('database.default', $connection);
		config()->set('database.connections.' . $connection . '.database', $databasePrefix . $databaseName);

		if ($hasConnection)
		{
			$this->app['db']->purge($this->defaultConnection);
		}

		$this->app['db']->setDefaultConnection($connection);
		#endregion

		#region Doctrine
		if (!$this->app['registry']->managerExists($activeTenant->getSubDomain()))
		{
			// Prepare settings, grab them from doctrine conf so we get the Fluent mappings too.
			$settings = \Config::get('doctrine.managers.default');
			// Ooops set the tenant_db as connection, otherwise nana will work properly bellow
			$settings['connection'] = $activeTenant->getConnection();

			// Now we need to add the dynamic manager (does not exists in doctrine config file)
			// into conatiner's registry (IlluminateRegistry), adds the connection too for us !
			$this->app['registry']->addManager($activeTenant->getSubDomain(), $settings );
		}

		// Set defaults
		$this->app['registry']->setDefaultManager($activeTenant->getSubDomain());
		$this->app['registry']->setDefaultConnection($activeTenant->getSubDomain());

		// Now all the magic is done right here, we reset into conatiner the new proper "em" (EntityManager)
		$this->app['em'] = $this->app['registry']->getManager($activeTenant->getSubDomain());
		#endregion



	}

	/**
	 * @return bool|Application|mixed
	 */
	protected function getConsoleDispatcher()
	{
		if (!$this->consoleDispatcher)
		{
			$this->consoleDispatcher = app(EventDispatcher::class);
		}
		return $this->consoleDispatcher;
	}


	protected function registerTenantConsoleArgument()
	{
		$this->app['events']->listen(ArtisanStarting::class, function($event)
		{
			$definition = $event->artisan->getDefinition();
			$definition->addOption(
				new InputOption('--tenant', null, InputOption::VALUE_OPTIONAL, 'The tenant subdomain or alias domain the command should be run for. Use * or all for every tenant.')
			);
			$event->artisan->setDefinition($definition);
			$event->artisan->setDispatcher($this->getConsoleDispatcher());
		});
	}


	protected function registerConsoleStartEvent()
	{
		$this->getConsoleDispatcher()->addListener(ConsoleEvents::COMMAND, function(ConsoleCommandEvent $event)
		{
			$tenant = $event->getInput()->getParameterOption('--tenant', null);
			if ( ! is_null($tenant))
			{
				if ($tenant == '*' || $tenant == 'all')
				{
					$event->disableCommand();
				}
				else
				{
					if ($this->isResolved())
					{
						$event->getOutput()->writeln('<info>Running command for ' . $this->getActiveTenant()->name . '</info>');
					}
					else
					{
						$event->getOutput()->writeln('<error>Failed to resolve tenant</error>');
						$event->disableCommand();
					}
				}
			}
		});
	}

	protected function registerConsoleTerminateEvent()
	{
		$this->getConsoleDispatcher()->addListener(ConsoleEvents::TERMINATE, function(ConsoleTerminateEvent $event)
		{
			$tenant = $event->getInput()->getParameterOption('--tenant', null);
			if( ! is_null($tenant))
			{
				if ($tenant == '*' || $tenant == 'all')
				{
					$command = $event->getCommand();
					$input = $event->getInput();
					$output = $event->getOutput();
					$exitCode = $event->getExitCode();
					$tenants = $this->getAllTenants();
					foreach($tenants as $tenant)
					{
						$this->setActiveTenant($tenant);
						$event->getOutput()->writeln('<info>Running command for ' . $this->getActiveTenant()->name . '</info>');
						try
						{
							$exitCode = $command->run($input, $output);
						}
						catch (\Exception $e)
						{
							$event = new ConsoleExceptionEvent($command, $input, $output, $e, $e->getCode());
							$this->getConsoleDispatcher()->dispatch(ConsoleEvents::EXCEPTION, $event);
							$e = $event->getException();
							throw $e;
						}
					}
					$event->setExitCode($exitCode);
				}
			}
		});
	}

}