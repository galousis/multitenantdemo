<?php

namespace App\Infrastructure\Media\Exceptions\FileCannotBeAdded;

use App\Infrastructure\Media\Helpers\File;
use App\Infrastructure\Media\Exceptions\FileCannotBeAdded;

class FileIsTooBig extends FileCannotBeAdded
{
    public static function create(string $path)
    {
        $fileSize = File::getHumanReadableSize(filesize($path));

        $maxFileSize = File::getHumanReadableSize(config('medialibrary.max_file_size'));

        return new static("File `{$path}` has a size of {$fileSize} which is greater than the maximum allowed {$maxFileSize}");
    }
}
