<?php

namespace App\Infrastructure\Media\ImageGenerators;

use App\Domain\Media\Entities\Media;
use App\Infrastructure\Media\Conversion\Conversion;

/**
 * Interface ImageGenerator
 * @package App\Infrastructure\Media\ImageGenerators
 */
interface ImageGenerator
{
    public function canConvert(Media $media);

    /**
     * Receive a file and return a thumbnail in jpg/png format.
     *
     * @param string $path
     * @param Conversion|null $conversion
     *
     * @return string
     */
    public function convert(string $path, Conversion $conversion = null) : string;

    public function canHandleMime(string $mime = ''): bool;

    public function canHandleExtension(string $extension = ''): bool;

    public function getType(): string;
}
