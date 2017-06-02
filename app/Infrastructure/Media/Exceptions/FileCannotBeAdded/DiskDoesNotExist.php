<?php

namespace App\Infrastructure\Media\Exceptions\FileCannotBeAdded;

use App\Infrastructure\Media\Exceptions\FileCannotBeAdded;

class DiskDoesNotExist extends FileCannotBeAdded
{
    public static function create(string $diskName)
    {
        return new static("There is no filesystem disk named `{$diskName}`");
    }
}
