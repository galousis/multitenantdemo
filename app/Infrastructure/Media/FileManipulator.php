<?php
namespace App\Infrastructure\Media;

use Spatie\Image\Image;
use Illuminate\Support\Facades\File;
use App\Domain\Media\Entities\Media;
use Illuminate\Contracts\Bus\Dispatcher;
use App\Infrastructure\Media\Conversion\Conversion;
use App\Infrastructure\Media\Filesystem\Filesystem;
use App\Infrastructure\Media\Jobs\PerformConversions;
use Spatie\TemporaryDirectory\TemporaryDirectory;
use App\Infrastructure\Media\ImageGenerators\ImageGenerator;
use App\Infrastructure\Media\Conversion\ConversionCollection;
use App\Infrastructure\Media\Events\ConversionHasBeenCompleted;
use App\Infrastructure\Media\Helpers\File as MediaLibraryFileHelper;

class FileManipulator
{
    /**
     * Create all derived files for the given media.
     *
     * @param Media $media
     */
    public function createDerivedFiles(Media $media)
    {
        $profileCollection = ConversionCollection::createForMedia($media);

        $this->performConversions(
            $profileCollection->getNonQueuedConversions($media->getCollectionName()),
            $media
        );

        $queuedConversions = $profileCollection->getQueuedConversions($media->getCollectionName());

        if ($queuedConversions->isNotEmpty()) {
            $this->dispatchQueuedConversions($media, $queuedConversions);
        }
    }

    /**
     * Perform the given conversions for the given media.
     *
     * @param ConversionCollection $conversions
     * @param Media $media
     */
    public function performConversions(ConversionCollection $conversions, Media $media)
    {
        if ($conversions->isEmpty()) {
            return;
        }

        $imageGenerator = $this->determineImageGenerator($media);

        if (! $imageGenerator) {
            return;
        }

        $temporaryDirectory = new TemporaryDirectory($this->getTemporaryDirectoryPath());

        $copiedOriginalFile = app(Filesystem::class)->copyFromMediaLibrary(
            $media,
            $temporaryDirectory->path(str_random(16).'.'.$media->extension)
        );

        foreach ($conversions as $conversion) {
            $copiedOriginalFile = $imageGenerator->convert($copiedOriginalFile, $conversion);

            $conversionResult = $this->performConversion($media, $conversion, $copiedOriginalFile);

            $newFileName = $conversion->getName()
                .'.'
                .$conversion->getResultExtension(pathinfo($copiedOriginalFile, PATHINFO_EXTENSION));

            $renamedFile = MediaLibraryFileHelper::renameInDirectory($conversionResult, $newFileName);

            app(Filesystem::class)->copyToMediaLibrary($renamedFile, $media, true);

            event(new ConversionHasBeenCompleted($media, $conversion));
        }

        $temporaryDirectory->delete();
    }

    public function performConversion(Media $media, Conversion $conversion, string $imageFile): string
    {
        $conversionTempFile = pathinfo($imageFile, PATHINFO_DIRNAME).'/'.str_random(16)
            .$conversion->getName()
            .'.'
            .$media->extension;

        File::copy($imageFile, $conversionTempFile);

        $supportedFormats = ['jpg', 'pjpg', 'png', 'gif'];
        if ($conversion->shouldKeepOriginalImageFormat() && in_array($media->extension, $supportedFormats)) {
            $conversion->format($media->extension);
        }

        Image::load($conversionTempFile)
            ->useImageDriver(config('medialibrary.image_driver'))
            ->manipulate($conversion->getManipulations())
            ->save();

        return $conversionTempFile;
    }

    protected function dispatchQueuedConversions(Media $media, ConversionCollection $queuedConversions)
    {
        $job = new PerformConversions($queuedConversions, $media);

        if ($customQueue = config('medialibrary.queue_name')) {
            $job->onQueue($customQueue);
        }

        app(Dispatcher::class)->dispatch($job);
    }

    protected function getTemporaryDirectoryPath(): string
    {
        $path = is_null(config('medialibrary.temporary_directory_path'))
            ? storage_path('medialibrary/temp')
            : config('medialibrary.temporary_directory_path');

        return $path.DIRECTORY_SEPARATOR.str_random(32);
    }

    /**
     * @param Media $media
     *
     * @return ImageGenerator|null
     */
    public function determineImageGenerator(Media $media)
    {
        return $media->getImageGenerators()
            ->map(function (string $imageGeneratorClassName) {
                return app($imageGeneratorClassName);
            })
            ->first(function (ImageGenerator $imageGenerator) use ($media) {
                return $imageGenerator->canConvert($media);
            });
    }
}
