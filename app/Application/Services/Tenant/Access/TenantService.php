<?php
namespace App\Application\Services\Tenant\Access;

use App\Application\Services\ApplicationService;
use App\Domain\Tenant\Entities\Tenant;
use App\Domain\Tenant\Contracts\TenantRepositoryContract;
use Illuminate\Http\Request;
use App\Interfaces\Api\Http\Response\JsonResponseDefault;
use App\Application\Exceptions\TenantServiceException;
//use App\Application\Exceptions\GetToursServiceException;
use Exception;


/**
 * Class TenantService
 *
 * @package App\Application\Services\Tenant\Access
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class TenantService implements ApplicationService
{

	#region properties
	/** @var TenantRepositoryContract  */
	private $tenantRepository;
	/** @var TenantRepositoryContract  */
	private static $_tenantRepository;
	#endregion

	#region Constructor
	public function __construct(TenantRepositoryContract $tenantRepository)
	{
		$this->tenantRepository = $tenantRepository;
		self::$_tenantRepository= $tenantRepository;
	}
	#endregion

	#region Methods
	/**
	 * @param Request $request
	 * @return mixed
	 * @throws TenantServiceException
	 */
	public function execute(Request $request)
	{

		try{

			$tenant = $this->tenantRepository->findBySubDomain($request->get('sub_domain'));

			return $tenant;


		}catch (Exception $e){
			throw new TenantServiceException($e->getMessage());
		}
	}

	/**
	 * @return TenantRepositoryContract
	 */
	public static function getTenantRepository()
	{
		return self::$_tenantRepository;
	}

	/**
	 * @param $value
	 * @return mixed
	 */
	public static function whereSubdomain($value)
	{
		try{
			return self::getTenantRepository()->findBySubDomain($value);
		}catch (Exception $e){
			throw new TenantServiceException($e->getMessage());
		}
	}
}