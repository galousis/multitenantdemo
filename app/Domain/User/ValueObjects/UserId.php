<?php
namespace App\Domain\User\ValueObjects;

use Ramsey\Uuid\Uuid;

/**
 * Class UserId
 *
 * @package App\Domain\User\ValueObjects
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class UserId
{
	/**
	 * @var string
	 */
	private $id;
	/**
	 * @param string $id
	 */
	public function __construct($id = null)
	{
		$this->id = null === $id ? Uuid::uuid4()->toString() : $id;
	}
	/**
	 * @return string
	 */
	public function id()
	{
		return $this->id;
	}
	/**
	 * @param UserId $userId
	 *
	 * @return bool
	 */
	public function equals(UserId $userId)
	{
		return $this->id() === $userId->id();
	}
	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->id();
	}
}