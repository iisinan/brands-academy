@extends('layouts.app')

@section('title', 'Session Expired (419) | Brands Academy Nigeria Foundation')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-xl w-full text-center">
        <!-- Error Pill -->
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-500/10 text-amber-700 border border-amber-500/20 mb-6">
            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
            Error 419 &bull; Security Token Expired
        </span>

        <!-- Large Display Code -->
        <h1 class="text-7xl sm:text-8xl font-black font-serif-title text-slate-900 tracking-tight mb-4">
            4<span class="text-amber-500">1</span>9
        </h1>

        <!-- Headline & Description -->
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-3">
            Your Portal Session Has Expired
        </h2>
        <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-8 max-w-md mx-auto">
            To safeguard institutional data and prevent cross-site request forgery, your secure session timed out due to inactivity.
        </p>

        <!-- Action Links -->
        <div class="flex flex-wrap items-center justify-center gap-3">
            <button onclick="window.location.reload();" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-xs cursor-pointer">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <span>Refresh and Reload</span>
            </button>
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold transition-colors">
                <span>Sign In Again</span>
            </a>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                <span>Return Home</span>
            </a>
        </div>
    </div>
</div>
@endsection
