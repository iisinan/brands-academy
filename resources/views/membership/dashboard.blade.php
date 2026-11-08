@extends('layouts.app')

@section('title', 'Member Dashboard - ' . $member->full_name)

@push('styles')
<style>
    @keyframes checkmarkPop {
        0% { transform: scale(0) rotate(-15deg); opacity: 0; }
        60% { transform: scale(1.2) rotate(4deg); opacity: 1; }
        100% { transform: scale(1) rotate(0deg); opacity: 1; }
    }
    @keyframes strokeCheck {
        0% { stroke-dashoffset: 32; }
        100% { stroke-dashoffset: 0; }
    }
    .anim-check-pop {
        animation: checkmarkPop 0.36s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        transform-origin: center center;
    }
    .anim-check-stroke {
        stroke-dasharray: 32;
        stroke-dashoffset: 32;
        animation: strokeCheck 0.32s cubic-bezier(0.65, 0, 0.45, 1) 0.08s forwards;
    }
    .field-interactive {
        transition: border-color 0.22s ease, box-shadow 0.22s ease, background-color 0.22s ease, transform 0.15s ease;
    }
    .card-preview-glow {
        box-shadow: 0 25px 50px -12px rgba(245, 158, 11, 0.25), 0 0 0 1px rgba(245, 158, 11, 0.2);
    }
</style>
@endpush

@section('content')

