<?php
namespace App\Infrastructure\Media\Events;

use App\Domain\Media\Entities\Media;
use Illuminate\Queue\SerializesModels;

class MediaHasBeenAdded
{
    use SerializesModels;

    /** @var Media */
    public $media;

    /* @param Media $media */
    public function __construct(Media $media)
    {
        $this->media = $media;
    }
}
