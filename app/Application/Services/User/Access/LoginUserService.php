<?php
namespace App\Application\Services\User\Access;

use App\Application\Exceptions\LoginUserServiceException;
use App\Domain\User\Authentifier;
use App\Application\Services\ApplicationService;
use App\Domain\User\Entities\User;
use App\Application\Services\User\Access\LoginUserRequest;
use App\Interfaces\Api\Http\Response\JsonResponseDefault;
use App\Interfaces\Api\Http\Controllers\ApiController;
use Illuminate\Http\Request;

/**
 * Class LogInUserService
 *
 * @package App\Application\Services\User\Access
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class LogInUserService implements ApplicationService
{

	#region properties
	/** @var Authentifier  */
	private $authenticationService;
	#endregion

	#region COnstructor
	public function __construct(Authentifier $authenticationService)
	{
		$this->authenticationService = $authenticationService;
	}
	#endregion

	#region Methods
	/**
	 * @param $request
	 * @return mixed
	 * @throws LoginUserServiceException
	 */
	public function execute($request = null)
	{
			$response = $this->authenticationService->authenticate($request);
			return $response;
	}
	#endregion
}
