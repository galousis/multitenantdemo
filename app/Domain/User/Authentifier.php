<?php
namespace App\Domain\User;

use App\Domain\User\Contracts\UserRepositoryContract;
use App\Domain\Event\DomainEvent;
use App\Domain\User\Entities\User;
use App\Application\Services\User\Access\LoginUserRequest;
//use App\Application\Exceptions\JWTException; 			#Call a exception from Domain...
//use Firebase\JWT\JWT;  									#Infrastructure dependency
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\Api\Http\Response\JsonResponseDefault;

class Authentifier
{
	#region properties
	/**
	 * @var UserRepositoryContract
	 */
	private $repository;
	#endregion

	#region Constructor
	/**
	 * Authentifier constructor.
	 *
	 * @param UserRepositoryContract $repository
	 */
	public function __construct(UserRepositoryContract$repository)
	{
		$this->repository = $repository;
	}
	#endregion

	#region Methods

	/**
	 * @param LoginUserRequest $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function authenticate($request)
	{

		try {

			$data =[];
			$data['name'] 	= null;
			$data['jwt'] 	= null;

			/** @var User $user */
			$user = $this->repository->findByEmail($request->email());

			$encrypted = $user->getPassword();

			if (!Hash::check($request->password(), $encrypted)) {
				throw new JWTException('Wrong password', 500);
			}

			$token = JWTAuth::fromUser($user, [
				'exp' => Carbon::now()->addWeek()->timestamp,
				'data' => [                  // Data related to the signer user
					'userId'   => $user->id, // userid from the users table
					'name' => $user->getName(), // User name
					'email' => $user->getEmail(), // User name
				]
			]);
		} catch (JWTException $e) {
			return JsonResponseDefault::create(true, $data,'Could not authenticate',401);
		}

		if (!$token)
		{
			$data['name'] = $user->getName();
			return JsonResponseDefault::create(true, $data, 'Could not authenticate',401);
		}else
		{
			//$this->persistAuthentication($user);

			$data['name'] = $user->getName();
			$data['jwt']  = $token;
			return JsonResponseDefault::create(true, $data, 'successfully logged in',200);
		}

	}

//	abstract public function logout();
//	abstract protected function persistAuthentication(User $user);
//	abstract protected function isAlreadyAuthenticated();
	#endregion

}