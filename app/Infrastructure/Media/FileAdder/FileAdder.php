<?php

namespace App\Infrastructure\Media\FileAdder;

use App\Application\Services\Media\MediaService;
use App\Domain\Media\Contracts\MediaRepositoryContract;
use App\Domain\Media\Entities\Media;
use App\Infrastructure\Doctrine\Repositories\MediaRepository;
use App\Infrastructure\Media\Helpers\File;
use App\Domain\Destination\Entities\Destination;
use App\Infrastructure\Media\Filesystem\Filesystem;
use App\Infrastructure\Media\Exceptions\FileCannotBeAdded;
use App\Infrastructure\Media\HasMedia\Interfaces\HasMedia;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use App\Infrastructure\Media\Exceptions\FileCannotBeAdded\UnknownType;
use App\Infrastructure\Media\Exceptions\FileCannotBeAdded\FileIsTooBig;
use App\Infrastructure\Media\Exceptions\FileCannotBeAdded\DiskDoesNotExist;
use App\Infrastructure\Media\Exceptions\FileCannotBeAdded\FileDoesNotExist;
use Carbon\Carbon;

class FileAdder
{
    /** @var Destination subject */
    protected $subject;

    /** @var Filesystem */
    protected $filesystem;

    /** @var bool */
    protected $preserveOriginal = false;

    /** @var string|\Symfony\Component\HttpFoundation\File\UploadedFile */
    protected $file;

    /** @var array */
    protected $properties = [];

    /** @var array */
    protected $customProperties = [];

    /** @var string */
    protected $pathToFile;

    /** @var string */
    protected $fileName;

    /** @var string */
    protected $mediaName;

    /** @var string */
    protected $diskName = '';

    /** @var  MediaService */
    protected $mediaService;

	/**
	 * FileAdder constructor.
	 * @param Filesystem $fileSystem
	 * @param MediaService $mediaService
	 */
    public function __construct(Filesystem $fileSystem, MediaService $mediaService)
    {
        $this->filesystem = $fileSystem;
		$this->mediaService = $mediaService;
    }

