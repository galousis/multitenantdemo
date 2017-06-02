<?php

namespace App\Infrastructure\Media\Exceptions\FileCannotBeAdded;

use App\Infrastructure\Media\Helpers\File;
use App\Infrastructure\Media\Exceptions\FileCannotBeAdded;

class FileDoesNotExist extends FileCannotBeAdded
{
    public static function create(string $path)
    {
        return new static("File `{$path}` does not exist");
    }
}
