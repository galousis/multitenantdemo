<?php

namespace App\Infrastructure\Media\UrlGenerator;

use App\Domain\Media\Entities\Media;
use App\Infrastructure\Media\Conversion\Conversion;
use App\Infrastructure\Media\PathGenerator\PathGenerator;
use Illuminate\Contracts\Config\Repository as Config;

abstract class BaseUrlGenerator implements UrlGenerator
{
    /** @var Media */
    protected $media;

    /** @var Conversion */
    protected $conversion;

    /** @var PathGenerator */
    protected $pathGenerator;

    /** @var \Illuminate\Contracts\Config\Repository */
    protected $config;

    /** @param \Illuminate\Contracts\Config\Repository $config */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param Media $media
     *
     * @return UrlGenerator
     */
    public function setMedia(Media $media): UrlGenerator
    {
        $this->media = $media;

        return $this;
    }

    /**
     * @param Conversion $conversion
     *
     * @return UrlGenerator
     */
    public function setConversion(Conversion $conversion): UrlGenerator
    {
        $this->conversion = $conversion;

        return $this;
    }

    /**
     * @param PathGenerator $pathGenerator
     *
     * @return UrlGenerator
     */
    public function setPathGenerator(PathGenerator $pathGenerator): UrlGenerator
    {
        $this->pathGenerator = $pathGenerator;

        return $this;
    }

    /*
     * Get the path to the requested file relative to the root of the media directory.
     */
    public function getPathRelativeToRoot(): string
    {
        if (is_null($this->conversion)) {
            return $this->pathGenerator->getPath($this->media).($this->media->getFileName());
        }

        return $this->pathGenerator->getPathForConversions($this->media)
        .$this->conversion->getName()
        .'.'
        .$this->conversion->getResultExtension($this->media->extension);
    }
}
