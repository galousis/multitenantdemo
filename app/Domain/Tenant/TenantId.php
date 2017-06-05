<?php
namespace App\Domain\Tenant;

use Ramsey\Uuid\Uuid;

/**
 * Class TenantId
 *
 * @package App\Domain\Tenant
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class TenantId
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