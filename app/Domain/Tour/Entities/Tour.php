<?php
namespace App\Domain\Tour\Entities;

use App\Domain\Tour\ValueObjects\TourId;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Destination\Entities\Destination;
use Carbon\Carbon;

/**
 * Class Tour
 *
 * @package App\Domain\User\Entities
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class Tour
{

	#region properties
	/** @var TourId */
	public $id;

	/**
	 * @var string
	 */
	private $tourCode;

	/**
	 * @var string
	 */
	private $title;

	/**
	 * @var string
	 */
	private $description;

	/**
	 * @var \DateTime
	 */
	private $departure = 'CURRENT_TIMESTAMP';

	/**
	 * @var string
	 */
	private $duration;

	/**
	 * @var \DateTime
	 */
	private $createdAt = 'CURRENT_TIMESTAMP';

	/**
	 * @var \DateTime
	 */
	private $updatedAt = 'CURRENT_TIMESTAMP';

	/** @var  ArrayCollection */
	private $destinations;
	#endregion

	#region constructor
	/**
	 * Manager constructor.
	 * @param $data
	 */
	public function __construct($data)
	{
		$this->id = isset($data['id']) ? $data['id'] : null;
		$this->setTourCode($data['tourcode']);
		$this->setTitle($data['name']);
		$this->setDescription($data['description']);
		$this->setDeparture($data['departure']);
		$this->setDuration($data['duration']);
		$this->setCreatedAt();
		$this->setUpdatedAt();

		$this->destinations = new ArrayCollection;
	}
	#endregion

	#region Setters
	/**
	 * @param Destination $destination
	 */
	public function addDestination(Destination $destination)
	{
		if(!$this->destinations->contains($destination)) {
			$destination->setTour($this);
			$this->destinations->add($destination);
		}
	}

	/**
	 * @param string $tourcode
	 */
	public function setTourCode($tourcode)
	{
		$this->tourCode = $tourcode;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * @param string $departure
	 */
	public function setDeparture($departure)
	{
		$this->departure = $departure;
	}

	/**
	 * @param string $duration
	 */
	public function setDuration($duration)
	{
		$this->duration = $duration;
	}
	#endregion

	#region Getters
	/**
	 * @return string
	 */
	public function getTourCode()
	{
		return $this->tourCode;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @return string
	 */
	public function getDeparture()
	{
		return $this->departure;
	}

	/**
	 * @return string
	 */
	public function getDuration()
	{
		return $this->duration;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
		//return $this->createdAt->format('Y-m-d H:i:s');
	}

	/**
	 * @return \DateTime
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	public function setCreatedAt()
	{
		$this->createdAt = new \DateTime();
	}

	public function setUpdatedAt()
	{
		$this->updatedAt = new \DateTime();
	}

	#endregion

}