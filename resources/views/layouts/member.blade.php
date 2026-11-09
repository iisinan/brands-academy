<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#020617">
    <title>@yield('title', 'Member Dashboard') | Brands Academy Nigeria Foundation</title>
    <meta name="description" content="Official Member Portal & Governance Registry for Brands Academy Nigeria Foundation (CAC IT No. 7344471).">

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
            background: rgba(15, 23, 42, 0.6);
        }
        .member-sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.2);
            border-radius: 4px;
        }
        .member-sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(245, 158, 11, 0.4);
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-full bg-slate-100 text-slate-800 antialiased selection:bg-amber-500 selection:text-white"
      x-data="memberLayoutComponent()">

    @php
        $currentMember = $member ?? auth()->user()?->member;
        $openWorkshopsCount = isset($openWorkshops) ? $openWorkshops->count() : \App\Models\Workshop::where('status', 'published')->where('application_starts_at', '<=', now())->where('application_deadline', '>=', now())->count();
        $certificatesCount = isset($certificates) ? $certificates->count() : ($currentMember ? $currentMember->certificates()->count() : 0);
        $applicationsCount = isset($applications) ? $applications->count() : ($currentMember ? $currentMember->applications()->count() : 0);
    @endphp

    <!-- Mobile Sidebar Backdrop Overlay -->
    <div x-show="sidebarOpen" x-cloak
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-slate-950/80 backdrop-blur-xs lg:hidden transition-opacity"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    <div class="flex min-h-screen">

        <!-- ======================= PERMANENT FIXED LEFT SIDEBAR ======================= -->
        <aside class="fixed inset-y-0 left-0 z-50 w-72 sm:w-80 max-w-[85vw] bg-slate-950 text-slate-300 flex flex-col border-r border-slate-800/80 transform transition-transform duration-300 ease-in-out lg:translate-x-0 member-sidebar-scroll overflow-y-auto"
               :class="sidebarOpen ? 'translate-x-0 shadow-2xl' : '-translate-x-full'">

            <!-- Sidebar Header / Foundation Brand Badge -->
            <div class="p-5 border-b border-slate-800/80 bg-slate-950/90 sticky top-0 z-10 backdrop-blur-md">
                <div class="flex items-center justify-between">
                    <a href="{{ route('member.dashboard') }}" class="flex items-center gap-3 group">
                        <x-brand-logo class="w-10 h-10 shrink-0 drop-shadow-md group-hover:scale-105 transition-transform" />
                        <div class="min-w-0">
                            <span class="block text-xs font-extrabold uppercase tracking-widest text-white font-serif-title truncate">
                                Brands Academy
                            </span>
                            <span class="block text-[10px] font-bold tracking-wider text-amber-400 uppercase">
                                Nigeria Foundation
                            </span>
                        </div>
                    </a>

                    <!-- Close button on mobile -->
                    <button @click="sidebarOpen = false" class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors" title="Close Sidebar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Legal Entity Pill -->
                <div class="mt-3 flex items-center justify-between pt-2.5 border-t border-slate-800/60 text-[10px]">
                    <span class="inline-flex items-center gap-1.5 font-bold text-emerald-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Member Portal Active
                    </span>
                    <span class="text-slate-400 font-mono">RC 7344471</span>
                </div>
            </div>

            <!-- Member Identity Card in Sidebar -->
            @if($currentMember)
                <div class="p-4 mx-3 mt-4 rounded-2xl bg-gradient-to-br from-slate-900 to-slate-900/90 border border-slate-800 relative overflow-hidden shadow-md">
                    <!-- Glow -->
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-500/10 rounded-full blur-xl pointer-events-none"></div>

                    <div class="flex items-center gap-3 mb-3 relative z-10">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 via-amber-500 to-amber-600 text-slate-950 font-extrabold text-base flex items-center justify-center shadow-md font-serif-title shrink-0">
                            {{ substr($currentMember->first_name ?? (auth()->user()?->name ?? 'Member'), 0, 1) }}{{ substr($currentMember->last_name ?? '', 0, 1) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <span class="inline-block px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30 truncate mb-0.5">
                                {{ $currentMember->category_label }}
                            </span>
                            <h3 class="text-xs font-bold text-white truncate font-serif-title">
                                {{ $currentMember->full_name }}
                            </h3>
                            <p class="text-[10px] text-slate-400 truncate">
                                {{ $currentMember->designation ?? 'Foundation Member' }}
                            </p>
                        </div>
                    </div>

                    <!-- Member ID Strip with 1-Click Copy -->
                    <div class="p-2 rounded-xl bg-slate-950/70 border border-slate-800 flex items-center justify-between gap-2">
                        <div class="min-w-0">
                            <span class="block text-[8px] uppercase font-bold text-slate-400 tracking-wider">Member ID</span>
                            <span class="text-xs font-extrabold font-mono text-amber-400 block truncate">
                                {{ $currentMember->member_number ?? 'MEMBER-ACTIVE' }}
                            </span>
                        </div>
                        <button type="button" @click="copyMemberId('{{ $currentMember->member_number }}')"
                                class="px-2 py-1 rounded-lg text-[10px] font-bold bg-slate-800 hover:bg-slate-700 text-amber-400 border border-slate-700 transition-colors flex items-center gap-1 shrink-0 cursor-pointer shadow-2xs"
                                title="Copy Member ID">
                            <svg x-show="!copiedId" class="w-3 h-3 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <svg x-show="copiedId" x-cloak class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="copiedId ? 'Copied!' : 'Copy'"></span>
                        </button>
                    </div>

                    <div class="mt-2 text-[10px] text-slate-400 flex items-center justify-between">
                        <span>Jurisdiction:</span>
                        <span class="text-slate-300 font-semibold truncate">{{ $currentMember->state }}, {{ $currentMember->country ?? 'Nigeria' }}</span>
                    </div>
                </div>
            @endif

            <!-- Navigation Links -->
            <nav class="flex-1 p-3 space-y-1 text-xs font-medium">

                <div class="px-3 py-2 text-[10px] uppercase font-bold text-slate-400 tracking-wider">
                    Member Navigation
                </div>

                <!-- 1. Overview -->
                <button type="button" @click="switchTab('overview')"
                        :class="activeTab === 'overview' ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white'"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-all text-left cursor-pointer group">
                    <span class="flex items-center gap-3">
                        <svg class="w-4 h-4" :class="activeTab === 'overview' ? 'text-slate-950' : 'text-amber-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span>Dashboard Overview</span>
                    </span>
                    <span class="text-[10px] font-mono" :class="activeTab === 'overview' ? 'text-slate-950 font-bold' : 'opacity-60'">&rarr;</span>
                </button>

                <!-- 2. Workshop Cohorts -->
                <button type="button" @click="switchTab('cohorts')"
                        :class="activeTab === 'cohorts' ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white'"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-all text-left cursor-pointer group">
                    <span class="flex items-center gap-3">
                        <svg class="w-4 h-4" :class="activeTab === 'cohorts' ? 'text-slate-950' : 'text-amber-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>Workshop Cohorts</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        @if($openWorkshopsCount > 0)
                            <span class="px-1.5 py-0.2 rounded-full text-[9px] font-extrabold font-mono"
                                  :class="activeTab === 'cohorts' ? 'bg-slate-950 text-amber-400' : 'bg-amber-400 text-slate-950'">
                                {{ $openWorkshopsCount }} Open
                            </span>
                        @endif
                        <span class="px-1.5 py-0.2 rounded text-[9px] font-bold"
                              :class="activeTab === 'cohorts' ? 'bg-slate-950/20 text-slate-950' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30'">
                            25% Off
                        </span>
                    </span>
                </button>

                <!-- 3. Certificates -->
                <button type="button" @click="switchTab('certificates')"
                        :class="activeTab === 'certificates' ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white'"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-all text-left cursor-pointer group">
                    <span class="flex items-center gap-3">
                        <svg class="w-4 h-4" :class="activeTab === 'certificates' ? 'text-slate-950' : 'text-amber-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>My Certificates</span>
                    </span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold"
                          :class="activeTab === 'certificates' ? 'bg-slate-950 text-amber-400' : 'bg-slate-800 text-slate-400'">
                        {{ $certificatesCount }}
                    </span>
                </button>

                <!-- 4. Applications -->
                <button type="button" @click="switchTab('applications')"
                        :class="activeTab === 'applications' ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white'"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-all text-left cursor-pointer group">
                    <span class="flex items-center gap-3">
                        <svg class="w-4 h-4" :class="activeTab === 'applications' ? 'text-slate-950' : 'text-amber-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <span>Application History</span>
                    </span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold"
                          :class="activeTab === 'applications' ? 'bg-slate-950 text-amber-400' : 'bg-slate-800 text-slate-400'">
                        {{ $applicationsCount }}
                    </span>
                </button>

                <!-- 5. Digital Member ID -->
                @if($currentMember)
                    <button type="button" @click="switchTab('digital-id')"
                            :class="activeTab === 'digital-id' ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white'"
                            class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-all text-left cursor-pointer group">
                        <span class="flex items-center gap-3">
                            <svg class="w-4 h-4" :class="activeTab === 'digital-id' ? 'text-slate-950' : 'text-amber-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <span>Digital Member ID</span>
                        </span>
                        <span class="px-1.5 py-0.2 rounded text-[9px] font-bold"
                              :class="activeTab === 'digital-id' ? 'bg-slate-950 text-amber-400' : 'bg-amber-500/20 text-amber-400'">
                            Live QR
                        </span>
                    </button>
                @endif

                <!-- 6. Profile & Settings -->
                <button type="button" @click="switchTab('profile')"
                        :class="activeTab === 'profile' ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white'"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-all text-left cursor-pointer group">
                    <span class="flex items-center gap-3">
                        <svg class="w-4 h-4" :class="activeTab === 'profile' ? 'text-slate-950' : 'text-amber-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>Profile &amp; Settings</span>
                    </span>
                    <span class="text-[10px] font-mono" :class="activeTab === 'profile' ? 'text-slate-950 font-bold' : 'opacity-60'">&rarr;</span>
                </button>

                <!-- 25% Member Benefit Box in Sidebar -->
                <div class="pt-3">
                    <div class="p-3.5 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-200">
                        <div class="flex items-start gap-2.5 mb-2">
                            <span class="w-6 h-6 rounded-lg bg-amber-500 text-slate-950 flex items-center justify-center font-extrabold text-xs shrink-0 shadow-2xs">
                                %
                            </span>
                            <div>
                                <h4 class="text-xs font-bold text-white leading-tight">25% Member Discount</h4>
                                <p class="text-[10px] text-slate-400 mt-0.5 leading-relaxed">
                                    Automatic tuition reduction on all Brands Academy cohorts.
                                </p>
                            </div>
                        </div>
                        <button type="button" @click="switchTab('cohorts')" class="w-full py-2 px-3 rounded-xl text-[11px] font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors flex items-center justify-center gap-1 shadow-xs cursor-pointer">
                            <span>Browse Cohorts</span>
                            <span>&rarr;</span>
                        </button>
                    </div>
                </div>

                <!-- Credential Tools Block -->
                @if($currentMember)
                    <div class="pt-3 space-y-1.5">
                        <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 block">
                            Credential Tools
                        </span>

                        <!-- Certificate PDF -->
                        <a href="{{ route('membership.certificate.download', $currentMember->qr_code_token) }}"
                           class="w-full py-2 px-3 rounded-xl text-[11px] font-semibold bg-slate-900 hover:bg-slate-800 text-white transition-colors flex items-center justify-between border border-slate-800">
                            <span class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span>Certificate PDF</span>
                            </span>
                            <span class="text-slate-400 text-[10px]">&darr;</span>
                        </a>

                        <!-- Digital Card -->
                        <a href="{{ route('membership.card', $currentMember->qr_code_token) }}" target="_blank"
                           class="w-full py-2 px-3 rounded-xl text-[11px] font-semibold bg-slate-900/60 hover:bg-slate-800 text-slate-300 hover:text-white transition-colors flex items-center justify-between border border-slate-800/80">
                            <span class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                <span>Open Digital Card</span>
                            </span>
                            <span class="text-slate-400 text-[10px]">&nearr;</span>
                        </a>

                        <!-- Copy Verification Link -->
                        <button type="button" @click="copyVerificationUrl('{{ route('verify.certificate', $currentMember->qr_code_token) }}')"
                                class="w-full py-2 px-3 rounded-xl text-[11px] font-semibold bg-slate-900/60 hover:bg-slate-800 text-slate-300 hover:text-white transition-colors flex items-center justify-between border border-slate-800/80 cursor-pointer">
                            <span class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                <span x-text="copiedUrl ? 'Link Copied!' : 'Copy Verification Link'"></span>
                            </span>
                            <span class="text-slate-400 text-[9px] font-mono">URL</span>
                        </button>
                    </div>
                @endif

                <!-- Admin Link if Admin -->
                @if(auth()->user()?->isAdmin())
                    <div class="pt-3">
                        <a href="{{ route('admin.dashboard') }}"
                           class="w-full py-2 px-3 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-amber-400 border border-slate-800 transition-colors flex items-center justify-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Admin Control Center</span>
                        </a>
                    </div>
                @endif

            </nav>

            <!-- Sidebar Footer / Quick Site Actions & Sign Out -->
            <div class="p-4 border-t border-slate-800/80 bg-slate-950/90 space-y-2.5">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between px-3 py-2 rounded-xl text-[11px] font-semibold text-slate-400 hover:text-amber-300 hover:bg-slate-900 transition-colors">
                    <span class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span>Public Foundation Site</span>
                    </span>
                    <span>&rarr;</span>
                </a>

                <div class="pt-2 border-t border-slate-800/60 flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2 min-w-0">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/20 text-amber-400 border border-amber-500/30 flex items-center justify-center font-bold text-xs shrink-0">
                            {{ substr(auth()->user()?->name ?? 'M', 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <span class="block text-xs font-bold text-white truncate">{{ auth()->user()?->name ?? 'Member' }}</span>
                            <span class="block text-[10px] text-amber-400 font-semibold truncate">{{ auth()->user()?->role ?? 'Member' }}</span>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-slate-900 transition-colors cursor-pointer" title="Sign Out">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        <!-- ======================= MAIN CONTENT WRAPPER ======================= -->
        <div class="flex-1 lg:pl-80 flex flex-col min-h-screen">

            <!-- Top Sticky Member Bar -->
            <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between gap-4">

                <div class="flex items-center gap-3">
                    <!-- Mobile Hamburger -->
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors cursor-pointer" title="Open Member Sidebar">
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
            <main class="flex-1 pb-24 lg:pb-16">
                @yield('content')
            </main>

            <!-- Member Portal Footer -->
            <footer class="px-4 sm:px-6 lg:px-8 py-4 pb-20 lg:pb-4 bg-white border-t border-slate-200 text-slate-400 text-xs flex flex-col sm:flex-row items-center justify-between gap-2">
                <div>
                    <strong>Brands Academy Nigeria Foundation</strong> &bull; Incorporated Trustee &bull; CAC IT No. 7344471
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
    <nav class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-slate-950/95 backdrop-blur-md border-t border-slate-800 safe-pb shadow-lg">
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
        function memberLayoutComponent() {
            const validTabs = ['overview', 'cohorts', 'certificates', 'applications', 'digital-id', 'profile'];
            const getInitialTab = () => {
                const hash = (window.location.hash || '').replace('#', '').trim();
                if (validTabs.includes(hash)) return hash;
                const params = new URLSearchParams(window.location.search);
                const queryTab = params.get('tab');
                if (validTabs.includes(queryTab)) return queryTab;
                return 'overview';
            };

            return {
                sidebarOpen: false,
                activeTab: getInitialTab(),
                copiedId: false,
                copiedUrl: false,

                init() {
                    window.addEventListener('hashchange', () => {
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
                    this.activeTab = tabName;
                    this.sidebarOpen = false;
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
