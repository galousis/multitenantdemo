<?php

namespace App\Infrastructure\Media\Exceptions\FileCannotBeAdded;

use App\Infrastructure\Media\Exceptions\FileCannotBeAdded;

class UnknownType extends FileCannotBeAdded
{
    public static function create()
    {
        return new static('Only strings, FileObjects and UploadedFileObjects can be imported');
    }
}
