@extends('layouts.app')

@section('title', 'Verify Email - Brands Academy Nigeria Foundation')

@push('styles')
<style>
    @keyframes checkmarkPop {
        0% { transform: scale(0) rotate(-15deg); opacity: 0; }
        60% { transform: scale(1.2) rotate(4deg); opacity: 1; }
        100% { transform: scale(1) rotate(0deg); opacity: 1; }
    }
    @keyframes pulseRing {
        0% { transform: scale(0.95); opacity: 0.8; }
        50% { transform: scale(1.08); opacity: 0.3; }
        100% { transform: scale(0.95); opacity: 0.8; }
    }
    .anim-check-pop {
        animation: checkmarkPop 0.36s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        transform-origin: center center;
    }
    .anim-pulse-ring {
        animation: pulseRing 2.4s infinite ease-in-out;
    }
</style>
@endpush

@section('content')

<section class="min-h-[75vh] flex items-center justify-center py-14 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Ambient background illumination -->
    <div class="absolute -top-32 -left-32 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-lg bg-white rounded-3xl border border-slate-200 p-7 sm:p-10 shadow-2xl relative z-10">
        <!-- Top accent gradient line -->
        <div class="h-1.5 w-full bg-gradient-to-r from-amber-500 via-amber-400 to-emerald-500 absolute top-0 left-0 rounded-t-3xl"></div>

        <div class="text-center mb-6">
            <!-- Mail Icon with Pulsing Halo -->
            <div class="relative w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                <div class="absolute inset-0 rounded-2xl bg-amber-500/20 anim-pulse-ring"></div>
                <div class="relative w-14 h-14 rounded-2xl bg-amber-500 text-slate-900 flex items-center justify-center shadow-lg shadow-amber-500/30">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>

            <x-brand-logo class="w-10 h-10 mx-auto mb-2 drop-shadow-sm opacity-90" />
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-serif-title tracking-tight">Verify Your Email</h1>
            <p class="text-xs font-semibold uppercase tracking-wider text-amber-600 mt-1">Portal Access Locked Until Verified</p>
        </div>

        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl mb-6 text-xs font-medium anim-check-pop flex items-start gap-2.5 shadow-xs">
                <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <div>
                    <span class="font-bold block">Verification Email Dispatched</span>
                    <span>{{ session('success') }}</span>
                    <span class="block mt-1.5 font-semibold text-emerald-900 text-[11px] flex items-center gap-1">
                        <span>&#128233;</span> Tip: If it does not appear in your primary inbox, please check your <strong>Spam</strong> or <strong>Junk</strong> folder.
                    </span>
                </div>
            </div>
        @endif

        @if (session('warning'))
            <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-2xl mb-6 text-xs font-medium anim-check-pop flex items-start gap-2.5 shadow-xs">
                <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <span class="font-bold block">Action Required</span>
                    <span>{{ session('warning') }}</span>
                </div>
            </div>
        @endif

        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 sm:p-5 mb-6 text-xs text-slate-600 space-y-3 leading-relaxed">
            <p>
                Thanks for registering! Before accessing your <strong>Member Dashboard</strong>, workshop cohort materials, and credential services, please confirm your email address by clicking the verification link we just emailed to:
            </p>
            <div class="bg-white border border-slate-200 px-3.5 py-2.5 rounded-xl font-mono text-xs font-bold text-slate-900 flex items-center justify-between">
                <span>{{ auth()->user()->email }}</span>
                <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-wider text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">
                    Pending
                </span>
            </div>

            <!-- Prominent Spam / Junk Alert Callout -->
            <div class="bg-amber-50/90 border border-amber-200/90 rounded-xl p-3 text-[11.5px] text-amber-950 flex items-start gap-2.5 shadow-xs">
                <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <span class="font-bold">Can't find the email in your inbox?</span> Please check your <strong>Spam</strong>, <strong>Junk</strong>, or <strong>Promotions</strong> folder as automated verification emails may occasionally land there. If found, mark it as <em>"Not Spam"</em> so you receive all cohort and certificate notices.
                </div>
            </div>

            <p class="text-[11px] text-slate-500">
                If you still have not received the verification email after a few minutes, click the button below to request a fresh link.
            </p>
        </div>

        <div class="space-y-3">
            <form action="{{ route('verification.send') }}" method="POST">
                @csrf
                <button 
                    type="submit"
                    class="w-full py-3.5 px-4 rounded-xl font-bold text-xs uppercase tracking-wider bg-slate-900 hover:bg-slate-800 text-amber-400 hover:text-amber-300 border border-slate-800 transition shadow-md hover:shadow-lg flex items-center justify-center gap-2 cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Resend Verification Email
                </button>
            </form>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button 
                    type="submit"
                    class="w-full py-2.5 px-4 rounded-xl font-semibold text-xs text-slate-500 hover:text-slate-800 transition text-center cursor-pointer"
                >
                    Sign out and use a different account
                </button>
            </form>
        </div>

        <div class="mt-6 pt-5 border-t border-slate-100 text-center">
            <p class="text-[11px] text-slate-400">
                Need institutional support? Reach our Secretariat at <a href="mailto:info@brandsacademy.org" class="text-amber-600 hover:underline">info@brandsacademy.org</a>
            </p>
        </div>
    </div>
</section>

@endsection
