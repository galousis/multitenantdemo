<?php

namespace App\Infrastructure\Media\Exceptions;

use Exception;
use App\Domain\Media\Entities\Media;
use App\Domain\Tour\Entities\Tour;
use Illuminate\Database\Eloquent\Model;

class MediaCannotBeDeleted extends Exception
{
    public static function doesNotBelongToModel(Media $media, Tour $model)
    {
        $modelClass = get_class($model);

        return new static("Media with id {$media->getId()} cannot be deleted because it does not belong to model {$modelClass} with id {$model->getId()}");
    }
}
