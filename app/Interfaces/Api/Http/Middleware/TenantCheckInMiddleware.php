<?php
namespace App\Interfaces\Api\Http\Middleware;

use App\Domain\Tenant\Exceptions\TenantDoesNotExistsException;
use App\Application\Services\Tenant\Access\TenantService;
use Doctrine\Common\Persistence\ManagerRegistry;
use LaravelDoctrine\ORM\IlluminateRegistry;
use Doctrine\ORM\EntityManagerInterface;
use LaravelDoctrine\ORM\DoctrineManager;
use App\Domain\Tenant\Entities\Tenant;
use Illuminate\Http\Request;
use Closure;

/**
 * Class TenantCheckInMiddleware
 *
 * @package App\Interfaces\Api\Http\Middleware
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class TenantCheckInMiddleware
{

	/**
	 * @var EntityManagerInterface
	 */
	protected $em;
	/** @var IlluminateRegistry  */
	protected $mr;
	/** @var  TenantService */
	protected $ts;

	/**
	 * TenantCheckInMiddleware constructor.
	 * @param IlluminateRegistry $mr
	 * @param TenantService $ts
	 */
	public function __construct(IlluminateRegistry $mr, TenantService $ts)
	{
		$this->mr = $mr;
		$this->ts = $ts;
	}

	public function handle(Request $request, Closure $next)
	{



		$subdomain = $request->route('subdomain');

		if($subdomain)
		{
			// Change manager
			// TODO this in a custom ServiceProvider (is a better place for)
			// TODO Check if tenant exists and try to move in
			$this->mr->setDefaultManager($subdomain);

			$this->mr->setDefaultConnection($subdomain);
		}


		return $next($request);
	}
}