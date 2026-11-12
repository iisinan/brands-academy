@extends('layouts.app')

@section('title', 'Access Forbidden (403) | Brands Academy Nigeria Foundation')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-xl w-full text-center">
        <!-- Error Pill -->
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-500/10 text-rose-700 border border-rose-500/20 mb-6">
            <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
            Error 403 &bull; Access Restricted
        </span>

        <!-- Large Display Code -->
        <h1 class="text-7xl sm:text-8xl font-black font-serif-title text-slate-900 tracking-tight mb-4">
            4<span class="text-rose-600">0</span>3
        </h1>

        <!-- Headline & Description -->
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-3">
            Institutional Clearance Required
        </h2>
        <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-8 max-w-md mx-auto">
            You do not currently have the requisite role or membership authorization to access this secured portal area.
        </p>

        <!-- Context Box -->
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 mb-8 text-left max-w-md mx-auto">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="text-xs text-amber-900 leading-relaxed">
                    <strong>Are you a registered member?</strong> Ensure you are logged into your registered practitioner account with active annual dues clearance.
                </div>
            </div>
        </div>

        <!-- Action Links -->
        <div class="flex flex-wrap items-center justify-center gap-3">
            @guest
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-xs">
                    <span>Sign In to Account</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
                <a href="{{ route('membership.register') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold transition-colors">
                    <span>Apply for Membership</span>
                </a>
            @else
                <a href="{{ route('member.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-xs">
                    <span>Return to Member Dashboard</span>
                </a>
                <a href="{{ route('membership.payment') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold transition-colors">
                    <span>Clear Membership Dues</span>
                </a>
            @endguest
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                <span>Public Portal</span>
            </a>
        </div>
    </div>
</div>
@endsection
