<?php
namespace App\Application\Services\User\Create;

use App\Application\Services\PasswordService;
use App\Application\Services\ApplicationService;
use App\Application\Services\DataTransformer\User\UserDataTransformer;
use App\Domain\User\Entities\User;
use App\Domain\User\Contracts\UserRepositoryContract;
use App\Domain\User\Exceptions\UserAlreadyExistsException;
use App\Interfaces\Api\Http\Controllers\ApiController;
use App\Interfaces\Api\Http\Response\JsonResponseDefault;
use Illuminate\Http\Request;
use Config;

/**
 * Class CreateUserService
 *
 * @package App\Application\Services\User\Create
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class CreateUserService implements ApplicationService
{

	#region properties
	/** @var UserRepositoryContract  */
	private $userRepository;
	/** @var UserDataTransformer  */
	private $userDataTransformer;
//	/** @var  PasswordService */
//	private $passwordService;
	#endregion

	#region Constructor
	/**
	 * CreateUserService constructor.
	 *
	 * @param UserRepositoryContract $userRepository
	 * @param UserDataTransformer $userDataTransformer
	 * @param PasswordService $passwordService
	 */
	public function __construct(
		UserRepositoryContract $userRepository,
		UserDataTransformer $userDataTransformer
//		PasswordService $passwordService
	) {
		$this->userRepository = $userRepository;
		$this->userDataTransformer = $userDataTransformer;
//		$this->passwordService = $passwordService;
	}
	#endregion

	#region Methods
	/**
	 * @param Request $request
	 * @return User
	 * @throws UserAlreadyExistsException
	 */
	public function execute(Request $request)
	{

		try {

			$data =[];
			$data['name'] 	= null;
			$data['jwt'] 	= null;

			#get request data
			$userData = $request->only(Config::get('auth.signup_fields'));

			#region Check (against email) if user already exists
			/** @var User $user */
			$user = $this->userRepository->findByEmail($userData['email']);

			if (null !== $user) {
				throw new UserAlreadyExistsException(ApiController::CODE_INTERNAL_ERROR, 500);
			}
			#endregion

			#region Create & persist
			/** @var User $user */
			$user = $this->userRepository->load($userData);
			#persist
			$this->userRepository->create($user);
			#endregion


		} catch (UserAlreadyExistsException $e) {
			return JsonResponseDefault::create(false, $data,'User already exists',500);
		}

	}

}