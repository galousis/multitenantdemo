<?php

namespace App\Infrastructure\Media\Exceptions\FileCannotBeAdded;

use App\Infrastructure\Media\Helpers\File;
use App\Infrastructure\Media\Exceptions\FileCannotBeAdded;

class RequestDoesNotHaveFile extends FileCannotBeAdded
{
    public static function create($key)
    {
        return new static("The current request does not have a file in a key named `{$key}`");
    }
}