<div x-data="memberDashboardComponent({
    initialPhone: @js($member->phone),
    initialState: @js($member->state),
    initialCountry: @js($member->country ?? 'Nigeria'),
    initialBio: @js($member->bio ?? ''),
    memberNumber: @js($member->member_number),
    verificationUrl: @js(route('verify.certificate', $member->qr_code_token))
})">

    <!-- Member Top Profile Banner -->
    <section id="overview" class="scroll-mt-20 bg-slate-900 text-white py-12 border-b border-slate-800 relative overflow-hidden">
        <!-- Ambient decorative glow -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-amber-400 via-amber-500 to-amber-600 text-slate-950 font-bold text-2xl sm:text-3xl flex items-center justify-center shadow-lg font-serif-title ring-4 ring-amber-500/20 shrink-0">
                        {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                {{ $member->category_label }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                Active Member in Good Standing
                            </span>
                            @if(auth()->user()->isAdmin())
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-400 text-slate-950">
                                    Administrator View
                                </span>
                            @endif
                        </div>
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold font-serif-title tracking-tight">
                            {{ $member->full_name }}
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-400 mt-1 flex flex-wrap items-center gap-2">
                            <span>{{ $member->designation ?? 'Foundation Member' }}</span>
                            <span>&bull;</span>
                            <span>{{ $member->institution_or_company ?? 'Brands Academy Nigeria Foundation' }}</span>
                            <span>&bull;</span>
                            <span class="text-slate-300">{{ $member->state }}, {{ $member->country ?? 'Nigeria' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Member ID Pill & Quick Actions -->
                <div class="flex flex-wrap items-center gap-3">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2.5 rounded-2xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-amber-400 border border-slate-700 transition-colors flex items-center gap-1.5 whitespace-nowrap shadow-xs">
                            &larr; Admin Control Panel
                        </a>
                    @endif
                    <div class="bg-white/10 backdrop-blur-md p-3.5 sm:p-4 rounded-2xl border border-white/15 flex items-center justify-between sm:justify-start gap-4 shadow-lg">
                        <div>
                            <span class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider">Official Member ID</span>
                            <span class="text-sm sm:text-base font-extrabold font-mono text-amber-400">{{ $member->member_number }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <!-- Download Official Certificate PDF -->
                            <a href="{{ route('membership.certificate.download', $member->qr_code_token) }}" class="px-3 py-2 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white border border-white/10 transition-colors flex items-center gap-1.5 shadow-sm" title="Download Official Membership Certificate (PDF)">
                                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span class="hidden sm:inline">Certificate PDF</span>
                            </a>
                            <!-- Quick View Modal Trigger -->
                            <button type="button" @click="showCardModal = true" class="px-3 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors flex items-center gap-1.5 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span>Quick Credential</span>
                            </button>
                            <!-- Standalone Card Link -->
                            <a href="{{ route('membership.card', $member->qr_code_token) }}" target="_blank" class="p-2 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white transition-colors" title="Open Full Digital Card">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Key Metrics Summary Strip -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8 pt-6 border-t border-slate-800/80">
                <div class="bg-slate-800/60 rounded-xl p-3.5 border border-slate-700/60">
                    <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">Member Classification</span>
                    <span class="text-sm sm:text-base font-extrabold text-white mt-0.5 block">{{ $member->category_label }}</span>
                </div>
                <div class="bg-slate-800/60 rounded-xl p-3.5 border border-slate-700/60">
                    <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">Cohort Applications</span>
                    <span class="text-sm sm:text-base font-extrabold text-amber-400 mt-0.5 block">{{ $applications->count() }} Submitted</span>
                </div>
                <div class="bg-slate-800/60 rounded-xl p-3.5 border border-slate-700/60">
                    <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">Earned Credentials</span>
                    <span class="text-sm sm:text-base font-extrabold text-emerald-400 mt-0.5 block">{{ $certificates->count() }} Issued</span>
                </div>
                <div class="bg-slate-800/60 rounded-xl p-3.5 border border-slate-700/60">
                    <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">Registered Since</span>
                    <span class="text-sm sm:text-base font-extrabold text-slate-200 mt-0.5 block">{{ \Carbon\Carbon::parse($member->joined_at)->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Main Content Grid with Responsive Member Sidebar -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">

        <!-- Mobile Horizontal Sticky Sub-Nav / Drawer Trigger (< lg) -->
        <div class="lg:hidden mb-6 space-y-3">
            <div class="flex items-center justify-between bg-white p-3.5 rounded-2xl border border-slate-200 shadow-xs">
                <div class="flex items-center gap-2.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-bold text-slate-800 font-mono">{{ $member->member_number }}</span>
                    <span class="text-[10px] text-slate-500">&bull; {{ $member->category_label }}</span>
                </div>
                <button type="button" @click="mobileSidebarOpen = true" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-900 text-amber-400 hover:bg-slate-800 transition-colors flex items-center gap-1.5 cursor-pointer shadow-xs">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <span>Member Menu</span>
                </button>
            </div>

            <!-- Horizontal Scroll Pills for Instant Section Jump -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1 no-scrollbar text-xs">
                <button type="button" @click="scrollTo('cohorts')"
                        :class="activeSection === 'cohorts' ? 'bg-amber-500 text-slate-950 font-bold' : 'bg-white text-slate-700 border border-slate-200'"
                        class="px-3.5 py-1.5 rounded-full whitespace-nowrap transition-colors shadow-2xs cursor-pointer">
                    Cohorts ({{ $openWorkshops->count() }})
                </button>
                <button type="button" @click="scrollTo('certificates')"
                        :class="activeSection === 'certificates' ? 'bg-amber-500 text-slate-950 font-bold' : 'bg-white text-slate-700 border border-slate-200'"
                        class="px-3.5 py-1.5 rounded-full whitespace-nowrap transition-colors shadow-2xs cursor-pointer">
                    Certificates ({{ $certificates->count() }})
                </button>
                <button type="button" @click="scrollTo('applications')"
                        :class="activeSection === 'applications' ? 'bg-amber-500 text-slate-950 font-bold' : 'bg-white text-slate-700 border border-slate-200'"
                        class="px-3.5 py-1.5 rounded-full whitespace-nowrap transition-colors shadow-2xs cursor-pointer">
                    Applications ({{ $applications->count() }})
                </button>
                <button type="button" @click="scrollTo('profile')"
                        :class="activeSection === 'profile' ? 'bg-amber-500 text-slate-950 font-bold' : 'bg-white text-slate-700 border border-slate-200'"
                        class="px-3.5 py-1.5 rounded-full whitespace-nowrap transition-colors shadow-2xs cursor-pointer">
                    Profile &amp; Settings
                </button>
                <button type="button" @click="showCardModal = true"
                        class="px-3.5 py-1.5 rounded-full whitespace-nowrap bg-amber-50 text-amber-900 border border-amber-300 font-bold shadow-2xs cursor-pointer">
                    Digital ID QR
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- Desktop Sticky Sidebar (lg:col-span-4 xl:col-span-3) -->
            <aside class="hidden lg:block lg:col-span-4 xl:col-span-3 lg:sticky lg:top-24 space-y-5">
                <x-member-sidebar
                    :member="$member"
                    :open-workshops="$openWorkshops"
                    :certificates="$certificates"
                    :applications="$applications" />
            </aside>

            <!-- Main Content Area (lg:col-span-8 xl:col-span-9) -->
            <main class="lg:col-span-8 xl:col-span-9 space-y-10 min-w-0">

                <!-- 1. Currently Open Cohorts Fast-Apply Section -->
                <div id="cohorts" class="scroll-mt-28">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 font-serif-title">Cohorts Open for Applications</h2>
                        <p class="text-xs sm:text-sm text-slate-500">Apply during active windows with your verified Member ID.</p>
                    </div>
                    <a href="{{ route('workshops.index') }}" class="text-xs sm:text-sm font-bold text-amber-600 hover:text-amber-700 hover:underline flex items-center gap-1">
                        <span>View all cohorts</span>
                        <span>&rarr;</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($openWorkshops as $workshop)
                        @php $window = $workshop->application_window_status; @endphp
                        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs hover:shadow-md transition-all flex flex-col justify-between group">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $window['badge_class'] }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        {{ $window['label'] }}
                                    </span>
                                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                                        {{ ucfirst($workshop->delivery_mode) }}
                                    </span>
                                </div>
                                <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-1 group-hover:text-amber-600 transition-colors leading-snug">
                                    {{ $workshop->title }}
                                </h3>
                                <div class="text-xs text-amber-700 font-semibold mb-3">
                                    {{ $workshop->track_label }}
                                </div>
                                <p class="text-xs sm:text-sm text-slate-600 line-clamp-2 mb-4 leading-relaxed">
                                    {{ $workshop->tagline ?? $workshop->description }}
                                </p>
                            </div>
                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <span class="block text-[10px] uppercase font-bold text-slate-400">Member Tuition (25% Off)</span>
                                    @if($workshop->fee_type == 'free')
                                        <span class="text-xs sm:text-sm font-extrabold text-emerald-700">100% Free Track</span>
                                    @else
                                        <div class="flex items-baseline gap-1.5">
                                            <span class="text-xs sm:text-sm font-extrabold text-slate-900 font-mono">NGN {{ number_format($workshop->member_fee_amount) }}</span>
                                            <span class="text-[10px] text-slate-400 line-through">NGN {{ number_format($workshop->fee_amount) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <a href="{{ route('workshops.show', $workshop->slug) }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors shadow-xs">
                                    Apply Now &rarr;
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 bg-white p-8 rounded-2xl border border-dashed border-slate-200 text-center">
                            <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <h4 class="font-bold text-slate-800 text-sm mb-1">No Cohorts Currently Open</h4>
                            <p class="text-xs text-slate-500 max-w-md mx-auto">
                                All cohort application windows are currently closed for admissions evaluation. Check back soon for the next enrollment schedule.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- 2. My Earned Certificates & Digital Badges -->
            <div id="certificates" class="scroll-mt-28">
                <div class="mb-4">
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900 font-serif-title">My Earned Certificates</h2>
                    <p class="text-xs sm:text-sm text-slate-500">Official, verifiable credentials awarded upon completing Academy cohorts.</p>
                </div>

                @if($certificates->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($certificates as $cert)
                            <div class="bg-white rounded-2xl border-2 border-amber-500/30 p-6 shadow-md relative overflow-hidden flex flex-col justify-between">
                                <div class="absolute -right-6 -bottom-6 w-28 h-28 bg-amber-500/10 rounded-full blur-xl pointer-events-none"></div>
                                <div>
                                    <div class="flex items-center justify-between gap-2 mb-3">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Verified Credential
                                        </span>
                                        <span class="text-xs font-mono font-bold text-slate-500">{{ $cert->certificate_number }}</span>
                                    </div>

                                    <h3 class="text-lg font-bold text-slate-900 mb-1 font-serif-title">
                                        {{ $cert->course_title }}
                                    </h3>
                                    <div class="text-xs font-semibold text-amber-700 mb-2">
                                        {{ $cert->track_tier }}
                                    </div>
                                    <p class="text-xs text-slate-500 mb-4">
                                        Issued on {{ $cert->issued_at->format('F d, Y') }} &bull; Brands Academy Nigeria Foundation
                                    </p>
                                </div>

                                <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center gap-3">
                                    <a href="{{ route('certificates.download', $cert->verification_token) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white transition-colors shadow-xs">
                                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        Download PDF
                                    </a>
                                    <a href="{{ route('verify.certificate', $cert->verification_token) }}" target="_blank" class="inline-flex items-center gap-1 px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        Verify Online
                                    </a>
                                    <!-- 1-Click Copy Verification URL -->
                                    <button type="button" @click="copyCertLink('{{ route('verify.certificate', $cert->verification_token) }}')" class="inline-flex items-center gap-1 px-3 py-2 rounded-xl text-xs font-bold border border-slate-200 hover:bg-slate-50 text-slate-600 transition-colors">
                                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                        <span x-text="copiedCertUrl === '{{ route('verify.certificate', $cert->verification_token) }}' ? 'Copied!' : 'Copy Link'">Copy Link</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white p-8 sm:p-10 rounded-2xl border border-dashed border-slate-200 text-center">
                        <div class="w-12 h-12 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h4 class="font-bold text-slate-800 text-sm sm:text-base mb-1">No Certificates Issued Yet</h4>
                        <p class="text-xs sm:text-sm text-slate-500 max-w-md mx-auto">
                            Once you apply for and successfully complete an academy cohort or workshop, your verifiable Certificate of Achievement will appear here with cryptographic validation.
                        </p>
                    </div>
                @endif
            </div>

            <!-- 3. My Submitted Applications History -->
            <div id="applications" class="scroll-mt-28">
                <div class="mb-4">
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900 font-serif-title">My Application History</h2>
                    <p class="text-xs sm:text-sm text-slate-500">Track admission decisions and cohort progression.</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
                    @if($applications->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs">
                                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold text-[10px]">
                                    <tr>
                                        <th class="px-6 py-4">Programme / Workshop</th>
                                        <th class="px-6 py-4">Submission Date</th>
                                        <th class="px-6 py-4">Tuition Type</th>
                                        <th class="px-6 py-4">Admissions Status</th>
                                        <th class="px-6 py-4 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($applications as $app)
                                        <tr class="hover:bg-slate-50/60 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="font-bold text-slate-900 text-sm">{{ $app->workshop->title }}</div>
                                                <div class="text-[11px] text-amber-700 font-semibold">{{ $app->workshop->track_label }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-slate-600">
                                                {{ $app->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($app->scholarship_requested)
                                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">
                                                        Subsidy Requested
                                                    </span>
                                                @else
                                                    <span class="text-slate-700 font-semibold uppercase text-[10px]">
                                                        {{ $app->workshop->fee_type }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($app->status === 'accepted')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                        Accepted &bull; Active
                                                    </span>
                                                @elseif($app->status === 'pending')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                        Under Admissions Review
                                                    </span>
                                                @elseif($app->status === 'completed')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                                        <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                        Cohort Completed
                                                    </span>
                                                @else
                                                    <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $app->status_badge['class'] }}">
                                                        {{ $app->status_badge['label'] }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right space-x-2">
                                                @if(in_array($app->status, ['accepted', 'completed']))
                                                    <a href="{{ route('member.portfolio.create', $app->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors shadow-xs">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                        {{ $app->portfolioSubmissions->count() > 0 ? 'Portfolio (' . $app->portfolioSubmissions->count() . ')' : 'Submit Portfolio' }}
                                                    </a>
                                                @endif
                                                <a href="{{ route('workshops.show', $app->workshop->slug) }}" class="font-bold text-slate-600 hover:text-amber-600 text-xs">
                                                    View Cohort &rarr;
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-8 text-center text-xs sm:text-sm text-slate-500">
                            You have not applied for any training cohorts yet. Check the open cohorts section above to apply!
                        </div>
                    @endif
                </div>
            </div>

            <!-- 4. Member Profile & Contact Information -->
            <div id="profile" class="scroll-mt-28 bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
                <div class="mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900 font-serif-title">Member Profile & Registry Information</h2>
                    <p class="text-xs sm:text-sm text-slate-500">Keep your professional affiliations and contact records up to date.</p>
                </div>

                <form action="{{ route('member.profile.update') }}" method="POST" @submit="isSubmitting = true" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Phone Number with Nigerian & International Carrier Detection -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-xs font-bold text-slate-700 uppercase">Phone Number *</label>
                                <div class="flex items-center gap-1.5">
                                    <span x-show="phoneCarrier" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[10px] font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span x-text="phoneCarrier"></span>
                                    </span>
                                    <span x-show="isPhoneValid" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                                        <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 flex items-center justify-center">
                                            <svg class="w-2.5 h-2.5 anim-check-stroke text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        </span>
                                        <span>Valid</span>
                                    </span>
                                </div>
                            </div>
                            <input type="text" name="phone" x-model="phone" @blur="formatPhone()" required
                                   class="w-full px-3.5 py-2.5 rounded-xl border text-xs sm:text-sm field-interactive focus:outline-none"
                                   :class="isPhoneValid ? 'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10' : 'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20'"
                                   placeholder="e.g. +234 803 123 4567">
                        </div>

                        <!-- Country Selection -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-xs font-bold text-slate-700 uppercase">Country *</label>
                                <span x-show="isCountryValid" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                                    <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 flex items-center justify-center">
                                        <svg class="w-2.5 h-2.5 anim-check-stroke text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </span>
                                    <span>Country Set</span>
                                </span>
                            </div>
                            <select name="country" x-model="country" @change="onCountryChange()" required
                                    class="w-full px-3.5 py-2.5 rounded-xl border text-xs sm:text-sm field-interactive bg-white focus:outline-none"
                                    :class="isCountryValid ? 'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10' : 'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20'">
                                <optgroup label="Primary Country">
                                    <option value="Nigeria">Nigeria</option>
                                </optgroup>
                                <optgroup label="Neighboring &amp; West African Countries">
                                    <option value="Benin">Benin Republic</option>
                                    <option value="Cameroon">Cameroon</option>
                                    <option value="Chad">Chad</option>
                                    <option value="Niger">Niger Republic</option>
                                    <option value="Ghana">Ghana</option>
                                    <option value="Togo">Togo</option>
                                    <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                                    <option value="Senegal">Senegal</option>
                                    <option value="Sierra Leone">Sierra Leone</option>
                                    <option value="Liberia">Liberia</option>
                                    <option value="The Gambia">The Gambia</option>
                                    <option value="Mali">Mali</option>
                                    <option value="Guinea">Guinea</option>
                                    <option value="Burkina Faso">Burkina Faso</option>
                                </optgroup>
                                <optgroup label="Other African Nations">
                                    <option value="Kenya">Kenya</option>
                                    <option value="Rwanda">Rwanda</option>
                                    <option value="South Africa">South Africa</option>
                                    <option value="Egypt">Egypt</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="Tanzania">Tanzania</option>
                                    <option value="Ethiopia">Ethiopia</option>
                                </optgroup>
                                <optgroup label="Diaspora &amp; International">
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="United States">United States</option>
                                    <option value="Canada">Canada</option>
                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                    <option value="Other">Other International</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- State of Residence (Dropdown for Nigeria, Interactive input for Neighbors/International) -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block text-xs font-bold text-slate-700 uppercase" x-text="country === 'Nigeria' ? 'State of Residence *' : 'State / Province / Region *'"></label>
                                <span x-show="isStateValid" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                                    <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 flex items-center justify-center">
                                        <svg class="w-2.5 h-2.5 anim-check-stroke text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </span>
                                    <span x-text="country === 'Nigeria' ? 'State Set' : 'Region Set'"></span>
                                </span>
                            </div>

                            <!-- If Nigeria: Dropdown with ALL 36 Nigerian States + FCT Abuja -->
                            <template x-if="country === 'Nigeria'">
                                <select name="state" x-model="state" required
                                        class="w-full px-3.5 py-2.5 rounded-xl border text-xs sm:text-sm field-interactive bg-white focus:outline-none"
                                        :class="isStateValid ? 'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10' : 'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20'">
                                    <option value="" disabled>-- Select Nigerian State --</option>
                                    <template x-for="st in nigerianStates" :key="st">
                                        <option :value="st" x-text="st" :selected="state === st"></option>
                                    </template>
                                </select>
                            </template>

                            <!-- If Neighboring / International: Region / Province input with datalist -->
                            <template x-if="country !== 'Nigeria'">
                                <div>
                                    <input type="text" name="state" x-model="state" list="dashboard-regions" required
                                           class="w-full px-3.5 py-2.5 rounded-xl border text-xs sm:text-sm field-interactive focus:outline-none"
                                           :class="isStateValid ? 'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10' : 'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20'"
                                           :placeholder="getRegionPlaceholder()">
                                    <datalist id="dashboard-regions">
                                        <template x-for="rg in currentCountryRegions" :key="rg">
                                            <option :value="rg"></option>
                                        </template>
                                    </datalist>
                                </div>
                            </template>
                        </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Organization or Institution</label>
                            <input type="text" name="institution_or_company" value="{{ old('institution_or_company', $member->institution_or_company) }}" placeholder="e.g. Veritas Design Studio / Ahmadu Bello University" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Designation / Role</label>
                            <input type="text" name="designation" value="{{ old('designation', $member->designation) }}" placeholder="e.g. Senior Brand Strategist / Marketing Fellow" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-bold text-slate-700 uppercase">Professional Bio / Focus</label>
                            <span class="text-[11px] text-slate-400" x-text="`${1000 - bio.length} characters left`"></span>
                        </div>
                        <textarea name="bio" x-model="bio" maxlength="1000" rows="3" placeholder="Brief statement regarding your practice, expertise, and institutional focus..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" :disabled="isSubmitting" class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors flex items-center gap-2 shadow-xs disabled:opacity-70">
                            <svg x-show="isSubmitting" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <span>Save Profile Changes</span>
                        </button>
                    </div>
                </form>
            </div>

            </main>
        </div>
    </section>

    <!-- Mobile Sidebar Drawer (< lg) -->
    <div x-show="mobileSidebarOpen" x-cloak
         class="fixed inset-0 z-50 lg:hidden overflow-hidden"
         role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm transition-opacity"
             x-show="mobileSidebarOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileSidebarOpen = false"></div>

        <!-- Sliding Panel -->
        <div class="fixed inset-y-0 left-0 max-w-xs w-full bg-slate-50 shadow-2xl flex flex-col z-10 overflow-y-auto p-5"
             x-show="mobileSidebarOpen"
             x-transition:enter="ease-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full">

            <div class="flex items-center justify-between pb-4 mb-3 border-b border-slate-200">
                <span class="font-serif-title font-bold text-slate-900 text-sm">Member Navigation</span>
                <button type="button" @click="mobileSidebarOpen = false" class="p-1.5 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-200 transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <x-member-sidebar
                :member="$member"
                :open-workshops="$openWorkshops"
                :certificates="$certificates"
                :applications="$applications" />
        </div>
    </div>

    <!-- Digital Credential Modal -->
    <div x-show="showCardModal" x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity"
             x-show="showCardModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showCardModal = false"></div>

        <!-- Modal Dialog -->
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-slate-900 text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl border border-amber-500/30 p-6 sm:p-8"
                 x-show="showCardModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <!-- Close Button -->
                <button type="button" @click="showCardModal = false" class="absolute top-5 right-5 text-slate-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <!-- Credential Header -->
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center p-1.5 shadow-md">
                        <img src="{{ asset('images/logo/bran-logo-128.png') }}" alt="Logo" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white font-serif-title">Foundation Digital Credential</h3>
                        <p class="text-xs text-amber-400">Brands Academy Nigeria Foundation &bull; CAC IT No. 7344471</p>
                    </div>
                </div>

                <!-- Credential Card Preview -->
                <div class="bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 rounded-2xl border-2 border-amber-500/40 p-6 relative overflow-hidden shadow-xl mb-6">
                    <div class="absolute -right-8 -bottom-8 w-36 h-36 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>

                    <div class="flex flex-col sm:flex-row items-center sm:items-start justify-between gap-6">
                        <div class="space-y-3 text-center sm:text-left">
                            <div>
                                <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30 mb-1">
                                    {{ $member->category_label }}
                                </span>
                                <h4 class="text-xl font-extrabold text-white font-serif-title">{{ $member->full_name }}</h4>
                                <p class="text-xs text-slate-400">{{ $member->designation ?? 'Foundation Member' }}</p>
                            </div>

                            <div class="space-y-1 text-xs">
                                <div class="text-slate-400">
                                    <span>Member ID: </span>
                                    <span class="font-mono font-bold text-amber-400">{{ $member->member_number }}</span>
                                </div>
                                <div class="text-slate-400">
                                    <span>Jurisdiction: </span>
                                    <span class="font-semibold text-slate-300">{{ $member->state }}, {{ $member->country ?? 'Nigeria' }}</span>
                                </div>
                                <div class="text-slate-400">
                                    <span>Status: </span>
                                    <span class="font-semibold text-emerald-400">Active &bull; Verified</span>
                                </div>
                            </div>
                        </div>

                        <!-- QR Verification Code -->
                        <div class="bg-white p-3 rounded-xl border border-amber-500/30 shadow-md shrink-0 flex flex-col items-center">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 flex items-center justify-center">
                                {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(105)->generate(route('verify.certificate', $member->qr_code_token)) !!}
                            </div>
                            <span class="text-[9px] font-mono text-slate-600 mt-1 uppercase font-bold tracking-tight">Scan to Verify</span>
                        </div>
                    </div>
                </div>

                <!-- Credential Action Buttons -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                    <!-- Download Official Certificate (PDF) -->
                    <a href="{{ route('membership.certificate.download', $member->qr_code_token) }}" class="py-2.5 px-4 rounded-xl font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors flex items-center justify-center gap-2 shadow-xs col-span-1 sm:col-span-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Download Official Certificate of Membership (PDF)</span>
                    </a>

                    <!-- 1-Click Copy Member ID -->
                    <button type="button" @click="copyMemberId()" class="py-2.5 px-4 rounded-xl font-bold bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <span x-text="copiedMemberId ? 'Member ID Copied!' : 'Copy Member ID'"></span>
                    </button>

                    <!-- 1-Click Copy Verification URL -->
                    <button type="button" @click="copyVerificationUrl()" class="py-2.5 px-4 rounded-xl font-bold bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        <span x-text="copiedUrl ? 'Verification Link Copied!' : 'Copy Verification Link'"></span>
                    </button>

                    <!-- Standalone Card View -->
                    <a href="{{ route('membership.card', $member->qr_code_token) }}" target="_blank" class="py-2.5 px-4 rounded-xl font-bold bg-white/10 hover:bg-white/20 text-white border border-white/10 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span>Open High-Res Digital Card</span>
                    </a>

                    <!-- Share on WhatsApp -->
                    @php
                        $whatsAppShareUrl = 'https://api.whatsapp.com/send?text=' . urlencode("Verify my official membership with Brands Academy Nigeria Foundation: " . route('verify.certificate', $member->qr_code_token));
                    @endphp
                    <a href="{{ $whatsAppShareUrl }}" target="_blank" rel="noopener noreferrer" class="py-2.5 px-4 rounded-xl font-bold bg-[#25D366] hover:bg-[#20ba59] text-white transition-colors flex items-center justify-center gap-2 shadow-xs">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.303c-.086.086-.177.18-.076.353.101.173.45 743 965 1.202.664.591 1.224.774 1.397.86.173.086.274.072.375-.043.101-.116.433-.506.549-.68.116-.173.231-.144.39-.086s1.011.477 1.184.564.289.13.332.202c.043.072.043.419-.101.824z"/></svg>
                        <span>Share on WhatsApp</span>
                    </a>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    function memberDashboardComponent(config) {
        return {
            phone: config.initialPhone || '',
            state: config.initialState || '',
            country: config.initialCountry || 'Nigeria',
            bio: config.initialBio || '',
            memberNumber: config.memberNumber || '',
            verificationUrl: config.verificationUrl || '',
            showCardModal: false,
            isSubmitting: false,
            copiedMemberId: false,
            copiedUrl: false,
            copiedCertUrl: '',
            activeSection: 'cohorts',
            mobileSidebarOpen: false,

            scrollTo(sectionId) {
                this.activeSection = sectionId;
                this.mobileSidebarOpen = false;
                const el = document.getElementById(sectionId);
                if (el) {
                    const yOffset = -90;
                    const y = el.getBoundingClientRect().top + window.pageYOffset + yOffset;
                    window.scrollTo({ top: y, behavior: 'smooth' });
                }
            },

            nigerianStates: [
                'Abia', 'Adamawa', 'Akwa Ibom', 'Anambra', 'Bauchi', 'Bayelsa', 'Benue', 'Borno',
                'Cross River', 'Delta', 'Ebonyi', 'Edo', 'Ekiti', 'Enugu', 'FCT Abuja', 'Gombe',
                'Imo', 'Jigawa', 'Kaduna', 'Kano', 'Katsina', 'Kebbi', 'Kogi', 'Kwara',
                'Lagos', 'Nasarawa', 'Niger', 'Ogun', 'Ondo', 'Osun', 'Oyo', 'Plateau',
                'Rivers', 'Sokoto', 'Taraba', 'Yobe', 'Zamfara'
            ],

            countryRegions: {
                'Ghana': ['Greater Accra', 'Ashanti', 'Northern', 'Western', 'Central', 'Eastern', 'Volta', 'Upper East', 'Upper West', 'Bono', 'Bono East', 'Ahafo', 'Oti', 'Savannah', 'North East', 'Western North'],
                'Cameroon': ['Centre (Yaoundé)', 'Littoral (Douala)', 'Adamawa', 'Far North', 'North', 'Northwest', 'South', 'Southwest', 'West', 'East'],
                'Niger': ['Niamey', 'Agadez', 'Diffa', 'Dosso', 'Maradi', 'Tahoua', 'Tillabéri', 'Zinder'],
                'Benin': ['Littoral (Cotonou)', 'Atlantique', 'Ouémé (Porto-Novo)', 'Borgou', 'Zou', 'Collines', 'Atakora', 'Alibori', 'Mono', 'Couffo', 'Plateau', 'Donga'],
                'Chad': ["N'Djamena", 'Chari-Baguirmi', 'Mayo-Kebbi', 'Logone', 'Ouaddaï', 'Batha', 'Kanem', 'Guéra', 'Wadi Fira', 'Salamat'],
                'Togo': ['Maritime (Lomé)', 'Plateaux', 'Centrale', 'Kara', 'Savanes'],
                "Côte d'Ivoire": ['Abidjan', 'Yamoussoukro', 'Bas-Sassandra', 'Comoé', 'Gôh-Djiboua', 'Lacs', 'Lagunes', 'Montagnes', 'Sassandra-Marahoué', 'Savanes', 'Vallée du Bandama', 'Woroba', 'Zanzan'],
                'Kenya': ['Nairobi', 'Mombasa', 'Kisumu', 'Nakuru', 'Eldoret', 'Kiambu', 'Machakos', 'Kilifi'],
                'Rwanda': ['Kigali', 'Eastern Province', 'Northern Province', 'Southern Province', 'Western Province'],
                'South Africa': ['Gauteng (Johannesburg/Pretoria)', 'Western Cape (Cape Town)', 'KwaZulu-Natal (Durban)', 'Eastern Cape', 'Free State', 'Limpopo', 'Mpumalanga', 'North West', 'Northern Cape'],
                'United Kingdom': ['England - London', 'England - Greater Manchester', 'England - West Midlands', 'Scotland - Edinburgh/Glasgow', 'Wales - Cardiff', 'Northern Ireland - Belfast'],
                'United States': ['California', 'New York', 'Texas', 'Florida', 'Georgia', 'Illinois', 'Maryland', 'Washington D.C.']
            },

            get currentCountryRegions() {
                return this.countryRegions[this.country] || [];
            },

            get isCountryValid() {
                return (this.country || '').trim().length >= 2;
            },

            get isPhoneValid() {
                const digits = (this.phone || '').replace(/[^0-9]/g, '');
                return digits.length >= 10 && digits.length <= 15;
            },

            get isStateValid() {
                if (this.country === 'Nigeria') {
                    return this.nigerianStates.includes((this.state || '').trim());
                }
                return (this.state || '').trim().length >= 2;
            },

            onCountryChange() {
                if (this.country === 'Nigeria') {
                    if (!this.nigerianStates.includes(this.state)) {
                        this.state = 'Kaduna';
                    }
                } else {
                    const regions = this.countryRegions[this.country];
                    if (regions && regions.length > 0) {
                        this.state = regions[0];
                    } else {
                        this.state = '';
                    }
                }
            },

            getRegionPlaceholder() {
                switch(this.country) {
                    case 'Ghana': return 'e.g. Greater Accra, Ashanti, Northern';
                    case 'Cameroon': return 'e.g. Littoral (Douala), Centre (Yaoundé)';
                    case 'Niger': return 'e.g. Niamey, Maradi, Zinder';
                    case 'Benin': return 'e.g. Littoral (Cotonou), Atlantique, Ouémé';
                    case 'Chad': return "e.g. N'Djamena, Chari-Baguirmi";
                    case 'Togo': return 'e.g. Maritime (Lomé), Plateaux';
                    case "Côte d'Ivoire": return 'e.g. Abidjan, Yamoussoukro';
                    case 'Kenya': return 'e.g. Nairobi, Mombasa';
                    case 'United Kingdom': return 'e.g. England - London, Scotland';
                    case 'United States': return 'e.g. Texas, New York, California';
                    default: return 'Enter state, province, or region...';
                }
            },

            get phoneCarrier() {
                const raw = (this.phone || '').replace(/[^0-9]/g, '');
                let prefix = '';
                if (raw.startsWith('234') && raw.length >= 6) {
                    prefix = '0' + raw.substring(3, 6);
                } else if (raw.startsWith('0') && raw.length >= 4) {
                    prefix = raw.substring(0, 4);
                }
                const mtn = ['0803', '0806', '0703', '0706', '0813', '0816', '0810', '0814', '0903', '0906', '0913', '0916'];
                const airtel = ['0802', '0808', '0708', '0812', '0701', '0902', '0901', '0904', '0907', '0912'];
                const glo = ['0805', '0807', '0705', '0815', '0811', '0905', '0915'];
                const nineMobile = ['0809', '0817', '0818', '0909', '0908'];

                if (mtn.includes(prefix)) return 'MTN Nigeria';
                if (airtel.includes(prefix)) return 'Airtel Nigeria';
                if (glo.includes(prefix)) return 'Glo Mobile';
                if (nineMobile.includes(prefix)) return '9mobile';

                // Neighboring & International network detection
                if (raw.startsWith('233')) return 'Ghana (+233)';
                if (raw.startsWith('237')) return 'Cameroon (+237)';
                if (raw.startsWith('227')) return 'Niger (+227)';
                if (raw.startsWith('229')) return 'Benin (+229)';
                if (raw.startsWith('235')) return 'Chad (+235)';
                if (raw.startsWith('228')) return 'Togo (+228)';
                if (raw.startsWith('225')) return "Côte d'Ivoire (+225)";
                if (raw.startsWith('254')) return 'Kenya (+254)';
                if (raw.startsWith('44')) return 'UK (+44)';
                if (raw.startsWith('1') && raw.length >= 11) return 'US/Canada (+1)';
                return '';
            },

            formatPhone() {
                let cleaned = (this.phone || '').trim().replace(/[^\d+]/g, '');
                if (cleaned.startsWith('0') && cleaned.length === 11) {
                    cleaned = '+234 ' + cleaned.substring(1, 4) + ' ' + cleaned.substring(4, 7) + ' ' + cleaned.substring(7);
                } else if (cleaned.startsWith('234') && cleaned.length === 13) {
                    cleaned = '+' + cleaned.substring(0, 3) + ' ' + cleaned.substring(3, 6) + ' ' + cleaned.substring(6, 9) + ' ' + cleaned.substring(9);
                }
                this.phone = cleaned;
            },

            copyMemberId() {
                if (navigator.clipboard && this.memberNumber) {
                    navigator.clipboard.writeText(this.memberNumber).then(() => {
                        this.copiedMemberId = true;
                        setTimeout(() => { this.copiedMemberId = false; }, 2500);
                    });
                }
            },

            copyVerificationUrl() {
                if (navigator.clipboard && this.verificationUrl) {
                    navigator.clipboard.writeText(this.verificationUrl).then(() => {
                        this.copiedUrl = true;
                        setTimeout(() => { this.copiedUrl = false; }, 2500);
                    });
                }
            },

            copyCertLink(url) {
                if (navigator.clipboard && url) {
                    navigator.clipboard.writeText(url).then(() => {
                        this.copiedCertUrl = url;
                        setTimeout(() => { this.copiedCertUrl = ''; }, 2500);
                    });
                }
            }
        };
    }
</script>
@endpush
