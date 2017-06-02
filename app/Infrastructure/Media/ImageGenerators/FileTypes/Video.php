<?php

namespace App\Infrastructure\Media\ImageGenerators\FileTypes;

use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;
use Illuminate\Support\Collection;
use App\Infrastructure\Media\Conversion\Conversion;
use App\Infrastructure\Media\ImageGenerators\BaseGenerator;

class Video extends BaseGenerator
{
    public function convert(string $file, Conversion $conversion = null): string
    {
        $imageFile = pathinfo($file, PATHINFO_DIRNAME).'/'.pathinfo($file, PATHINFO_FILENAME).'.jpg';

        $ffmpeg = FFMpeg::create([
            'ffmpeg.binaries' => config('medialibrary.ffmpeg_binaries'),
            'ffprobe.binaries' => config('medialibrary.ffprobe_binaries'),
        ]);

        $video = $ffmpeg->open($file);

        $seconds = $conversion ? $conversion->getExtractVideoFrameAtSecond() : 0;

        $frame = $video->frame(TimeCode::fromSeconds($seconds));
        $frame->save($imageFile);

        return $imageFile;
    }

    public function requirementsAreInstalled(): bool
    {
        return class_exists('\\FFMpeg\\FFMpeg');
    }

    public function supportedExtensions(): Collection
    {
        return collect(['webm', 'mov', 'mp4']);
    }

    public function supportedMimeTypes(): Collection
    {
        return collect(['video/webm', 'video/mpeg', 'video/mp4', 'video/quicktime']);
    }
}
