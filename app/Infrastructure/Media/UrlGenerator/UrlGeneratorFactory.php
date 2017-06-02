<?php

namespace App\Infrastructure\Media\UrlGenerator;

use App\Domain\Media\Entities\Media;
use App\Infrastructure\Media\Exceptions\InvalidUrlGenerator;
use App\Infrastructure\Media\PathGenerator\PathGeneratorFactory;

class UrlGeneratorFactory
{
    public static function createForMedia(Media $media) : UrlGenerator
    {
        $urlGeneratorClass = config('medialibrary.custom_url_generator_class')
            ?: 'App\Infrastructure\Media\UrlGenerator\\'.ucfirst($media->getDiskDriverName()).'UrlGenerator';

        static::guardAgainstInvalidUrlGenerator($urlGeneratorClass);

        $urlGenerator = app($urlGeneratorClass);
        $pathGenerator = PathGeneratorFactory::create();

        $urlGenerator
            ->setMedia($media)
            ->setPathGenerator($pathGenerator);

        return $urlGenerator;
    }

    public static function guardAgainstInvalidUrlGenerator(string $urlGeneratorClass)
    {
        if (! class_exists($urlGeneratorClass)) {
            throw InvalidUrlGenerator::doesntExist($urlGeneratorClass);
        }

        if (! is_subclass_of($urlGeneratorClass, UrlGenerator::class)) {
            throw InvalidUrlGenerator::isntAUrlGenerator($urlGeneratorClass);
        }
    }
}
