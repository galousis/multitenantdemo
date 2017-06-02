<?php

namespace App\Infrastructure\Media\Exceptions\FileCannotBeAdded;

use App\Domain\Tour\Entities\Tour;
use App\Infrastructure\Media\Exceptions\FileCannotBeAdded;

class ModelDoesNotExist extends FileCannotBeAdded
{
    public static function create(Tours $model)
    {
        $modelClass = get_class($model);

        return new static("Before adding media to it, you should first save the {$modelClass}-model");
    }
}
