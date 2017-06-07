<?php

namespace App\Infrastructure\Media\ImageGenerators\FileTypes;

use Illuminate\Support\Collection;
use App\Infrastructure\Media\Conversion\Conversion;
use App\Infrastructure\Media\ImageGenerators\BaseGenerator;

/**
 * Class Image
 * @package App\Infrastructure\Media\ImageGenerators\FileTypes
 */
class Image extends BaseGenerator
{
    public function convert(string $path, Conversion $conversion = null): string
    {
        return $path;
    }

    public function requirementsAreInstalled(): bool
    {
        return true;
    }

    public function supportedExtensions(): Collection
    {
        return collect(['png', 'jpg', 'jpeg', 'gif']);
    }

    public function supportedMimeTypes(): Collection
    {
        return collect(['image/jpeg', 'image/gif', 'image/png']);
    }
}
