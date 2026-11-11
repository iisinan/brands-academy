<?php

namespace App\Services\Video;

interface MeetingDriverInterface
{
    /**
     * Generate or format meeting link and access instructions.
     *
     * @param  array{title: string, starts_at?: string|\DateTimeInterface, duration_minutes?: int, custom_link?: ?string, passcode?: ?string}  $details
     * @return array{provider: string, join_url: string, passcode: ?string, instructions: string}
     */
    public function createMeeting(array $details): array;
}
