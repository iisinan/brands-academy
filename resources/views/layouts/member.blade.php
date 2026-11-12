<!DOCTYPE html>
<html lang="en" class="h-full bg-[#f0f2f1]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#3b5d4f">
    <title>@yield('title', 'Member Dashboard') | Brands Academy Nigeria Foundation</title>
    <meta name="description" content="Official Member Portal & Governance Registry for Brands Academy Nigeria Foundation (CAC/IT/No. 7344471).">

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=3">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=3">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
        .font-serif-title {
            font-family: 'Playfair Display', Georgia, serif;
        }
        /* Custom scrollbar for member sidebar */
        .member-sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .member-sidebar-scroll::-webkit-scrollbar-track {
            background: rgba(226, 232, 240, 0.5);
        }
        .member-sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.45);
            border-radius: 4px;
        }
        .member-sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(235, 196, 67, 0.55);
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-full bg-[#f0f2f1] text-[#141615] antialiased selection:bg-[#ebc443] selection:text-[#141615]"
      x-data="memberLayoutComponent({{ request()->routeIs('member.dashboard') ? 'true' : 'false' }})">

    @php
        $isOnDashboard = request()->routeIs('member.dashboard');
        $currentMember = $member ?? auth()->user()?->member;
        $openWorkshopsCount = isset($openWorkshops) ? $openWorkshops->count() : \App\Models\Workshop::where('status', 'published')->where('application_starts_at', '<=', now())->where('application_deadline', '>=', now())->count();
        $certificatesCount = isset($certificates) ? $certificates->count() : ($currentMember ? $currentMember->certificates()->count() : 0);
        $applicationsCount = isset($applications) ? $applications->count() : ($currentMember ? $currentMember->applications()->count() : 0);
    @endphp

    <!-- Mobile Sidebar Backdrop Overlay -->
    <div x-show="sidebarOpen" x-cloak
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-slate-950/80 backdrop-blur-xs md:hidden transition-opacity"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    <div class="flex min-h-screen">

        <!-- ======================= PERMANENT FIXED LEFT SIDEBAR ======================= -->
        <aside class="fixed inset-y-0 left-0 z-50 w-72 sm:w-80 max-w-[85vw] bg-[#3b5d4f] text-[#d6e0dc] flex flex-col border-r border-white/15 transform transition-transform duration-300 ease-in-out md:translate-x-0 select-none shadow-2xl"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

            <!-- Pinned Top Section: Brand Header & Member Credential Card (Never scrolls) -->
            <div class="shrink-0 p-4 border-b border-white/15 bg-[#2f4a3f]">
                <div class="flex items-center justify-between">
                    <a href="{{ route('member.dashboard') }}" class="flex items-center gap-2.5 group min-w-0">
                        <x-brand-logo class="w-9 h-9 shrink-0 drop-shadow-md group-hover:scale-105 transition-transform" />
                        <div class="min-w-0">
                            <span class="block text-xs font-extrabold uppercase tracking-widest text-white font-serif-title truncate">
                                Brands Academy
                            </span>
                            <span class="block text-[9.5px] font-bold tracking-wider text-amber-400 uppercase truncate">
                                Nigeria Foundation
                            </span>
                        </div>
                    </a>

                    <!-- Close button on mobile -->
                    <button @click="sidebarOpen = false" class="md:hidden p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors cursor-pointer" title="Close Sidebar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Legal Entity Sub-Row -->
                <div class="mt-2.5 flex items-center justify-between text-[10px] pt-2 border-t border-slate-800/60">
                    <span class="inline-flex items-center gap-1.5 font-bold text-emerald-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Member Portal Active
                    </span>
                    <span class="text-slate-400 font-mono text-[9.5px]">CAC/IT/No. 7344471</span>
                </div>

                <!-- Member Identity Card in Sidebar (Pinned & High-Contrast) -->
                @if($currentMember)
                    <div class="mt-2.5 p-3 rounded-2xl bg-[#243a31] border border-white/15 relative overflow-hidden shadow-sm">
                        <div class="flex items-center gap-2.5">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 via-amber-500 to-amber-600 text-slate-950 font-extrabold text-sm flex items-center justify-center shadow-md font-serif-title shrink-0 ring-1 ring-amber-400/40">
                                {{ substr($currentMember->first_name ?? (auth()->user()?->name ?? 'M'), 0, 1) }}{{ substr($currentMember->last_name ?? '', 0, 1) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-1.5 mb-0.5">
                                    <span class="inline-block px-1.5 py-0.2 rounded text-[9px] font-bold bg-amber-500/15 text-amber-300 border border-amber-500/30 truncate">
                                        {{ $currentMember->category_label }}
                                    </span>
                                </div>
                                <h3 class="text-xs font-bold text-white truncate font-serif-title leading-tight">
                                    {{ $currentMember->full_name }}
                                </h3>
                                <p class="text-[10px] text-slate-400 truncate mt-0.5">
                                    {{ $currentMember->designation ?: 'Foundation Member' }}
                                </p>
                            </div>
                        </div>

                        <!-- Member ID Strip with 1-Click Copy -->
                        <div class="mt-2 p-1.5 px-2 rounded-xl bg-slate-950 border border-slate-800/80 flex items-center justify-between gap-2">
                            <div class="min-w-0">
                                <span class="block text-[8px] uppercase font-bold text-slate-400 tracking-wider">Member ID</span>
                                <span class="text-xs font-extrabold font-mono text-amber-400 block truncate">
                                    {{ $currentMember->member_number ?? 'MEMBER-ACTIVE' }}
                                </span>
                            </div>
                            <button type="button" @click="copyMemberId('{{ $currentMember->member_number }}')"
                                    class="px-2 py-0.5 rounded-lg text-[10px] font-bold bg-slate-800 hover:bg-slate-700 text-amber-400 border border-slate-700 transition-colors flex items-center gap-1 shrink-0 cursor-pointer shadow-2xs"
                                    title="Copy Member ID">
                                <svg x-show="!copiedId" class="w-3 h-3 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                <svg x-show="copiedId" x-cloak class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span x-text="copiedId ? 'Copied!' : 'Copy'"></span>
                            </button>
                        </div>

                        <div class="mt-1.5 text-[9.5px] text-slate-400 flex items-center justify-between">
                            <span>Chapter:</span>
                            <span class="text-slate-300 font-semibold truncate">{{ $currentMember->state }}, {{ $currentMember->country ?? 'Nigeria' }}</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Scrollable Navigation Area (Only links scroll!) -->
            <nav class="flex-1 overflow-y-auto p-3 space-y-4 text-xs font-medium member-sidebar-scroll">

                <!-- SECTION 1: MAIN NAVIGATION -->
                <div class="space-y-1">
                    <div class="px-3 pt-1 pb-1.5 text-[9.5px] uppercase font-extrabold tracking-wider text-slate-400/80">
                        Main Navigation
                    </div>

                    <!-- Dashboard Overview -->
                    <button type="button" @click="switchTab('overview')"
                            :class="(isOnDashboard && activeTab === 'overview') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white'"
                            class="w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all text-left cursor-pointer group">
                        <span class="flex items-center gap-3">
                            <svg class="w-4 h-4" :class="(isOnDashboard && activeTab === 'overview') ? 'text-slate-950' : 'text-amber-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            <span>Dashboard Overview</span>
                        </span>
                        <span class="text-[10px] font-mono" :class="(isOnDashboard && activeTab === 'overview') ? 'text-slate-950 font-bold' : 'opacity-60'">&rarr;</span>
                    </button>

                    <!-- Workshop Cohorts -->
                    <button type="button" @click="switchTab('cohorts')"
                            :class="((isOnDashboard && activeTab === 'cohorts') || (!isOnDashboard && {{ request()->routeIs('workshops.*') ? 'true' : 'false' }})) ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white'"
                            class="w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all text-left cursor-pointer group">
                        <span class="flex items-center gap-3">
                            <svg class="w-4 h-4" :class="((isOnDashboard && activeTab === 'cohorts') || (!isOnDashboard && {{ request()->routeIs('workshops.*') ? 'true' : 'false' }})) ? 'text-slate-950' : 'text-amber-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <span>Workshop Cohorts</span>
                        </span>
                        <span class="flex items-center gap-1.5">
                            @if($openWorkshopsCount > 0)
                                <span class="px-1.5 py-0.2 rounded-full text-[9px] font-extrabold font-mono"
                                      :class="((isOnDashboard && activeTab === 'cohorts') || (!isOnDashboard && {{ request()->routeIs('workshops.*') ? 'true' : 'false' }})) ? 'bg-slate-950 text-amber-400' : 'bg-amber-400 text-slate-950'">
                                    {{ $openWorkshopsCount }} Open
                                </span>
                            @endif
                            <span class="px-1.5 py-0.2 rounded text-[9px] font-bold"
                                  :class="((isOnDashboard && activeTab === 'cohorts') || (!isOnDashboard && {{ request()->routeIs('workshops.*') ? 'true' : 'false' }})) ? 'bg-slate-950/20 text-slate-950' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30'">
                                25% Off
                            </span>
                        </span>
                    </button>

                    <!-- LMS Classroom -->
                    <a href="{{ route('member.courses.index') }}"
                       class="w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all text-left cursor-pointer group {{ (request()->routeIs('member.courses.*') || request()->routeIs('courses.*')) ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                        <span class="flex items-center gap-3">
                            <svg class="w-4 h-4 {{ (request()->routeIs('member.courses.*') || request()->routeIs('courses.*')) ? 'text-slate-950' : 'text-amber-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>My LMS Classroom</span>
                        </span>
                        <span class="px-1.5 py-0.2 rounded text-[9px] font-bold {{ (request()->routeIs('member.courses.*') || request()->routeIs('courses.*')) ? 'bg-slate-950 text-amber-400' : 'bg-blue-500/20 text-blue-300' }}">
                            Courses
                        </span>
                    </a>

                    <!-- Masterclasses & Webinars -->
                    <a href="{{ route('webinars.index') }}"
                       class="w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all text-left cursor-pointer group {{ request()->routeIs('webinars.*') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                        <span class="flex items-center gap-3">
                            <svg class="w-4 h-4 {{ request()->routeIs('webinars.*') ? 'text-slate-950' : 'text-amber-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <span>Live Webinars &amp; Talks</span>
                        </span>
                        <span class="px-1.5 py-0.2 rounded text-[9px] font-bold {{ request()->routeIs('webinars.*') ? 'bg-slate-950 text-amber-400' : 'bg-emerald-500/20 text-emerald-300' }}">
                            Live
                        </span>
                    </a>
                </div>

                <!-- SECTION 2: CREDENTIALS & RECORDS -->
                <div class="space-y-1">
                    <div class="px-3 pt-2 pb-1.5 text-[9.5px] uppercase font-extrabold tracking-wider text-slate-400/80">
                        Credentials &amp; Records
                    </div>

                    <!-- My Certificates -->
                    <button type="button" @click="switchTab('certificates')"
                            :class="(isOnDashboard && activeTab === 'certificates') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white'"
                            class="w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all text-left cursor-pointer group">
                        <span class="flex items-center gap-3">
                            <svg class="w-4 h-4" :class="(isOnDashboard && activeTab === 'certificates') ? 'text-slate-950' : 'text-amber-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>My Certificates</span>
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold"
                              :class="(isOnDashboard && activeTab === 'certificates') ? 'bg-slate-950 text-amber-400' : 'bg-slate-800 text-slate-400'">
                            {{ $certificatesCount }}
                        </span>
                    </button>

                    <!-- Digital Member ID -->
                    @if($currentMember)
                        <button type="button" @click="switchTab('digital-id')"
                                :class="(isOnDashboard && activeTab === 'digital-id') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white'"
                                class="w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all text-left cursor-pointer group">
                            <span class="flex items-center gap-3">
                                <svg class="w-4 h-4" :class="(isOnDashboard && activeTab === 'digital-id') ? 'text-slate-950' : 'text-amber-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span>Digital Member ID</span>
                            </span>
                            <span class="px-1.5 py-0.2 rounded text-[9px] font-bold"
                                  :class="(isOnDashboard && activeTab === 'digital-id') ? 'bg-slate-950 text-amber-400' : 'bg-amber-500/20 text-amber-400'">
                                Live QR
                            </span>
                        </button>
                    @endif

                    <!-- Application History -->
                    <button type="button" @click="switchTab('applications')"
                            :class="(isOnDashboard && activeTab === 'applications') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white'"
                            class="w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all text-left cursor-pointer group">
                        <span class="flex items-center gap-3">
                            <svg class="w-4 h-4" :class="(isOnDashboard && activeTab === 'applications') ? 'text-slate-950' : 'text-amber-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <span>Application History</span>
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold"
                              :class="(isOnDashboard && activeTab === 'applications') ? 'bg-slate-950 text-amber-400' : 'bg-slate-800 text-slate-400'">
                            {{ $applicationsCount }}
                        </span>
                    </button>
                </div>

                <!-- SECTION 3: FOUNDATION SERVICES -->
                <div class="space-y-1">
                    <div class="px-3 pt-2 pb-1.5 text-[9.5px] uppercase font-extrabold tracking-wider text-slate-400/80">
                        Foundation Services
                    </div>

                    <!-- CAC & Brand IP Filings -->
                    <a href="{{ route('member.filings.index') }}"
                       class="w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all text-left cursor-pointer group {{ (request()->routeIs('member.filings.*') || request()->routeIs('services.*')) ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                        <span class="flex items-center gap-3">
                            <svg class="w-4 h-4 {{ (request()->routeIs('member.filings.*') || request()->routeIs('services.*')) ? 'text-slate-950' : 'text-amber-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>CAC &amp; IP Filings</span>
                        </span>
                        <span class="px-1.5 py-0.2 rounded text-[9px] font-bold {{ (request()->routeIs('member.filings.*') || request()->routeIs('services.*')) ? 'bg-slate-950 text-amber-400' : 'bg-emerald-500/20 text-emerald-300' }}">
                            25% Off
                        </span>
                    </a>

                    <!-- Community Discussion Board -->
                    <a href="{{ route('forum.index') }}"
                       class="w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all text-left cursor-pointer group {{ request()->routeIs('forum.*') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                        <span class="flex items-center gap-3">
                            <svg class="w-4 h-4 {{ request()->routeIs('forum.*') ? 'text-slate-950' : 'text-amber-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            <span>Community Forum</span>
                        </span>
                        <span class="px-1.5 py-0.2 rounded text-[9px] font-bold {{ request()->routeIs('forum.*') ? 'bg-slate-950 text-amber-400' : 'bg-purple-500/20 text-purple-300' }}">
                            Peers
                        </span>
                    </a>

                    <!-- Conferences & Summits -->
                    <a href="{{ route('conferences.index') }}"
                       class="w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all text-left cursor-pointer group {{ request()->routeIs('conferences.*') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                        <span class="flex items-center gap-3">
                            <svg class="w-4 h-4 {{ request()->routeIs('conferences.*') ? 'text-slate-950' : 'text-amber-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span>Conferences &amp; Summits</span>
                        </span>
                        <span class="px-1.5 py-0.2 rounded text-[9px] font-bold {{ request()->routeIs('conferences.*') ? 'bg-slate-950 text-amber-400' : 'bg-amber-500/20 text-amber-300' }}">
                            Passes
                        </span>
                    </a>

                    <!-- JBSM Journal & Articles -->
                    <a href="{{ route('journal.index') }}"
                       class="w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all text-left cursor-pointer group {{ request()->routeIs('journal.*') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                        <span class="flex items-center gap-3">
                            <svg class="w-4 h-4 {{ request()->routeIs('journal.*') ? 'text-slate-950' : 'text-amber-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <span>NJBSM Journal</span>
                        </span>
                        <span class="px-1.5 py-0.2 rounded text-[9px] font-bold {{ request()->routeIs('journal.*') ? 'bg-slate-950 text-amber-400' : 'bg-indigo-500/20 text-indigo-300' }}">
                            Research
                        </span>
                    </a>
                </div>

                <!-- SECTION 4: ACCOUNT -->
                <div class="space-y-1">
                    <div class="px-3 pt-2 pb-1.5 text-[9.5px] uppercase font-extrabold tracking-wider text-slate-400/80">
                        Account &amp; Alerts
                    </div>

                    <!-- Profile & Settings -->
                    <button type="button" @click="switchTab('profile')"
                            :class="(isOnDashboard && activeTab === 'profile') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white'"
                            class="w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all text-left cursor-pointer group">
                        <span class="flex items-center gap-3">
                            <svg class="w-4 h-4" :class="(isOnDashboard && activeTab === 'profile') ? 'text-slate-950' : 'text-amber-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>Profile &amp; Settings</span>
                        </span>
                        <span class="text-[10px] font-mono" :class="(isOnDashboard && activeTab === 'profile') ? 'text-slate-950 font-bold' : 'opacity-60'">&rarr;</span>
                    </button>

                    <!-- In-App Notifications -->
                    @php
                        $memberSidebarUnreadCount = auth()->user()?->unreadNotifications()->count() ?? 0;
                    @endphp
                    <a href="{{ route('notifications.index') }}"
                       class="w-full flex items-center justify-between px-3 py-2 rounded-xl transition-all text-left cursor-pointer group {{ request()->routeIs('notifications.*') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                        <span class="flex items-center gap-3">
                            <svg class="w-4 h-4 {{ request()->routeIs('notifications.*') ? 'text-slate-950' : 'text-amber-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            <span>Notifications</span>
                        </span>
                        @if($memberSidebarUnreadCount > 0)
                            <span class="px-1.5 py-0.2 rounded-full text-[9px] font-bold font-mono bg-rose-500 text-white animate-pulse">
                                {{ $memberSidebarUnreadCount }}
                            </span>
                        @else
                            <span class="text-[10px] font-mono opacity-60">&rarr;</span>
                        @endif
                    </a>
                </div>

                <!-- Credential Quick Tools (Compact & Polished) -->
                @if($currentMember)
                    <div class="pt-2 px-1 space-y-1.5">
                        <span class="px-2 text-[9.5px] font-extrabold uppercase tracking-wider text-slate-400/80 block">
                            Credential Quick Tools
                        </span>

                        <div class="grid grid-cols-1 gap-1.5">
                            <!-- Certificate PDF -->
                            <a href="{{ route('membership.certificate.download', $currentMember->qr_code_token) }}"
                               class="py-2 px-3 rounded-xl text-[11px] font-medium bg-slate-900/80 hover:bg-slate-800 text-slate-200 hover:text-white transition-all flex items-center justify-between border border-slate-800/80 group">
                                <span class="flex items-center gap-2.5 truncate">
                                    <svg class="w-3.5 h-3.5 text-amber-400 group-hover:scale-110 transition-transform shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span class="truncate">Download Certificate PDF</span>
                                </span>
                                <span class="text-slate-500 text-[10px]">&darr;</span>
                            </a>

                            <!-- Digital Card -->
                            <a href="{{ route('membership.card', $currentMember->qr_code_token) }}" target="_blank"
                               class="py-2 px-3 rounded-xl text-[11px] font-medium bg-slate-900/60 hover:bg-slate-800 text-slate-300 hover:text-white transition-all flex items-center justify-between border border-slate-800/60 group">
                                <span class="flex items-center gap-2.5 truncate">
                                    <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-amber-400 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    <span class="truncate">Open Digital Member Card</span>
                                </span>
                                <span class="text-slate-500 text-[10px]">&nearr;</span>
                            </a>

                            <!-- Copy Verification Link -->
                            <button type="button" @click="copyVerificationUrl('{{ route('verify.certificate', $currentMember->qr_code_token) }}')"
                                    class="w-full py-2 px-3 rounded-xl text-[11px] font-medium bg-slate-900/60 hover:bg-slate-800 text-slate-300 hover:text-white transition-all flex items-center justify-between border border-slate-800/60 cursor-pointer group">
                                <span class="flex items-center gap-2.5 truncate">
                                    <svg class="w-3.5 h-3.5 text-emerald-400 group-hover:scale-110 transition-transform shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                    <span class="truncate" x-text="copiedUrl ? 'Link Copied!' : 'Copy Verification URL'"></span>
                                </span>
                                <span class="text-slate-500 text-[9px] font-mono">LINK</span>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Admin Link if Admin -->
                @if(auth()->user()?->isAdmin())
                    <div class="pt-2 px-1">
                        <a href="{{ route('admin.dashboard') }}"
                           class="w-full py-2.5 px-3 rounded-xl text-xs font-bold bg-amber-500/15 hover:bg-amber-500/25 text-amber-300 border border-amber-500/30 transition-all flex items-center justify-center gap-2 shadow-xs group">
                            <svg class="w-3.5 h-3.5 text-amber-400 group-hover:rotate-45 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Admin Control Center</span>
                        </a>
                    </div>
                @endif

            </nav>

            <!-- Sidebar Footer / Quick Site Actions & Sign Out (Pinned at bottom) -->
            <div class="shrink-0 p-3 border-t border-slate-800/80 bg-slate-950 space-y-1.5">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between px-3 py-1.5 rounded-xl text-[11px] font-semibold text-slate-400 hover:text-amber-300 hover:bg-slate-900 transition-colors group">
                    <span class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-amber-400/80 group-hover:text-amber-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span>Public Foundation Site</span>
                    </span>
                    <span class="text-slate-500 group-hover:translate-x-0.5 transition-transform">&rarr;</span>
                </a>

                <div class="pt-1.5 border-t border-slate-800/60 flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2 min-w-0">
                        <div class="w-7 h-7 rounded-lg bg-amber-500/20 text-amber-400 border border-amber-500/30 flex items-center justify-center font-bold text-xs shrink-0 font-serif-title">
                            {{ substr(auth()->user()?->name ?? 'M', 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <span class="block text-xs font-bold text-white truncate">{{ auth()->user()?->name ?? 'Member' }}</span>
                            <span class="block text-[9.5px] text-amber-400 font-semibold truncate">{{ $currentMember ? $currentMember->category_label : 'Verified Member' }}</span>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="p-1.5 rounded-xl text-slate-400 hover:text-rose-400 hover:bg-slate-900 border border-transparent hover:border-slate-800 transition-colors cursor-pointer" title="Sign Out">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- ======================= MAIN CONTENT WRAPPER ======================= -->
        <div class="flex-1 md:pl-72 lg:pl-80 flex flex-col min-h-screen">

            <!-- Top Sticky Member Bar -->
            <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between gap-4">

                <div class="flex items-center gap-3">
                    <!-- Mobile Hamburger -->
                    <button @click="sidebarOpen = true" class="md:hidden p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors cursor-pointer" title="Open Member Sidebar">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>

                    <!-- Breadcrumbs / Context -->
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Member Portal</span>
                            <span class="hidden sm:inline-flex items-center gap-1 px-1.5 py-0.2 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Active
                            </span>
                        </div>
                        <h1 class="text-base sm:text-lg font-bold text-slate-900 font-serif-title leading-tight">
                            @yield('page_title', 'Member Dashboard')
                        </h1>
                    </div>
                </div>

                <!-- Top Right Utility Actions -->
                <div class="flex items-center gap-2 sm:gap-3">

                    @if($currentMember)
                        <div class="hidden sm:flex items-center gap-2 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-xl">
                            <span class="text-[10px] uppercase font-bold text-slate-400">ID:</span>
                            <span class="text-xs font-mono font-bold text-amber-700">{{ $currentMember->member_number }}</span>
                        </div>
                    @endif

                    <!-- Browse Open Cohorts -->
                    <a href="{{ route('workshops.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-3.5 sm:py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors shadow-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>Workshops (25% Off)</span>
                    </a>

                    <!-- Live Public Website Link -->
                    <a href="{{ route('home') }}" target="_blank" class="hidden md:inline-flex items-center gap-1 px-3 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors border border-slate-200">
                        <span>Public Site &nearr;</span>
                    </a>

                    <!-- Notification Bell -->
                    <a href="{{ route('notifications.index') }}" class="relative p-2 text-slate-600 hover:text-slate-900 rounded-xl hover:bg-slate-100 transition-colors" title="Notifications">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @if($memberSidebarUnreadCount > 0)
                            <span class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-rose-600 text-[9px] font-bold text-white font-mono animate-pulse">
                                {{ $memberSidebarUnreadCount > 9 ? '9+' : $memberSidebarUnreadCount }}
                            </span>
                        @endif
                    </a>

                    <!-- Profile / Logout dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 p-1 rounded-xl hover:bg-slate-100 transition-colors cursor-pointer">
                            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 text-slate-950 font-bold text-xs flex items-center justify-center shadow-xs">
                                {{ substr(auth()->user()?->name ?? 'M', 0, 1) }}
                            </div>
                            <svg class="w-4 h-4 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div x-show="open" x-cloak
                             class="absolute right-0 mt-2 w-56 rounded-2xl bg-white shadow-xl border border-slate-200 py-2 z-50 text-xs text-slate-700"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95">

                            <div class="px-4 py-2.5 border-b border-slate-100">
                                <span class="block font-bold text-slate-900 truncate">{{ auth()->user()?->name ?? 'Member User' }}</span>
                                <span class="block text-[11px] text-slate-400 truncate">{{ auth()->user()?->email ?? '' }}</span>
                            </div>

                            <div class="py-1">
                                <a href="{{ route('member.dashboard') }}" class="block px-4 py-2 hover:bg-slate-50 font-medium">Dashboard Overview</a>
                                @if(auth()->user()?->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-amber-50 text-amber-800 font-bold">Admin Operations Panel</a>
                                @endif
                                <a href="{{ route('workshops.index') }}" class="block px-4 py-2 hover:bg-slate-50 font-medium">Workshop Cohorts (25% Off)</a>
                                <a href="{{ route('home') }}" target="_blank" class="block px-4 py-2 hover:bg-slate-50 font-medium">Public Foundation Site</a>
                            </div>

                            <div class="border-t border-slate-100 pt-1">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-rose-600 hover:bg-rose-50 font-bold flex items-center gap-2 cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        <span>Sign Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

            </header>

            @if(request()->routeIs('member.dashboard'))
            <!-- Sticky Horizontal Section Navigation Tabs Strip -->
            <div class="sticky top-[57px] sm:top-[61px] z-20 bg-white/95 backdrop-blur-md border-b border-slate-200/90 px-4 sm:px-6 lg:px-8 py-2">
                <nav class="flex items-center gap-1 sm:gap-2 overflow-x-auto no-scrollbar py-0.5 text-xs font-semibold">
                    <!-- 1. Overview -->
                    <button type="button" @click="switchTab('overview')"
                            :class="activeTab === 'overview' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                            class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span>Overview</span>
                    </button>

                    <!-- 2. Workshop Cohorts -->
                    <button type="button" @click="switchTab('cohorts')"
                            :class="activeTab === 'cohorts' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                            class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>Workshops</span>
                        <span class="px-1.5 py-0.2 text-[10px] rounded-full" :class="activeTab === 'cohorts' ? 'bg-amber-400 text-slate-950 font-bold' : 'bg-amber-100 text-amber-800 font-bold'">25% Off</span>
                    </button>

                    <!-- 3. Certificates -->
                    <button type="button" @click="switchTab('certificates')"
                            :class="activeTab === 'certificates' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                            class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        <span>Certificates</span>
                        <span class="px-1.5 py-0.2 text-[10px] rounded-full" :class="activeTab === 'certificates' ? 'bg-emerald-400 text-slate-950 font-bold' : 'bg-slate-100 text-slate-600 font-bold'">{{ $certificatesCount }}</span>
                    </button>

                    <!-- 4. Applications -->
                    <button type="button" @click="switchTab('applications')"
                            :class="activeTab === 'applications' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                            class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <span>Applications</span>
                        <span class="px-1.5 py-0.2 text-[10px] rounded-full" :class="activeTab === 'applications' ? 'bg-amber-400 text-slate-950 font-bold' : 'bg-slate-100 text-slate-600 font-bold'">{{ $applicationsCount }}</span>
                    </button>

                    <!-- 5. Digital ID Tab -->
                    @if($currentMember)
                        <button type="button" @click="switchTab('digital-id')"
                                :class="activeTab === 'digital-id' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                                class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5 cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <span>Digital ID</span>
                            <span class="px-1.5 py-0.2 text-[10px] rounded-full" :class="activeTab === 'digital-id' ? 'bg-amber-400 text-slate-950 font-bold' : 'bg-amber-100 text-amber-800 font-bold'">Live QR</span>
                        </button>
                    @endif

                    <!-- 6. Profile & Settings -->
                    <button type="button" @click="switchTab('profile')"
                            :class="activeTab === 'profile' ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'"
                            class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>Profile &amp; Settings</span>
                    </button>
                </nav>
            </div>
            @else
            <!-- Portal Sub-Header Navigation Strip for Sub-Pages -->
            <div class="sticky top-[57px] sm:top-[61px] z-20 bg-white/95 backdrop-blur-md border-b border-slate-200/90 px-4 sm:px-6 lg:px-8 py-2.5 flex items-center justify-between gap-3 text-xs font-semibold">
                <div class="flex items-center gap-2 min-w-0">
                    <a href="{{ route('member.dashboard') }}" class="text-amber-700 hover:text-amber-800 transition-colors flex items-center gap-1 shrink-0 font-bold">
                        <span>&larr;</span>
                        <span>Dashboard Overview</span>
                    </a>
                    <span class="text-slate-300">/</span>
                    <span class="text-slate-900 font-bold truncate">@yield('page_title', 'Member Portal')</span>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('member.dashboard') }}#cohorts" class="hidden sm:inline-flex px-2.5 py-1 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">
                        Workshops (25% Off)
                    </a>
                    <a href="{{ route('member.dashboard') }}#certificates" class="hidden sm:inline-flex px-2.5 py-1 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">
                        Certificates
                    </a>
                    <a href="{{ route('member.dashboard') }}#applications" class="hidden sm:inline-flex px-2.5 py-1 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">
                        Applications
                    </a>
                </div>
            </div>
            @endif

            <!-- Alerts & Flash Notifications -->
            <div class="px-4 sm:px-6 lg:px-8 pt-4">
                @if(session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center justify-between gap-3 shadow-xs mb-4" x-data="{ show: true }" x-show="show">
                        <div class="flex items-center gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-xs sm:text-sm font-semibold flex items-center justify-between gap-3 shadow-xs mb-4" x-data="{ show: true }" x-show="show">
                        <div class="flex items-center gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            <span>{{ session('info') }}</span>
                        </div>
                        <button @click="show = false" class="text-amber-600 hover:text-amber-900 font-bold">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm font-semibold flex items-center justify-between gap-3 shadow-xs mb-4" x-data="{ show: true }" x-show="show">
                        <div class="flex items-center gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button @click="show = false" class="text-rose-600 hover:text-rose-900 font-bold">&times;</button>
                    </div>
                @endif
            </div>

            <!-- Page Content Body -->
            <main class="flex-1 pb-24 md:pb-16">
                @yield('content')
            </main>

            <!-- Member Portal Footer -->
            <footer class="px-4 sm:px-6 lg:px-8 py-4 pb-20 md:pb-4 bg-white border-t border-slate-200 text-slate-400 text-xs flex flex-col sm:flex-row items-center justify-between gap-2">
                <div>
                    <strong>Brands Academy Nigeria Foundation</strong> &bull; Incorporated Trustee &bull; CAC/IT/No. 7344471
                </div>
                <div class="flex items-center gap-4 text-[11px]">
                    <a href="{{ route('home') }}" target="_blank" class="hover:text-amber-600 transition-colors">Public Site</a>
                    <span>&bull;</span>
                    <a href="{{ route('verify.certificate') }}" target="_blank" class="hover:text-amber-600 transition-colors">Verification Registry</a>
                    <span>&bull;</span>
                    <a href="mailto:thebrandsacademy@gmail.com" class="hover:text-amber-600 transition-colors">thebrandsacademy@gmail.com</a>
                </div>
            </footer>

        </div>
    </div>

    <!-- Member Mobile Bottom Navigation Bar -->
    <nav class="md:hidden fixed bottom-0 inset-x-0 z-40 bg-slate-950/95 backdrop-blur-md border-t border-slate-800 safe-pb shadow-lg">
        <div class="grid grid-cols-5 h-16 items-center px-1">
            <!-- 1. Overview -->
            <button type="button" @click="switchTab('overview')" class="flex flex-col items-center justify-center py-1 transition-colors cursor-pointer" :class="activeTab === 'overview' ? 'text-amber-400 font-bold' : 'text-slate-400 hover:text-white'">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span class="text-[10px]">Overview</span>
            </button>
            <!-- 2. Workshops (25% off) -->
            <button type="button" @click="switchTab('cohorts')" class="flex flex-col items-center justify-center py-1 transition-colors cursor-pointer relative" :class="activeTab === 'cohorts' ? 'text-amber-400 font-bold' : 'text-slate-400 hover:text-white'">
                <span class="absolute top-1 right-2 px-1 py-0.2 rounded text-[8px] font-extrabold bg-amber-400 text-slate-950">-25%</span>
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                <span class="text-[10px]">Cohorts</span>
            </button>
            <!-- 3. Certificates -->
            <button type="button" @click="switchTab('certificates')" class="flex flex-col items-center justify-center py-1 transition-colors cursor-pointer relative" :class="activeTab === 'certificates' ? 'text-amber-400 font-bold' : 'text-slate-400 hover:text-white'">
                @if($certificatesCount > 0)
                    <span class="absolute top-1 right-3 w-4 h-4 rounded-full text-[9px] font-bold bg-emerald-500 text-white flex items-center justify-center">{{ $certificatesCount }}</span>
                @endif
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span class="text-[10px]">Certs</span>
            </button>
            <!-- 4. Applications -->
            <button type="button" @click="switchTab('applications')" class="flex flex-col items-center justify-center py-1 transition-colors cursor-pointer relative" :class="activeTab === 'applications' ? 'text-amber-400 font-bold' : 'text-slate-400 hover:text-white'">
                @if($applicationsCount > 0)
                    <span class="absolute top-1 right-3 w-4 h-4 rounded-full text-[9px] font-bold bg-amber-400 text-slate-950 flex items-center justify-center">{{ $applicationsCount }}</span>
                @endif
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span class="text-[10px]">Applied</span>
            </button>
            <!-- 5. Digital ID Tab -->
            <button type="button" @click="switchTab('digital-id')" class="flex flex-col items-center justify-center py-1 transition-colors cursor-pointer" :class="activeTab === 'digital-id' ? 'text-amber-400 font-bold' : 'text-slate-400 hover:text-white'">
                <div class="w-5 h-5 rounded flex items-center justify-center mb-0.5" :class="activeTab === 'digital-id' ? 'bg-amber-500 text-slate-950' : 'bg-amber-500/20 text-amber-400 border border-amber-500/40'">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                </div>
                <span class="text-[10px]">Digital ID</span>
            </button>
        </div>
    </nav>

    @stack('scripts')

    <script>
        function memberLayoutComponent(isOnDashboard = false) {
            const validTabs = ['overview', 'cohorts', 'certificates', 'applications', 'digital-id', 'profile'];
            const getInitialTab = () => {
                if (!isOnDashboard) return '';
                const hash = (window.location.hash || '').replace('#', '').trim();
                if (validTabs.includes(hash)) return hash;
                const params = new URLSearchParams(window.location.search);
                const queryTab = params.get('tab');
                if (validTabs.includes(queryTab)) return queryTab;
                return 'overview';
            };

            return {
                sidebarOpen: false,
                isOnDashboard: isOnDashboard,
                activeTab: getInitialTab(),
                copiedId: false,
                copiedUrl: false,

                init() {
                    window.addEventListener('hashchange', () => {
                        if (!this.isOnDashboard) return;
                        const h = (window.location.hash || '').replace('#', '').trim();
                        if (validTabs.includes(h) && this.activeTab !== h) {
                            this.activeTab = h;
                        }
                    });
                    window.addEventListener('tab-changed', (e) => {
                        if (validTabs.includes(e.detail) && this.activeTab !== e.detail) {
                            this.activeTab = e.detail;
                        }
                    });
                },

                switchTab(tabName) {
                    if (!validTabs.includes(tabName)) return;
                    if (!this.isOnDashboard) {
                        window.location.href = '{{ route("member.dashboard") }}#' + tabName;
                        return;
                    }
                    this.activeTab = tabName;
                    if (window.innerWidth < 768) {
                        this.sidebarOpen = false;
                    }
                    try {
                        if (window.history && window.history.replaceState) {
                            window.history.replaceState(null, '', '#' + tabName);
                        } else {
                            window.location.hash = tabName;
                        }
                    } catch (e) {
                        window.location.hash = tabName;
                    }
                    window.dispatchEvent(new CustomEvent('tab-changed', { detail: tabName }));
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },

                copyMemberId(memberId) {
                    if (navigator.clipboard && memberId) {
                        navigator.clipboard.writeText(memberId);
                        this.copiedId = true;
                        setTimeout(() => this.copiedId = false, 2500);
                    }
                },

                copyVerificationUrl(url) {
                    if (navigator.clipboard && url) {
                        navigator.clipboard.writeText(url);
                        this.copiedUrl = true;
                        setTimeout(() => this.copiedUrl = false, 2500);
                    }
                },

                openCardModal() {
                    this.switchTab('digital-id');
                }
            };
        }
    </script>
</body>
</html>
