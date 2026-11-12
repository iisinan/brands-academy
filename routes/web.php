<?php

use App\Http\Controllers\AdminConferenceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminForumController;
use App\Http\Controllers\AdminJournalController;
use App\Http\Controllers\AdminLegalDeskController;
use App\Http\Controllers\AdminLmsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\LegalServiceController;
use App\Http\Controllers\MemberCourseController;
use App\Http\Controllers\MemberFilingController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MembershipPaymentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\RegistryController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\WebinarController;
use App\Http\Controllers\WorkshopController;
use Illuminate\Support\Facades\Route;

// Public Institutional Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/certifications', [HomeController::class, 'certifications'])->name('certifications');
Route::post('/certifications/interest', [HomeController::class, 'registerInterest'])->name('certifications.interest');
Route::get('/partnerships', [PartnershipController::class, 'index'])->name('partnerships');
Route::post('/partnerships', [PartnershipController::class, 'store'])->name('partnerships.store');
Route::get('/faculty', [PartnershipController::class, 'faculty'])->name('faculty');
Route::get('/governance/code-of-ethics', [HomeController::class, 'ethics'])->name('legal.ethics');
Route::get('/privacy-policy', [HomeController::class, 'privacy'])->name('legal.privacy');
Route::get('/terms-of-service', [HomeController::class, 'terms'])->name('legal.terms');

// Legal Services: Brand IP, CAC & Trademark Desk
Route::get('/services/brand-ip-and-cac', [LegalServiceController::class, 'index'])->name('services.index');
Route::get('/services/file-new', [LegalServiceController::class, 'wizard'])->name('services.wizard');
Route::post('/services/file-new', [LegalServiceController::class, 'storeWizard'])->name('services.store');
Route::get('/services/filings/{trackingCode}/payment', [LegalServiceController::class, 'paymentSummary'])->name('services.payment');
Route::post('/services/filings/{trackingCode}/pay', [LegalServiceController::class, 'pay'])->name('services.pay');
Route::get('/services/filings/{trackingCode}/callback', [LegalServiceController::class, 'callback'])->name('services.callback');
Route::get('/verify-filing/{trackingCode?}', [LegalServiceController::class, 'track'])->name('services.track');
Route::get('/services/precheck', [LegalServiceController::class, 'precheck'])->name('services.precheck');
Route::get('/services/calculator', [LegalServiceController::class, 'calculator'])->name('services.calculator');

// Workshops & Cohorts (Time-Bound Windows)
Route::get('/workshops', [WorkshopController::class, 'index'])->name('workshops.index');
Route::get('/workshops/{slug}', [WorkshopController::class, 'show'])->name('workshops.show');
Route::post('/workshops/{slug}/apply', [WorkshopController::class, 'apply'])->name('workshops.apply');

