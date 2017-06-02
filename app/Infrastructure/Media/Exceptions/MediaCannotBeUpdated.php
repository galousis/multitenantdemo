<?php

namespace App\Infrastructure\Media\Exceptions;

use Exception;
use App\Domain\Media\Entities\Media;

class MediaCannotBeUpdated extends Exception
{
    public static function doesNotBelongToCollection(string $collectionName, Media $media)
    {
        return new static("Media id {$media->getId()} is not part of collection `{$collectionName}`");
    }
}
