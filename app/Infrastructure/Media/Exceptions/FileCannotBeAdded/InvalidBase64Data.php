<?php

namespace App\Infrastructure\Media\Exceptions\FileCannotBeAdded;

use App\Infrastructure\Media\Exceptions\FileCannotBeAdded;

class InvalidBase64Data extends FileCannotBeAdded
{
    public static function create()
    {
        return new static('Invalid base64 data provided');
    }
}
