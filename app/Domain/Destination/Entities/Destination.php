<?php
namespace App\Domain\Destination\Entities;

use App\Domain\Destination\ValueObjects\DestinationId;

/**
 * Class Destination
 *
 * @package App\Domain\Destination\Entities
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class Destination
{

	#region properties
	/** @var DestinationId */
	public $id;

	/**
	 * @var string
	 */
	private $title;

	/**
	 * @var string
	 */
	private $country;

	/**
	 * @var string
	 */
	private $description;

	/**
	 * @var string
	 */
	private $photos;

	/**
	 * @var string
	 */
	private $lat;

	/**
	 * @var string
	 */
	private $lng;

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
		$this->setTitle($data['name']);
		$this->setCountry($data['country']);
		$this->setDescription($data['description']);
		$this->setPhotos($data['photos']);
		$this->setLat($data['lat']);
		$this->setLng($data['lng']);
		$this->setCreatedAt();
		$this->setUpdatedAt();
	}
	#endregion

	#region Setters
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
	 * @param string $photos
	 */
	public function setPhotos($photos)
	{
		$this->photos = $photos;
	}

	/**
	 * @param string $lat
	 */
	public function setLat($lat)
	{
		$this->lat = $lat;
	}

	/**
	 * @param string $lng
	 */
	public function setLng($lng)
	{
		$this->lng = $lng;
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
	public function getPhotos()
	{
		return $this->photos;
	}

	/**
	 * @return string
	 */
	public function getLat()
	{
		return $this->lat;
	}

	/**
	 * @return string
	 */
	public function getLng()
	{
		return $this->lng;
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