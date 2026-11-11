<?php

namespace App\Services\Video;

use Illuminate\Support\Str;

class GoogleMeetDriver implements MeetingDriverInterface
{
    /**
     * Generate or resolve a Google Meet link.
     */
    public function createMeeting(array $details): array
    {
        $customLink = $details['custom_link'] ?? null;

        if (! empty($customLink) && str_contains($customLink, 'meet.google.com/')) {
            $joinUrl = $customLink;
        } else {
            // Generate standard clean meet room code: e.g. ban-faca-dem
            $segment1 = 'ban';
            $segment2 = strtolower(Str::random(4));
            $segment3 = strtolower(Str::random(3));
            $joinUrl = ! empty($customLink) ? $customLink : "https://meet.google.com/{$segment1}-{$segment2}-{$segment3}";
        }

        return [
            'provider' => 'google_meet',
            'join_url' => $joinUrl,
            'passcode' => null,
            'instructions' => 'Click the link directly from your browser or Google Meet app. Ensure your microphone is muted upon joining.',
        ];
    }
}
