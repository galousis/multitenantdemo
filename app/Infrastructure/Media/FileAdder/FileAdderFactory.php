<?php

namespace App\Infrastructure\Media\FileAdder;

use Illuminate\Support\Collection;
use App\Domain\Destination\Entities\Destination;

/**
 * Class FileAdderFactory
 * @package App\Infrastructure\Media\FileAdder
 */
class FileAdderFactory
{
    /**
     * @param Destination $subject
     * @param string|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return \Spatie\MediaLibrary\FileAdder\FileAdder
     */
    public static function create(Destination $subject, $file)
    {
        return app(FileAdder::class)
            ->setSubject($subject)
            ->setFile($file);
    }
}
