<?php
namespace App\Domain\User;

use App\Domain\User\Contracts\UserRepositoryContract;
use App\Domain\Event\DomainEvent;
use App\Domain\User\Entities\User;

abstract class Authentifier
{
	#region properties
	/**
	 * @var UserRepositoryContract
	 */
	private $repository;
	#endregion

	#region Constructor
	/**
	 * @param string $repository
	 */
	public function __construct($repository)
	{
		$this->repository = $repository;
	}
	#endregion

	#region Methods
	public function authenticate($email, $password)
	{

		//TODO finish it

		$user = $this->repository->findByEmail($email);

		if (!$user) {
			return false;
		}
		if ($user->password() !== $password) {
			return false;
		}
		$this->persistAuthentication($user);
		return true;
	}

	abstract public function logout();
	abstract protected function persistAuthentication(User $user);
	abstract protected function isAlreadyAuthenticated();
	#endregion

}