// Short Courses & LMS (Self-Paced & Cohort Learning)
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');
Route::post('/courses/{slug}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
Route::get('/courses/{slug}/callback', [CourseController::class, 'callback'])->name('courses.callback');
Route::post('/courses/{slug}/reviews', [CourseController::class, 'storeReview'])->middleware('auth')->name('courses.reviews.store');

// Virtual Webinars & Masterclasses
Route::get('/webinars', [WebinarController::class, 'index'])->name('webinars.index');
Route::get('/webinars/{slug}', [WebinarController::class, 'show'])->name('webinars.show');
Route::post('/webinars/{slug}/register', [WebinarController::class, 'register'])->name('webinars.register');
Route::get('/webinars/{slug}/calendar', [WebinarController::class, 'calendar'])->name('webinars.calendar');
Route::post('/webinars/{slug}/questions', [WebinarController::class, 'submitQuestion'])->name('webinars.questions.store');
Route::post('/webinars/{slug}/questions/{questionId}/upvote', [WebinarController::class, 'upvoteQuestion'])->name('webinars.questions.upvote');

// Annual Conferences & Brand Summits
Route::get('/conferences', [ConferenceController::class, 'index'])->name('conferences.index');
Route::get('/conferences/{slug}', [ConferenceController::class, 'show'])->name('conferences.show');
Route::post('/conferences/{slug}/register', [ConferenceController::class, 'register'])->name('conferences.register');
Route::get('/conferences/{slug}/cfp', [ConferenceController::class, 'cfp'])->name('conferences.cfp');
Route::post('/conferences/{slug}/cfp', [ConferenceController::class, 'submitCfp'])->name('conferences.cfp.submit');
Route::get('/conferences/delegate/{badgeCode}', [ConferenceController::class, 'badge'])->name('conferences.badge');

// Academic & Practitioner Journal: JBSM
Route::get('/journal', [JournalController::class, 'index'])->name('journal.index');
Route::get('/journal/submit', [JournalController::class, 'submit'])->name('journal.submit');
Route::post('/journal/submit', [JournalController::class, 'storeSubmission'])->name('journal.store');
Route::get('/journal/articles/{slug}', [JournalController::class, 'show'])->name('journal.show');
Route::get('/journal/articles/{slug}/download', [JournalController::class, 'downloadPdf'])->name('journal.download');

// Community Discussion Board & Chatboard
Route::get('/community', [ForumController::class, 'index'])->name('forum.index');
Route::get('/community/channel/{slug}', [ForumController::class, 'channel'])->name('forum.channel');
Route::get('/community/new', [ForumController::class, 'create'])->middleware('auth')->name('forum.create');
Route::post('/community/new', [ForumController::class, 'store'])->middleware('auth')->name('forum.store');
Route::get('/community/{channelSlug}/{threadSlug}', [ForumController::class, 'show'])->name('forum.show');
Route::post('/community/{channelSlug}/{threadSlug}/reply', [ForumController::class, 'storeReply'])->middleware('auth')->name('forum.reply');
Route::post('/community/react/{type}/{id}', [ForumController::class, 'toggleReaction'])->middleware('auth')->name('forum.react');
Route::post('/community/replies/{replyId}/accept', [ForumController::class, 'acceptAnswer'])->middleware('auth')->name('forum.accept');

// Ongoing Membership (Evergreen 24/7)
Route::get('/membership/register', [MembershipController::class, 'create'])->name('membership.register');
Route::post('/membership/register', [MembershipController::class, 'store'])->name('membership.store');
Route::get('/membership/card/{token}', [MembershipController::class, 'card'])->name('membership.card');
Route::get('/membership/certificate/{token}/download', [MembershipController::class, 'downloadCertificate'])->name('membership.certificate.download');
Route::get('/membership/certificate/{token}/preview', [MembershipController::class, 'previewCertificate'])->name('membership.certificate.preview');

// Certified Brand Practitioners Registry & Verification
Route::get('/registry', [RegistryController::class, 'index'])->name('registry.index');
Route::get('/registry/{memberNumber}', [RegistryController::class, 'show'])->name('registry.show');

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

// Email Verification & In-App Notifications
Route::middleware('auth')->group(function (): void {
    Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])->name('verification.notice');
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // In-App Notification Center
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
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

    // Member LMS Classroom & Learning Hub
    Route::get('/member/courses', [MemberCourseController::class, 'index'])->name('member.courses.index');
    Route::get('/member/courses/{slug}/learn', [MemberCourseController::class, 'learn'])->name('member.courses.learn');
    Route::post('/member/courses/{slug}/lessons/{lessonId}/toggle', [MemberCourseController::class, 'toggleLesson'])->name('member.courses.lessons.toggle');
    Route::post('/member/courses/{slug}/quizzes/{quizId}/submit', [MemberCourseController::class, 'submitQuiz'])->name('member.courses.quizzes.submit');
    Route::post('/member/courses/{slug}/office-hours/book', [MemberCourseController::class, 'bookOfficeHours'])->name('member.courses.office-hours.book');
    Route::get('/member/courses/{slug}/resources/{resourceId}/download', [MemberCourseController::class, 'downloadResource'])->name('member.courses.resources.download');
    Route::post('/member/courses/{slug}/lessons/{lessonId}/notes', [MemberCourseController::class, 'saveNote'])->name('member.courses.lessons.notes');

    // Legal Filings & Business Registrations
    Route::get('/member/filings', [MemberFilingController::class, 'index'])->name('member.filings.index');
    Route::get('/member/filings/{trackingCode}', [MemberFilingController::class, 'show'])->name('member.filings.show');
    Route::post('/member/filings/{trackingCode}/upload', [MemberFilingController::class, 'uploadDocument'])->name('member.filings.upload');
    Route::get('/member/filings/{trackingCode}/certificate', [MemberFilingController::class, 'downloadCertificate'])->name('member.filings.certificate');

    // Official CPD Transcript & Dossier
    Route::get('/member/transcript', [MembershipController::class, 'transcript'])->name('member.transcript');
    Route::get('/member/transcript/download', [MembershipController::class, 'downloadTranscriptPdf'])->name('member.transcript.download');
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

    // LMS & Online Courses
    Route::get('/lms/courses', [AdminLmsController::class, 'courses'])->name('lms.courses');
    Route::get('/lms/courses/create', [AdminLmsController::class, 'createCourse'])->name('lms.courses.create');
    Route::post('/lms/courses', [AdminLmsController::class, 'storeCourse'])->name('lms.courses.store');
    Route::get('/lms/courses/{id}/edit', [AdminLmsController::class, 'editCourse'])->name('lms.courses.edit');
    Route::put('/lms/courses/{id}', [AdminLmsController::class, 'updateCourse'])->name('lms.courses.update');
    Route::delete('/lms/courses/{id}', [AdminLmsController::class, 'destroyCourse'])->name('lms.courses.destroy');

    // Modules & Lessons
    Route::post('/lms/courses/{courseId}/modules', [AdminLmsController::class, 'storeModule'])->name('lms.modules.store');
    Route::delete('/lms/courses/{courseId}/modules/{moduleId}', [AdminLmsController::class, 'destroyModule'])->name('lms.modules.destroy');
    Route::post('/lms/courses/{courseId}/modules/{moduleId}/lessons', [AdminLmsController::class, 'storeLesson'])->name('lms.lessons.store');
    Route::delete('/lms/courses/{courseId}/lessons/{lessonId}', [AdminLmsController::class, 'destroyLesson'])->name('lms.lessons.destroy');

    // Quizzes & Questions
    Route::post('/lms/courses/{courseId}/quizzes', [AdminLmsController::class, 'storeQuiz'])->name('lms.quizzes.store');
    Route::post('/lms/quizzes/{quizId}/questions', [AdminLmsController::class, 'storeQuizQuestion'])->name('lms.quizzes.questions.store');
    Route::delete('/lms/quizzes/{quizId}', [AdminLmsController::class, 'destroyQuiz'])->name('lms.quizzes.destroy');

    // Course Resources
    Route::post('/lms/courses/{courseId}/resources', [AdminLmsController::class, 'storeResource'])->name('lms.resources.store');
    Route::delete('/lms/resources/{resourceId}', [AdminLmsController::class, 'destroyResource'])->name('lms.resources.destroy');

    // Instructor Office Hours
    Route::post('/lms/courses/{courseId}/schedules', [AdminLmsController::class, 'storeInstructorSchedule'])->name('lms.schedules.store');
    Route::delete('/lms/schedules/{scheduleId}', [AdminLmsController::class, 'destroyInstructorSchedule'])->name('lms.schedules.destroy');

    // Webinars
    Route::get('/webinars', [AdminLmsController::class, 'webinars'])->name('webinars');
    Route::post('/webinars', [AdminLmsController::class, 'storeWebinar'])->name('webinars.store');
    Route::put('/webinars/{id}', [AdminLmsController::class, 'updateWebinar'])->name('webinars.update');
    Route::delete('/webinars/{id}', [AdminLmsController::class, 'destroyWebinar'])->name('webinars.destroy');
    Route::get('/webinars/{id}/export', [AdminLmsController::class, 'exportWebinarAttendees'])->name('webinars.export');

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

    // Legal Operations Desk & CAC / IP Filings
    Route::get('/filings', [AdminLegalDeskController::class, 'index'])->name('filings');
    Route::get('/filings/export', [AdminLegalDeskController::class, 'exportCsv'])->name('filings.export');
    Route::get('/filings/{id}', [AdminLegalDeskController::class, 'show'])->name('filings.show');
    Route::post('/filings/{id}/status', [AdminLegalDeskController::class, 'updateStatus'])->name('filings.status');
    Route::post('/filings/{id}/certificate', [AdminLegalDeskController::class, 'uploadCertificate'])->name('filings.certificate');

    // Conferences & Summits Management
    Route::get('/conferences', [AdminConferenceController::class, 'index'])->name('conferences');
    Route::post('/conferences', [AdminConferenceController::class, 'store'])->name('conferences.store');
    Route::get('/conferences/{id}', [AdminConferenceController::class, 'show'])->name('conferences.show');
    Route::post('/conferences/delegates/{id}/check-in', [AdminConferenceController::class, 'toggleCheckIn'])->name('conferences.checkin');
    Route::post('/conferences/cfp/{id}/review', [AdminConferenceController::class, 'reviewCfp'])->name('conferences.cfp.review');
    Route::get('/conferences/{id}/export', [AdminConferenceController::class, 'exportDelegates'])->name('conferences.export');

    // Journal (JBSM) Editorial Desk
    Route::get('/journal', [AdminJournalController::class, 'index'])->name('journal');
    Route::post('/journal/volumes', [AdminJournalController::class, 'storeVolume'])->name('journal.volumes.store');
    Route::post('/journal/issues', [AdminJournalController::class, 'storeIssue'])->name('journal.issues.store');
    Route::post('/journal/articles/{id}', [AdminJournalController::class, 'updateManuscript'])->name('journal.articles.update');

    // Community Forum Moderation Desk
    Route::get('/forum', [AdminForumController::class, 'index'])->name('forum');
    Route::post('/forum/threads/{thread}/pin', [AdminForumController::class, 'togglePin'])->name('forum.threads.pin');
    Route::post('/forum/threads/{thread}/lock', [AdminForumController::class, 'toggleLock'])->name('forum.threads.lock');
    Route::delete('/forum/threads/{thread}', [AdminForumController::class, 'destroyThread'])->name('forum.threads.destroy');
    Route::delete('/forum/replies/{reply}', [AdminForumController::class, 'destroyReply'])->name('forum.replies.destroy');
});
