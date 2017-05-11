<?php
namespace App\Application\Services\User\Access;

use App\Application\Services\ApplicationService;
use App\Application\Services\DataTransformer\User\UserDataTransformer;
use App\Domain\User\Entities\User;
use App\Domain\User\Contracts\UserRepositoryContract;
use App\Domain\User\Exceptions\UserAlreadyExistsException;

/**
 * Class SignUpUserService
 *
 * @package App\Application\Services\User\Access
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class SignUpUserService implements ApplicationService
{

	#region properties
	/** @var UserRepositoryContract  */
	private $userRepository;
	/** @var UserDataTransformer  */
	private $userDataTransformer;
	#endregion

	#region Constructor
	public function __construct(
		UserRepositoryContract $userRepository,
		UserDataTransformer $userDataTransformer
	) {
		$this->userRepository = $userRepository;
		$this->userDataTransformer = $userDataTransformer;
	}
	#endregion

	#region Methods
	/**
	 * @param SignUpUserRequest $request
	 *
	 * @return User
	 *
	 * @throws UserAlreadyExistsException
	 */
	public function execute($request = null)
	{
		$email 		= $request->email();
		$password 	= $request->password();
		$user 		= $this->userRepository->ofEmail($email);

		if (null !== $user) {
			throw new UserAlreadyExistsException();
		}

		$user = new User(
			$this->userRepository->nextIdentity(),
			$email,
			$password
		);

		$this->userRepository->add($user);
		$this->userDataTransformer->write($user);

		return $this->userDataTransformer->read();
	}
	#endregion

}