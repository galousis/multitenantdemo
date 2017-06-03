<?php
namespace App\Application\Services\Tour\AggregateVersion;

use App\Application\Services\ApplicationService;
use App\Domain\User\Exceptions\UserDoesNotExistException;
use App\Domain\User\ValueObjects\UserId;
use App\Domain\User\Contracts\UserRepositoryContract;
use App\Domain\User\Entities\User;

/**
 * Class TourService
 *
 * @package App\Application\Services\Tour\AggregateVersion
 * @author thanos theodorakopoulos galousis@gmail.com
 */
abstract class TourService implements ApplicationService
{
	/**
	 * @var UserRepositoryContract
	 */
	protected $userRepository;

	public function __construct(UserRepositoryContract $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * @param $userId
	 * @return User
	 * @throws UserDoesNotExistException
	 */
	protected function findUserOrFail($userId)
	{
		/** @var User $user */
		$user = $this->userRepository->findById(new UserId($userId));
		if (null === $user) {
			throw new UserDoesNotExistException();
		}
		return $user;
	}
}
