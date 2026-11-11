<?php

namespace App\Services\Video;

class VideoMeetingManager
{
    /**
     * @var array<string, MeetingDriverInterface>
     */
    protected array $drivers = [];

    public function driver(?string $name = null): MeetingDriverInterface
    {
        $name = $name ?: config('services.video.default', 'google_meet');

        if (! isset($this->drivers[$name])) {
            $this->drivers[$name] = match ($name) {
                'google_meet' => new GoogleMeetDriver,
                'zoom' => new ZoomDriver,
                default => new GoogleMeetDriver,
            };
        }

        return $this->drivers[$name];
    }
}
