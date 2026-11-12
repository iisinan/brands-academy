@extends('layouts.app')

@section('title', 'Server Error (500) | Brands Academy Nigeria Foundation')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-xl w-full text-center">
        <!-- Error Pill -->
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-500/10 text-rose-700 border border-rose-500/20 mb-6">
            <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
            Error 500 &bull; Internal Server Fault
        </span>

        <!-- Large Display Code -->
        <h1 class="text-7xl sm:text-8xl font-black font-serif-title text-slate-900 tracking-tight mb-4">
            5<span class="text-rose-600">0</span>0
        </h1>

        <!-- Headline & Description -->
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-3">
            Temporary System Interruption
        </h2>
        <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-8 max-w-md mx-auto">
            Our server encountered an unexpected issue while processing your request. The technical secretariat has been alerted.
        </p>

        <!-- Help Desk info -->
        <div class="bg-slate-100 border border-slate-200 rounded-2xl p-4 mb-8 text-center max-w-md mx-auto">
            <div class="text-xs text-slate-600">
                Need urgent assistance? Contact the registrar:
                <a href="mailto:thebrandsacademy@gmail.com" class="font-bold text-slate-900 hover:text-amber-600 underline ml-1">
                    thebrandsacademy@gmail.com
                </a>
            </div>
        </div>

        <!-- Action Links -->
        <div class="flex flex-wrap items-center justify-center gap-3">
            <button onclick="window.location.reload();" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-xs cursor-pointer">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <span>Retry Request</span>
            </button>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold transition-colors">
                <span>Return to Home</span>
            </a>
            <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold transition-colors">
                <span>Course Directory</span>
            </a>
        </div>
    </div>
</div>
@endsection
