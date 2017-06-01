<?php
namespace App\Domain\Media\Entities;

/**
 * Class MediaItem
 *
 * @package App\Domain\Media\Entities
 * @author thanos theodorakopoulos galousis@gmail.com
 */
class MediaItem
{

	#region properties
	/** @var int */
	private $id;

	/** @var int */
	protected $modelId;

	/** @var string */
	protected $modelType;

	/** @var string */
	protected $collectionName;

	/** @var string */
	protected $name;

	/** @var string */
	protected $disk;

	/** @var int */
	protected $size;

	/** @var string */
	protected $manipulation;

	/** @var string */
	protected $customProperties;

	/** @var string */
	protected $orderColumn;

	/** @var string */
	protected $fileName;

	/** @var string \DateTime */
	private $createdAt = 'CURRENT_TIMESTAMP';

	/** @var string \DateTime */
	private $updatedAt = 'CURRENT_TIMESTAMP';
	#endregion

	#region Constructor
	public function __construct($data) {

		$this->id = isset($data['id']) ? $data['id'] : null;

		$this->setModelId($data['model_id']);
		$this->setCollectionName($data['collection_name']);
		$this->setName($data['name']);
		$this->setFileName($data['file_name']);
		$this->setDisk($data['disk']);
		$this->setSize($data['size']);
		$this->setManipulation($data['manipulations']);
		$this->setCustomProperties($data['custom_properties']);
		$this->setOrderColumn($data['order_column']);
		$this->setCreatedAt();
		$this->setUpdatedAt();
	}
	#endregion

	/**
	 * @param $modelId
	 */
	public function setModelId($modelId)
	{
		$this->modelId = $modelId;
	}


	/**
	 * @param $modelId
	 */
	public function setCollectionName($modelId)
	{
		$this->modelId = $modelId;
	}

	/**
	 * @param $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @param $fileName
	 */
	public function setFileName($fileName)
	{
		$this->fileName = $fileName;
	}

	/**
	 * @param $disk
	 */
	public function setDisk($disk)
	{
		$this->disk = $disk;
	}

	/**
	 * @param $size
	 */
	public function setSize($size)
	{
		$this->size = $size;
	}

	/**
	 * @param $manipulation
	 */
	public function setManipulation($manipulation)
	{
		$this->manipulation = $manipulation;
	}

	/**
	 * @param $customProperties
	 */
	public function setCustomProperties($customProperties)
	{
		$this->customProperties = $customProperties;
	}

	/**
	 * @param $orderColumn
	 */
	public function setOrderColumn($orderColumn)
	{
		$this->orderColumn = $orderColumn;
	}

	#region Getters
	public function getId(): int
	{
		return $this->id;
	}


	public function getModelId(): int
	{
		return $this->modelId;
	}

	public function getModelType(): sting
	{
		return $this->modelType;
	}

	public function getSize(): int
	{
		return $this->size;
	}


	public function getCreatedAt(): \DateTime
	{
		return $this->createdAt;
	}

	public function getUpdateAr(): \DateTime
	{
		return $this->updatedAt;
	}
	#endregion

}