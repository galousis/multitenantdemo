<?php
namespace App\Domain\User;

use App\Domain\Event\DomainEvent;
use App\Domain\User\ValueObjects\UserId;

/**
 * Class UserRegistered
 *
 * @package App\Domain\User
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class UserRegistered implements DomainEvent
{
	#region Constructor
	/** @var UserId  */
	private $userId;

	private $occurredOn;
	#endregion

	#region Constructor
	public function __construct(UserId $userId)
	{
		$this->userId = $userId;
		$this->occurredOn = new \DateTimeImmutable();
	}
	#endregion

	#region Methods
	public function userId()
	{
		return $this->userId;
	}
	/**
	 * @return \DateTime
	 */
	public function occurredOn()
	{
		return $this->occurredOn;
	}
	#endregion
}