    /**
     * @param Destination $subject
     *
     * @return FileAdder
     */
    public function setSubject(Destination $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /*
     * Set the file that needs to be imported.
     *
     * @param string|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return $this
     */
    public function setFile($file)
    {
        $this->file = $file;

        if (is_string($file)) {
            $this->pathToFile = $file;
            $this->setFileName(pathinfo($file, PATHINFO_BASENAME));
            $this->mediaName = pathinfo($file, PATHINFO_FILENAME);

            return $this;
        }

        if ($file instanceof UploadedFile) {
            $this->pathToFile = $file->getPath().'/'.$file->getFilename();
            $this->setFileName($file->getClientOriginalName());
            $this->mediaName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            return $this;
        }

        if ($file instanceof SymfonyFile) {
            $this->pathToFile = $file->getPath().'/'.$file->getFilename();
            $this->setFileName(pathinfo($file->getFilename(), PATHINFO_BASENAME));
            $this->mediaName = pathinfo($file->getFilename(), PATHINFO_FILENAME);

            return $this;
        }

        throw UnknownType::create();
    }

    /**
     * When adding the file to the media library, the original file
     * will be preserved.
     *
     * @return $this
     */
    public function preservingOriginal()
    {
        $this->preserveOriginal = true;

        return $this;
    }

    /**
     * Set the name of the media object.
     *
     * @param string $name
     *
     * @return $this
     */
    public function usingName(string $name)
    {
        return $this->setName($name);
    }

    /**
     * Set the name of the media object.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name)
    {
        $this->mediaName = $name;

        return $this;
    }

    /**
     * Set the name of the file that is stored on disk.
     *
     * @param string $fileName
     *
     * @return $this
     */
    public function usingFileName(string $fileName)
    {
        return $this->setFileName($fileName);
    }

    /**
     * Set the name of the file that is stored on disk.
     *
     * @param string $fileName
     *
     * @return $this
     */
    public function setFileName(string $fileName)
    {
        $this->fileName = $this->sanitizeFileName($fileName);

        return $this;
    }

    /**
     * Set the metadata.
     *
     * @param array $customProperties
     *
     * @return $this
     */
    public function withCustomProperties(array $customProperties)
    {
        $this->customProperties = $customProperties;

        return $this;
    }

    /**
     * Set properties on the model.
     *
     * @param array $properties
     *
     * @return $this
     */
    public function withProperties(array $properties)
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * Set attributes on the model.
     *
     * @param array $properties
     *
     * @return $this
     */
    public function withAttributes(array $properties)
    {
        return $this->withProperties($properties);
    }

    /**
     * Add the given additional headers when copying the file to a remote filesystem.
     *
     * @param array $customRemoteHeaders
     *
     * @return $this
     */
    public function addCustomHeaders(array $customRemoteHeaders)
    {
        $this->filesystem->addCustomRemoteHeaders($customRemoteHeaders);

        return $this;
    }

    /**
     * @param string $collectionName
     *
     * @return Media
     *
     * @throws FileCannotBeAdded
     * @throws FileCannotBeAdded
     */
    public function toMediaLibraryOnCloudDisk(string $collectionName = 'default')
    {
        return $this->toMediaCollection($collectionName, config('filesystems.cloud'));
    }

	/**
	 * @param string $collectionName
	 * @param string $diskName
	 * @param $mediaRepo
	 * @return Media
	 * @throws FileDoesNotExist
	 * @throws FileIsTooBig
	 */
    public function toMediaCollection(string $collectionName = 'default', string $diskName = '', MediaRepository $mediaRepo = null)
    {
        if (! is_file($this->pathToFile)) {
            throw FileDoesNotExist::create($this->pathToFile);
        }

        if (filesize($this->pathToFile) > config('medialibrary.max_file_size')) {
            throw FileIsTooBig::create($this->pathToFile);
        }

        $mediaClass = config('medialibrary.media_model');

        /** @var Media $media */
        $media = new $mediaClass();

        $media->setModelId($this->subject->getId());
        $media->setModelType($this->subject->getModelType());

        $media->setName($this->mediaName);
        $media->setFileName($this->fileName);
        $media->setDisk($this->determineDiskName($diskName));

        $media->setCollectionName($collectionName);

        $media->setMimeType(File::getMimetype($this->pathToFile));
        $media->setSize(filesize($this->pathToFile));
        $media->setCustomProperties($this->customProperties);
        $media->setManipulation([]);

        $media->setCreatedAt(Carbon::now()->format('Y-m-d H:i:s'));
		$media->setUpdatedAt(Carbon::now()->format('Y-m-d H:i:s'));

		if($mediaRepo instanceof MediaRepository)
		{
			#Save to DB
			$mediaRepo->create($media);
		}
		else
		{
			/** @var MediaRepositoryContract $repository */
			$repository = $this->mediaService->getRepository();

			#Save to DB
			$repository->create($media);

		}


		#Save to local disk
        //$this->attachMedia($media);

        return $media;
    }

    /**
     * @deprecated Please use `toMediaCollection` instead
     *
     * @param string $collectionName
     * @param string $diskName
     *
     * @return Media
     *
     * @throws FileCannotBeAdded
     * @throws FileCannotBeAdded
     */
    public function toMediaLibrary(string $collectionName = 'default', string $diskName = '')
    {
        return $this->toMediaCollection($collectionName, $diskName);
    }

    /**
     * @param string $diskName
     *
     * @return string
     *
     * @throws FileCannotBeAdded
     */
    protected function determineDiskName(string $diskName)
    {
        if ($diskName === '') {
            $diskName = config('medialibrary.defaultFilesystem');
        }

        if (is_null(config("filesystems.disks.{$diskName}"))) {
            throw DiskDoesNotExist::create($diskName);
        }

        return $diskName;
    }

    /**
     * @param $fileName
     *
     * @return string
     */
    protected function sanitizeFileName(string $fileName): string
    {
        return str_replace(['#', '/', '\\'], '-', $fileName);
    }

    /**
     * @param Media $media
     */
    protected function attachMedia(Media $media)
    {
        //if (! $this->subject->exists)

		$this->subject->prepareToAttachMedia($media, $this);

		$model = $this->subject;

		$this->subject->processUnattachedMedia(function (Media $media, FileAdder $fileAdder) use ($model) {
			$this->processMediaItem($model, $media, $fileAdder);
		});

		return;
    }

    /**
     * @param HasMedia $model
     * @param Media $media
     * @param FileAdder $fileAdder
     */
    protected function processMediaItem(HasMedia $model, Media $media, FileAdder $fileAdder)
    {

        $this->filesystem->add($fileAdder->pathToFile, $media, $fileAdder->fileName);

        if (! $fileAdder->preserveOriginal) {
            unlink($fileAdder->pathToFile);
        }
    }
}
