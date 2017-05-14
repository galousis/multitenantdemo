<?php
namespace App\Application\Services\User\Create;

use App\Application\Services\ApplicationService;
use App\Application\Services\DataTransformer\User\UserDataTransformer;
use App\Domain\User\Entities\User;
use App\Domain\User\Contracts\UserRepositoryContract;
use App\Domain\User\Exceptions\UserAlreadyExistsException;

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
	 * @param $request
	 * @return User
	 * @throws UserAlreadyExistsException
	 */
	public function execute($request = null)
	{
		$data = $request->only(['name', 'email','password']);
		$user = $this->userRepository->findByEmail($data['email']);

		if (null !== $user) {
			throw new UserAlreadyExistsException();
		}

		/** @var User $user */
		$user = new User($data);

		$this->userRepository->create($user);
		$this->userDataTransformer->write($user);

		return $this->userDataTransformer->read();
	}

}