<?php
namespace App\Domain\User;

use App\Domain\Event\DomainEvent;
use App\Domain\User\ValueObjects\UserId;

/**
 * Class UserLogged
 *
 * @package App\Domain\User
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class UserLogged implements DomainEvent
{
	#region properties
	/** @var UserId  */
	private $userId;

	private $occurredOn;
	#endregion

	#region Constructor
	public function __construct(UserId $userId)
	{
		$this->userId = $userId;
		$this->occurredOn = new \DateTime();
	}
	#endregion

	#region Methods
	public function userId()
	{
		return $this->userId;
	}
	public function occurredOn()
	{
		return $this->occurredOn;
	}
	#endregion
}