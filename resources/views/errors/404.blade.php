@extends('layouts.app')

@section('title', 'Page Not Found (404) | Brands Academy Nigeria Foundation')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-xl w-full text-center">
        <!-- Error Pill -->
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-500/10 text-amber-600 border border-amber-500/20 mb-6">
            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
            Error 404 &bull; Resource Not Found
        </span>

        <!-- Large Display Code -->
        <h1 class="text-7xl sm:text-8xl font-black font-serif-title text-slate-900 tracking-tight mb-4">
            4<span class="text-amber-500">0</span>4
        </h1>

        <!-- Headline & Description -->
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-3">
            Academic Record or Page Not Found
        </h2>
        <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-8 max-w-md mx-auto">
            The page or document you requested may have been archived, renamed, or is temporarily unavailable within the institutional portal.
        </p>

        <!-- Search Bar -->
        <div class="bg-white p-3 rounded-2xl border border-slate-200 shadow-xs mb-8">
            <form action="{{ route('courses.index') }}" method="GET" class="flex items-center gap-2">
                <div class="relative w-full">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="q" placeholder="Search short courses, webinars, or research..." class="w-full pl-10 pr-4 py-2 text-xs rounded-xl border-0 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-amber-500 text-slate-800 placeholder-slate-400 transition-all">
                </div>
                <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition-colors shrink-0">
                    Search
                </button>
            </form>
        </div>

        <!-- Quick Jump Links -->
        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition-all shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Return Home</span>
            </a>
            <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                <span>Browse Courses</span>
            </a>
            <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                <span>CAC & IP Desk</span>
            </a>
            <a href="{{ route('verify.certificate') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-200 text-xs font-bold transition-colors">
                <span>Verify Credential</span>
            </a>
        </div>
    </div>
</div>
@endsection
