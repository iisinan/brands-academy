<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MembershipPaymentController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\WorkshopController;
use Illuminate\Support\Facades\Route;

// Public Institutional Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/partnerships', [PartnershipController::class, 'index'])->name('partnerships');
Route::post('/partnerships', [PartnershipController::class, 'store'])->name('partnerships.store');
Route::get('/faculty', [PartnershipController::class, 'faculty'])->name('faculty');

// Workshops & Cohorts (Time-Bound Windows)
Route::get('/workshops', [WorkshopController::class, 'index'])->name('workshops.index');
Route::get('/workshops/{slug}', [WorkshopController::class, 'show'])->name('workshops.show');
Route::post('/workshops/{slug}/apply', [WorkshopController::class, 'apply'])->name('workshops.apply');

// Ongoing Membership (Evergreen 24/7)
Route::get('/membership/register', [MembershipController::class, 'create'])->name('membership.register');
Route::post('/membership/register', [MembershipController::class, 'store'])->name('membership.store');
Route::get('/membership/card/{token}', [MembershipController::class, 'card'])->name('membership.card');
Route::get('/membership/certificate/{token}/download', [MembershipController::class, 'downloadCertificate'])->name('membership.certificate.download');
Route::get('/membership/certificate/{token}/preview', [MembershipController::class, 'previewCertificate'])->name('membership.certificate.preview');

// Credential Verification & Download
Route::get('/verify/{token?}', [VerificationController::class, 'index'])->name('verify.certificate');
Route::get('/certificates/{token}/download', [CertificateController::class, 'download'])->name('certificates.download');
Route::get('/certificates/{token}/preview', [CertificateController::class, 'preview'])->name('certificates.preview');

// Authentication
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/login/detect-role', [AuthController::class, 'detectRole'])->name('login.detect-role');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Email Verification
Route::middleware('auth')->group(function (): void {
    Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])->name('verification.notice');
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

// Membership Dues Payment Gate (Requires Auth, Member/Admin Role, and Verified Email)
Route::middleware(['auth', 'role:member,admin', 'verified'])->group(function (): void {
    Route::get('/membership/payment', [MembershipPaymentController::class, 'showPaymentPage'])->name('membership.payment');
    Route::post('/membership/payment/initialize', [MembershipPaymentController::class, 'initializePaystack'])->name('membership.payment.initialize');
    Route::get('/membership/payment/callback', [MembershipPaymentController::class, 'handlePaystackCallback'])->name('membership.payment.callback');
    Route::post('/membership/payment/bank-transfer', [MembershipPaymentController::class, 'submitBankTransfer'])->name('membership.payment.bank-transfer');
});

// Paystack Webhook (Public POST server-to-server listener)
Route::post('/membership/payment/webhook', [MembershipPaymentController::class, 'handleWebhook'])->name('membership.payment.webhook');

// Member Protected Portal (Requires Auth, Member/Admin Role, Verified Email, AND Paid Dues)
Route::middleware(['auth', 'role:member,admin', 'verified', 'membership.paid'])->group(function (): void {
    Route::get('/member/dashboard', [MembershipController::class, 'dashboard'])->name('member.dashboard');
    Route::post('/member/profile', [MembershipController::class, 'updateProfile'])->name('member.profile.update');
    Route::post('/member/password', [MembershipController::class, 'updatePassword'])->name('member.password.update');
    Route::get('/member/applications/{id}/submit-portfolio', [MembershipController::class, 'submitPortfolio'])->name('member.portfolio.create');
    Route::post('/member/applications/{id}/submit-portfolio', [MembershipController::class, 'storePortfolio'])->name('member.portfolio.store');
});

// Admin Protected Area
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', [AdminController::class, 'dashboard']);
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::post('/users/{id}/role', [AdminController::class, 'updateUserRole'])->name('users.role');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::get('/members', [AdminController::class, 'members'])->name('members');
    Route::get('/members/export', [AdminController::class, 'exportMembers'])->name('members.export');
    Route::put('/members/{id}', [AdminController::class, 'updateMember'])->name('members.update');
    Route::post('/members/{id}/resend-welcome', [AdminController::class, 'resendMemberWelcome'])->name('members.resend-welcome');
    Route::post('/members/{member}/payment-status', [AdminController::class, 'updateMemberPaymentStatus'])->name('members.payment-status');

    // Workshop management & cohorts
    Route::get('/workshops', [AdminController::class, 'workshops'])->name('workshops');
    Route::get('/workshops/create', [AdminController::class, 'createWorkshop'])->name('workshops.create');
    Route::post('/workshops', [AdminController::class, 'storeWorkshop'])->name('workshops.store');
    Route::get('/workshops/{id}/edit', [AdminController::class, 'editWorkshop'])->name('workshops.edit');
    Route::put('/workshops/{id}', [AdminController::class, 'updateWorkshop'])->name('workshops.update');
    Route::delete('/workshops/{id}', [AdminController::class, 'destroyWorkshop'])->name('workshops.destroy');
    Route::post('/workshops/{id}/bulk-issue-certificates', [AdminController::class, 'bulkIssueCertificates'])->name('workshops.bulk-issue-certificates');
    Route::post('/workshops/{id}/toggle-status', [AdminController::class, 'toggleWorkshopStatus'])->name('workshops.toggle-status');
    Route::post('/workshops/{id}/toggle-featured', [AdminController::class, 'toggleWorkshopFeatured'])->name('workshops.toggle-featured');

    // Admissions & Applications Review
    Route::get('/applications', [AdminController::class, 'applications'])->name('applications');
    Route::post('/applications/{id}/status', [AdminController::class, 'updateApplicationStatus'])->name('applications.status');
    Route::post('/applications/{id}/issue-certificate', [AdminController::class, 'issueCertificate'])->name('applications.issue-certificate');

    // Portfolio Submissions Evaluation
    Route::get('/submissions', [AdminController::class, 'submissions'])->name('submissions');
    Route::post('/submissions/{id}/evaluate', [AdminController::class, 'evaluateSubmission'])->name('submissions.evaluate');

    // Certificates & Email Dispatch
    Route::get('/certificates', [AdminController::class, 'certificates'])->name('certificates');
    Route::get('/certificates/export', [AdminController::class, 'exportCertificates'])->name('certificates.export');
    Route::post('/certificates/send-sample', [AdminController::class, 'sendCertificateSample'])->name('certificates.send-sample');
    Route::post('/certificates/{token}/email', [CertificateController::class, 'email'])->name('certificates.email');

    // Institutional Partnerships & Inquiries
    Route::get('/inquiries', [AdminController::class, 'inquiries'])->name('inquiries');
    Route::get('/inquiries/export', [AdminController::class, 'exportInquiriesCsv'])->name('inquiries.export');
    Route::post('/inquiries/{id}/status', [AdminController::class, 'updateInquiryStatus'])->name('inquiries.status');

    // 4. Finance & Payment Monitoring
    Route::get('/finance', [AdminController::class, 'finance'])->name('finance');
    Route::post('/finance/manual', [AdminController::class, 'recordManualPayment'])->name('finance.manual');
    Route::post('/finance/{id}/verify', [AdminController::class, 'verifyPayment'])->name('finance.verify');
    Route::get('/finance/export', [AdminController::class, 'exportFinanceCsv'])->name('finance.export');
});
