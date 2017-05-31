<?php
namespace App\Domain\Tour\Entities;

use App\Domain\Tour\ValueObjects\TourId;
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
	private $tourcode;

	/**
	 * @var string
	 */
	private $title;

	/**
	 * @var string
	 */
	private $description;

	/**
	 * @var string
	 */
	private $country;

	/**
	 * @var string
	 */
	private $departure;

	/**
	 * @var string
	 */
	private $duration;

	/**
	 * @var string
	 */
	private $destinations;

	/**
	 * @var \DateTime
	 */
	private $createdAt = 'CURRENT_TIMESTAMP';

	/**
	 * @var \DateTime
	 */
	private $updatedAt = 'CURRENT_TIMESTAMP';
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
		$this->setCountry($data['country']);
		$this->setDescription($data['description']);
		$this->setDeparture($data['departure']);
		$this->setDuration($data['duration']);
		$this->setDestinations($data['destinations']);
		$this->setCreatedAt();
		$this->setUpdatedAt();
	}
	#endregion

	#region Setters
	/**
	 * @param string $tourcode
	 */
	public function setTourCode($tourcode)
	{
		$this->tourcode = $tourcode;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @param string $country
	 */
	public function setCountry($country)
	{
		$this->country = $country;
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

	/**
	 * @param string $destinations
	 */
	public function setDestinations($destinations)
	{
		$this->destinations = $destinations;
	}
	#endregion

	#region Getters
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
	public function getCountry()
	{
		return $this->country;
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
	 * @return string
	 */
	public function getDestinations()
	{
		return $this->destinations;
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