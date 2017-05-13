<?php
namespace App\Interfaces\Api\Http\Controllers;

//use App\Application\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Application\Services\User\Access\LoginUserRequest;
use App\Application\Services\User\Access\LogInUserService;
use App\Application\Services\User\Access\LogOutUserService;
use App\Application\Services\User\Access\SignUpUserRequest;
use App\Application\Services\User\Access\SignUpUserService;

/**
 * Class UserController
 *
 * @package App\Interfaces\Web\Http\Controllers\User
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class UserController extends Controller
{

	#region Properties
	/** @var LoginUserRequest */
	public $loginUserRequest;

	/** @var SignUpUserRequest */
	public $signUpUserRequest;

	/** @var LogInUserService  */
	public $logInUserService;

	/** @var LogOuUserService  */
	public $logOutUserService;

	/** @var SignUpUserService  */
	public $signUpUserService;
	#endregion

	#region Constructor
	/**
	 * UserController constructor.
	 * @param LoginUserRequest $loginUserRequest
	 * @param SignUpUserRequest $signUpUserRequest
	 * @param LogInUserService $logInUserService
	 * @param LogOutUserService $logOutUserService
	 * @param SignUpUserService $signUpUserService
	 */
	public function __construct(
		LoginUserRequest $loginUserRequest,
		SignUpUserRequest $signUpUserRequest,
		LogInUserService $logInUserService,
		LogOutUserService $logOutUserService,
		SignUpUserService $signUpUserService
	)
	{
		$this->loginUserRequest 	= $loginUserRequest;
		$this->signUpUserRequest 	= $signUpUserRequest;

		$this->logInUserService 	= $logInUserService;
		$this->logOutUserService	= $logOutUserService;
		$this->signUpUserService 	= $signUpUserService;
	}
	#endregion

	#region Methods
	/**
	 * @param Request $request
	 * @return mixed
	 */
	public function login(Request $request)
	{
		$this->loginUserRequest->setEmail($request->get('email'));
		$this->loginUserRequest->setPassword($request->get('password'));

		return $this->logInUserService->execute($this->loginUserRequest);
	}

	/**
	 * @param Request $request
	 * @return mixed
	 */
	public function create(Request $request)
	{
		$post = $request->all();
		return $this->userAppService->createManager($post);
	}

	/**
	 * @param $page
	 * @param $limit
	 * @return mixed
	 */
	public function getByPage($page, $limit)
	{
		return $this->userAppService->getByPage($page,$limit);
	}

	/**
	 * @param Request $request
	 * @return mixed
	 */
	public function getByFilter(Request $request)
	{
		$criteria = $request->only(['filter']);
		return $this->userAppService->getByFilter($criteria['filter']);
	}
	#endregion

}