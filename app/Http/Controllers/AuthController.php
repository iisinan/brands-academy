<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Mail\MemberWelcomeMail;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();

            return redirect()->route($user->getDashboardRoute());
        }

        return view('auth.login');
    }

    /**
     * Authenticate user credentials with smart RBAC role detection.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user();

            // If user is a member and has NOT verified their email, block access and redirect to verification notice
            if ($user->isMember() && ! $user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice')->with('warning', 'Please verify your email address to access your member dashboard. A verification link has been sent to your email.');
            }

            // If user is a member and has NOT paid their annual membership dues, redirect to payment checkout
            if ($user->isMember() && $user->member && ! $user->member->isPaid()) {
                return redirect()->route('membership.payment')->with('warning', 'Please complete your annual membership dues to unlock your member portal.');
            }

            // Smart RBAC: Resolve destination based on detected role
            $targetRoute = $user->getDashboardRoute();

            // Prevent non-admins from hitting stored admin URLs (avoids 403)
            $intendedUrl = session()->get('url.intended');
            if ($intendedUrl && ! $user->isAdmin() && str_contains($intendedUrl, '/admin')) {
                session()->forget('url.intended');
                $intendedUrl = null;
            }

            $welcomeMsg = $user->isAdmin()
                ? "Welcome back, {$user->name}! Authenticated as Administrator."
                : "Welcome back, {$user->name}! Authenticated as Member.";

            return redirect()->intended(route($targetRoute))->with('success', $welcomeMsg);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Smart real-time detection of user role by email for the login interface.
     */
    public function detectRole(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            return response()->json([
                'detected' => false,
            ]);
        }

        return response()->json([
            'detected' => true,
            'role' => $user->role instanceof UserRole ? $user->role->value : (string) $user->role,
            'role_label' => $user->role_label,
            'is_admin' => $user->isAdmin(),
            'badge_classes' => $user->role_badge_classes,
        ]);
    }

    /**
     * Log user out.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been signed out successfully.');
    }

    /**
     * Show request password reset form.
     */
    public function showForgotPasswordForm(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password reset link to user email.
     */
    public function sendResetLinkEmail(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show reset password form.
     */
    public function showResetPasswordForm(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    /**
     * Reset user password.
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, string $password): void {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    /**
     * Display the email verification notice.
     */
    public function showVerificationNotice(Request $request): View|RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route($user->getDashboardRoute());
        }

        return view('auth.verify-email');
    }

    /**
     * Mark the authenticated or link recipient's email address as verified.
     */
    public function verifyEmail(Request $request, int|string $id, string $hash): RedirectResponse
    {
        $user = User::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Invalid or expired email verification link.');
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));

            if (! $user->isMember() || ($user->member && $user->member->isPaid())) {
                try {
                    Mail::to($user->email)->send(new MemberWelcomeMail($user));
                } catch (\Throwable $e) {
                    Log::warning('Welcome email delivery notice: '.$e->getMessage());
                }
            }
        }

        if (! Auth::check()) {
            Auth::login($user);
        }

        // If user is a member and has not yet paid their membership dues, guide them to checkout
        if ($user->isMember() && $user->member && ! $user->member->isPaid()) {
            return redirect()->route('membership.payment')->with(
                'success',
                'Email verified successfully! Please complete your annual membership dues to activate your member portal access and digital credential.'
            );
        }

        return redirect()->route($user->getDashboardRoute())->with('success', 'Your email address has been successfully verified! You now have full access to your member portal.');
    }

    /**
     * Resend the email verification notification.
     */
    public function resendVerificationEmail(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route($user->getDashboardRoute());
        }

        $user->sendEmailVerificationNotification();

        return back()->with('success', "A fresh verification link has been sent to your email address: {$user->email}. Please check your inbox and your spam or junk folder.");
    }
}
