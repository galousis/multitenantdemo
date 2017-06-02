<?php
namespace App\Infrastructure\Media\Events;

use App\Domain\Media\Entities\Media;
use Illuminate\Queue\SerializesModels;
use App\Infrastructure\Media\Conversion\Conversion;

class ConversionHasBeenCompleted
{
    use SerializesModels;

    /** @var Media */
    public $media;

    /** @var Conversion */
    public $conversion;

    /**
     * @param Media $media
     * @param Conversion $conversion
     */
    public function __construct(Media $media, Conversion $conversion)
    {
        $this->media = $media;

        $this->conversion = $conversion;
    }
}
