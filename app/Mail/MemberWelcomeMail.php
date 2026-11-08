<?php

namespace App\Mail;

use App\Models\Member;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MemberWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public User $user,
        public ?Member $member = null,
    ) {
        $this->member = $member ?? $user->member;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $memberId = $this->member?->member_number ? " [{$this->member->member_number}]" : '';

        return new Envelope(
            subject: "Welcome to Brands Academy Nigeria Foundation{$memberId} — Portal Access Activated",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.member-welcome',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
