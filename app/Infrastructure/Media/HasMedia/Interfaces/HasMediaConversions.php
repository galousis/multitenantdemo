<?php

namespace App\Infrastructure\Media\HasMedia\Interfaces;

/**
 * Interface HasMediaConversions
 * @package App\Infrastructure\Media\HasMedia\Interfaces
 */
interface HasMediaConversions extends HasMedia
{
    /**
     * Register the conversions that should be performed.
     *
     * @return array
     */
    public function registerMediaConversions();
}
