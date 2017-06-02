<?php

namespace App\Infrastructure\Media\UrlGenerator;

use App\Domain\Media\Entities\Media;
use App\Infrastructure\Media\Conversion\Conversion;
use App\Infrastructure\Media\PathGenerator\PathGenerator;

interface UrlGenerator
{
    /**
     * Get the url for the profile of a media item.
     *
     * @return string
     */
    public function getUrl(): string;

    /**
     * @param Media $media
     *
     * @return UrlGenerator
     */
    public function setMedia(Media $media): UrlGenerator;

    /**
     * @param Conversion $conversion
     *
     * @return UrlGenerator
     */
    public function setConversion(Conversion $conversion): UrlGenerator;

    /**
     * Set the path generator class.
     *
     * @param PathGenerator $pathGenerator
     *
     * @return UrlGenerator
     */
    public function setPathGenerator(PathGenerator $pathGenerator): UrlGenerator;
}
