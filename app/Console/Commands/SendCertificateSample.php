<?php

namespace App\Console\Commands;

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\MembershipController;
use App\Mail\CertificateSampleMail;
use App\Models\Certificate;
use App\Models\Member;
use App\Models\Workshop;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

#[Signature('certificate:send-sample {email=sinanismailaidris@gmail.com : Recipient email address}')]
#[Description('Render high-resolution PDF certificate samples with genuine barcodes and email them')]
class SendCertificateSample extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = (string) $this->argument('email');

        $this->info("Preparing certificate samples for {$email}...");

        // 1. Resolve or prepare workshop certificate sample
        $certificate = Certificate::with(['workshop', 'member'])->latest('issued_at')->first();

        if (! $certificate) {
            $workshop = Workshop::first() ?? Workshop::create([
                'title' => 'Executive Brand Strategy & Corporate Identity Masterclass',
                'slug' => 'executive-brand-strategy-'.Str::random(5),
                'track_type' => 'masterclass',
                'description' => 'Flagship cohort for executive brand leadership and institutional governance.',
                'status' => 'published',
                'starts_at' => now()->subWeeks(2),
                'ends_at' => now(),
                'application_starts_at' => now()->subMonth(),
                'application_deadline' => now()->subWeeks(3),
                'fee_type' => 'paid',
                'fee_amount' => 150000,
                'capacity' => 30,
            ]);

            $certificate = Certificate::create([
                'certificate_number' => 'BANF-CERT-'.date('Y').'-'.strtoupper(Str::random(6)),
                'verification_token' => (string) Str::uuid(),
                'workshop_id' => $workshop->id,
                'recipient_name' => 'Dr. Sinan Ismaila Idris',
                'recipient_email' => $email,
                'course_title' => $workshop->title,
                'track_tier' => 'Tier 1: Certified Brand Associate (CBA)',
                'issued_at' => now()->toDateString(),
                'email_status' => 'pending',
            ]);
        }

        // 2. Resolve or prepare member sample
        $member = Member::whereNotNull('qr_code_token')->latest('joined_at')->first();

        if (! $member) {
            $member = Member::create([
                'user_id' => null,
                'member_number' => 'BANF-MBR-'.date('Y').'-'.strtoupper(Str::random(5)),
                'qr_code_token' => (string) Str::uuid(),
                'first_name' => 'Sinan',
                'last_name' => 'Idris',
                'title' => 'Dr.',
                'email' => $email,
                'phone' => '+234 803 000 0000',
                'category' => 'fellow',
                'payment_status' => 'paid',
                'paid_at' => now(),
                'joined_at' => now(),
                'state' => 'Abuja FCT',
                'country' => 'Nigeria',
                'institution_or_company' => 'Brands Academy Nigeria Foundation',
                'designation' => 'Director-General & Trustee',
            ]);
        }

        $workshopVerifyUrl = route('verify.certificate', $certificate->verification_token);
        $membershipVerifyUrl = route('verify.certificate', $member->qr_code_token);

        $this->line("Workshop Certificate: #{$certificate->certificate_number}");
        $this->line("Membership Certificate: #{$member->member_number}");

        // 3. Render official PDFs with Code-128 linear barcodes & QR codes
        $this->info('Rendering vector DomPDF documents with authentic barcodes...');
        $certController = app(CertificateController::class);
        $workshopPdf = $certController->renderPdf($certificate);
        $workshopPdfData = $workshopPdf->output();

        $memberController = app(MembershipController::class);
        $membershipPdf = $memberController->renderCertificatePdf($member);
        $membershipPdfData = $membershipPdf->output();

        // 4. Dispatch Email
        $this->info("Dispatching email to {$email} via configured mailer...");
        Mail::to($email)->send(new CertificateSampleMail(
            recipientName: $member->full_name ?? 'Dr. Sinan Ismaila Idris',
            workshopCertificate: $certificate,
            membership: $member,
            workshopVerifyUrl: $workshopVerifyUrl,
            membershipVerifyUrl: $membershipVerifyUrl,
            workshopPdfData: $workshopPdfData,
            membershipPdfData: $membershipPdfData,
        ));

        $this->info("Certificate samples successfully delivered to {$email}!");

        return self::SUCCESS;
    }
}
