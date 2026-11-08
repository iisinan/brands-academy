<?php

namespace App\Mail;

use App\Models\Certificate;
use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CertificateSampleMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public string $recipientName,
        public Certificate $workshopCertificate,
        public Member $membership,
        public string $workshopVerifyUrl,
        public string $membershipVerifyUrl,
        public ?string $workshopPdfData = null,
        public ?string $membershipPdfData = null,
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Official Credential Samples: Certificate of Achievement & Certificate of Membership — Brands Academy Nigeria Foundation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.certificate-sample',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        if ($this->workshopPdfData) {
            $attachments[] = Attachment::fromData(
                fn () => $this->workshopPdfData,
                "Brands_Academy_Certificate_of_Achievement_{$this->workshopCertificate->certificate_number}.pdf"
            )->withMime('application/pdf');
        }

        if ($this->membershipPdfData) {
            $attachments[] = Attachment::fromData(
                fn () => $this->membershipPdfData,
                "Brands_Academy_Membership_Certificate_{$this->membership->member_number}.pdf"
            )->withMime('application/pdf');
        }

        return $attachments;
    }
}
