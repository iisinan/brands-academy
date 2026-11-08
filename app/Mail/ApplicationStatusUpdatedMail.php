<?php

namespace App\Mail;

use App\Models\WorkshopApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public WorkshopApplication $application,
        public string $status,
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $statusLabel = $this->status === 'waitlisted' ? 'Priority Waitlist Status' : 'Admissions Decision';

        return new Envelope(
            subject: "{$statusLabel}: {$this->application->workshop->title} — Brands Academy Nigeria Foundation",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.application-status-updated',
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
