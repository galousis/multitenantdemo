<?php

namespace App\Infrastructure\Media\Jobs;

use Illuminate\Bus\Queueable;
use App\Domain\Media\Entities\Media;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Infrastructure\Media\FileManipulator;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Infrastructure\Media\Conversion\ConversionCollection;

class PerformConversions implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Queueable;

    /** @var ConversionCollection */
    protected $conversions;

    /** @var Media */
    protected $media;

    public function __construct(ConversionCollection $conversions, Media $media)
    {
        $this->conversions = $conversions;

        $this->media = $media;
    }

    public function handle(): bool
    {
        app(FileManipulator::class)->performConversions($this->conversions, $this->media);

        return true;
    }
}
