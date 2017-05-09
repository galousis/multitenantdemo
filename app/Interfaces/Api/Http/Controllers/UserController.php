<?php
namespace App\Interfaces\Web\Http\Controllers;

use App\Interfaces\Api\Http\Controllers\Controller;

use App\Application\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;

/**
 * Class UserController
 *
 * @package App\Interfaces\Web\Http\Controllers\User
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class UserController extends Controller
{
	/**
	 * @var UserService
	 */
	public $userAppService;

	/**
	 * UserController constructor.
	 * @param UserService $userAppService
	 */
	public function __construct(UserService $userAppService)
	{
		$this->userAppService = $userAppService;
	}


	/**
	 * @param Request $request
	 * @return mixed
	 */
	public function login(Request $request)
	{
		$data = $request->only(['email','password']);
		$email = $data['email'];
		$password = $data['password'];

		//$a = Crypt::encrypt($password);

		return $this->userAppService->login($email,$password);
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

}