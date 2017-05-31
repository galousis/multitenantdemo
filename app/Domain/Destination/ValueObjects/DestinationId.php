<?php
namespace App\Domain\Destination\ValueObjects;

use Ramsey\Uuid\Uuid;


/**
 * Class DestinationId
 *
 * @package App\Domain\Destination\ValueObjects
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class DestinationId
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
	 * @param DestinationId $destinationId
	 *
	 * @return bool
	 */
	public function equals(DestinationId $destinationId)
	{
		return $this->id() === $destinationId->id();
	}
	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->id();
	}

}