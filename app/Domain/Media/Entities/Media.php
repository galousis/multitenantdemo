<?php
namespace App\Domain\Media\Entities;

use Illuminate\Support\Collection;
use App\Infrastructure\Media\Helpers\File;
use App\Infrastructure\Media\Conversion\Conversion;
use App\Infrastructure\Media\Conversion\ConversionCollection;
use App\Infrastructure\Media\UrlGenerator\UrlGeneratorFactory;
use App\Infrastructure\Media\SortableTrait;

class Media
{
	//use SortableTrait;

	const TYPE_OTHER = 'other';

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

	protected $manipulations;

	/** @var string */
	protected $customProperties;

	/** @var string */
	protected $orderColumn;

	/** @var string */
	protected $fileName;

	/** @var string */
	protected $mimeType;

	/** @var string */
	public $extension;


	/** @var string \DateTime */
	private $createdAt = 'CURRENT_TIMESTAMP';

	/** @var string \DateTime */
	private $updatedAt = 'CURRENT_TIMESTAMP';
	#endregion

	#region Constructor
	public function __construct($data = null) {

		if($data) {
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
	}
	#endregion

	#region Setters
	/**
	 * @param $modelId
	 */
	public function setModelId($modelId)
	{
		$this->modelId = $modelId;
	}

	/**
	 * @param $modelType
	 */
	public function setModelType($modelType)
	{
		$this->modelType = $modelType;
	}


	/**
	 * @param $collectionName
	 */
	public function setCollectionName($collectionName)
	{
		$this->collectionName = $collectionName;
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
	 * @param $manipulations
	 */
	public function setManipulation($manipulations)
	{
		$this->manipulations = $manipulations;
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

	/**
	 * @param $mimetype
	 */
	public function setMimeType ($mimetype)
	{
		$this->mimeType = $mimetype;
	}

	/**
	 * @param $date
	 */
	public function setCreatedAt($date)
	{
		$this->createdAt = $date;
	}

	/**
	 * @param $date
	 */
	public function setUpdatedAt($date)
	{
		$this->updatedAt = $date;
	}

	#endregion

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

	public function getDisk(): string
	{
		return $this->disk;
	}

	public function getManipulations()
	{
		return $this->manipulations;
	}

	public function getSize(): int
	{
		return $this->size;
	}

	public function getFileName() :string
	{
		return $this->fileName;
	}

	public function getCollectionName() :string
	{
		return $this->collectionName;
	}

	public function getOrderColumn() :string
	{
		return $this->orderColumn;
	}

	public function getCustomProperties() : string
	{
		return $this->customProperties;
	}

	public function getCreatedAt(): \DateTime
	{
		return $this->createdAt;
	}

	public function getUpdateAr(): \DateTime
	{
		return $this->updatedAt;
	}

	public function getMimeType(): string
	{
		return $this->mimeType;
	}

	#endregion

	#region Methods

	/**
	 * Get the full url to a original media file.
	 *
	 * @param string $conversionName
	 *
	 * @return string
	 *
	 * @throws \Spatie\MediaLibrary\Exceptions\InvalidConversion
	 */
	public function getFullUrl(string $conversionName = ''): string
	{
		return url($this->getUrl($conversionName));
	}

	/**
	 * Get the url to a original media file.
	 *
	 * @param string $conversionName
	 *
	 * @return string
	 *
	 * @throws \Spatie\MediaLibrary\Exceptions\InvalidConversion
	 */
	public function getUrl(string $conversionName = ''): string
	{
		$urlGenerator = UrlGeneratorFactory::createForMedia($this);

		if ($conversionName !== '') {
			$conversion = ConversionCollection::createForMedia($this)->getByName($conversionName);

			$urlGenerator->setConversion($conversion);
		}

		return $urlGenerator->getUrl();
	}

	/**
	 * Get the path to the original media file.
	 *
	 * @param string $conversionName
	 *
	 * @return string
	 *
	 * @throws \Spatie\MediaLibrary\Exceptions\InvalidConversion
	 */
	public function getPath(string $conversionName = ''): string
	{
		$urlGenerator = UrlGeneratorFactory::createForMedia($this);

		if ($conversionName != '') {
			$conversion = ConversionCollection::createForMedia($this)->getByName($conversionName);

			$urlGenerator->setConversion($conversion);
		}

		return $urlGenerator->getPath();
	}

	/**
	 * Collection of all ImageGenerator drivers.
	 */
	public function getImageGenerators() : Collection
	{
		return collect(config('medialibrary.image_generators'));
	}

	/**
	 * Determine the type of a file.
	 *
	 * @return string
	 */
	public function getTypeAttribute()
	{
		$type = $this->getTypeFromExtension();

		if ($type !== self::TYPE_OTHER) {
			return $type;
		}

		return $this->getTypeFromMime();
	}

	public function getTypeFromExtension(): string
	{
		$imageGenerator = $this->getImageGenerators()
			->map(function (string $className) {
				return app($className);
			})
			->first->canHandleExtension(strtolower($this->extension));

		return $imageGenerator
			? $imageGenerator->getType()
			: static::TYPE_OTHER;
	}

	/*
	 * Determine the type of a file from its mime type
	 */
	public function getTypeFromMime(): string
	{
		$imageGenerator = $this->getImageGenerators()
			->map(function (string $className) {
				return app($className);
			})
			->first->canHandleMime($this->getMimeType());

		return $imageGenerator
			? $imageGenerator->getType()
			: static::TYPE_OTHER;
	}

	public function getExtensionAttribute(): string
	{
		return pathinfo($this->getFileName(), PATHINFO_EXTENSION);
	}

	public function getHumanReadableSizeAttribute(): string
	{
		return File::getHumanReadableSize($this->size);
	}

	public function getDiskDriverName(): string
	{
		return strtolower(config("filesystems.disks.{$this->getDisk()}.driver"));
	}

	/*
	 * Determine if the media item has a custom property with the given name.
	 */
	public function hasCustomProperty(string $propertyName): bool
	{
		return array_has($this->getCustomProperty(), $propertyName);
	}

	/**
	 * Get if the value of custom property with the given name.
	 *
	 * @param string $propertyName
	 * @param mixed $default
	 *
	 * @return mixed
	 */
	public function getCustomProperty(string $propertyName, $default = null)
	{
		return array_get($this->getCustomProperty(), $propertyName, $default);
	}

	/**
	 * @param string $name
	 * @param mixed $value
	 *
	 * @return $this
	 */
	public function setCustomProperty(string $name, $value)
	{
		$customProperties = $this->getCustomProperty();

		array_set($customProperties, $name, $value);

		$this->custom_properties = $customProperties;

		return $this;
	}

	/**
	 * @param string $name
	 *
	 * @return $this
	 */
	public function forgetCustomProperty(string $name)
	{
		$customProperties = $this->getCustomProperty();

		array_forget($customProperties, $name);

		$this->custom_properties = $customProperties;

		return $this;
	}

	/*
	 * Get all the names of the registered media conversions.
	 */
	public function getMediaConversionNames(): array
	{
		$conversions = ConversionCollection::createForMedia($this);

		return $conversions->map(function (Conversion $conversion) {
			return $conversion->getName();
		})->toArray();
	}
	#endregion
}
