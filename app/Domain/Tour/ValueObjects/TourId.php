<?php
namespace App\Domain\Tour\ValueObjects;

use Ramsey\Uuid\Uuid;


/**
 * Class TourId
 *
 * @package App\Domain\Tour\ValueObjects
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class TourId
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
	 * @param TourId $tourId
	 *
	 * @return bool
	 */
	public function equals(TourId $tourId)
	{
		return $this->id() === $tourId->id();
	}
	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->id();
	}

}