<?php

namespace App\Services\Video;

use Illuminate\Support\Str;

class ZoomDriver implements MeetingDriverInterface
{
    /**
     * Generate or resolve a Zoom meeting link.
     */
    public function createMeeting(array $details): array
    {
        $customLink = $details['custom_link'] ?? null;
        $passcode = $details['passcode'] ?? strtoupper(Str::random(6));

        $joinUrl = ! empty($customLink)
            ? $customLink
            : 'https://zoom.us/j/'.rand(80000000000, 89999999999).'?pwd='.$passcode;

        return [
            'provider' => 'zoom',
            'join_url' => $joinUrl,
            'passcode' => $passcode,
            'instructions' => 'Join using the Zoom desktop or mobile client. Enter passcode if prompted.',
        ];
    }
}
