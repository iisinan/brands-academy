@extends('layouts.member')

@section('title', 'Member Dashboard - ' . $member->full_name)
@section('page_title', 'Member Dashboard')

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
    @media print {
        body {
            background: #ffffff !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        nav, header, footer, aside, .no-print, [x-show="activeTab !== 'digital-id'"] {
            display: none !important;
        }
        #digital-id-card-container {
            break-inside: avoid !important;
            page-break-inside: avoid !important;
            margin: 0 auto !important;
            box-shadow: none !important;
        }
    }
</style>
@endpush

@section('content')

<div x-data="memberDashboardComponent({
    initialTab: @js(request('tab', 'overview')),
    initialPhone: @js($member->phone),
    initialState: @js($member->state),
    initialCountry: @js($member->country ?? 'Nigeria'),
    initialBio: @js($member->bio ?? ''),
    memberNumber: @js($member->member_number),
    verificationUrl: @js(route('verify.certificate', $member->qr_code_token))
})"
@open-card-modal.window="switchTab('digital-id')"
class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-8">

    <!-- ==================== TAB 1: EXECUTIVE OVERVIEW ==================== -->
    <div x-show="activeTab === 'overview'" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="space-y-8">

        <!-- Executive Hero Profile Card -->
        <div id="overview" class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white p-6 sm:p-8 border border-slate-800 shadow-xl">
            <!-- Ambient decorative glow -->
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 space-y-6">
                <!-- Top Profile & Identification Row -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <!-- Member Avatar with Gold Gradient Ring -->
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-amber-400 via-amber-500 to-amber-600 text-slate-950 font-extrabold text-2xl sm:text-3xl flex items-center justify-center shadow-lg font-serif-title ring-4 ring-amber-500/30 shrink-0">
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
                                @if(auth()->user()?->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-400 text-slate-950 hover:bg-amber-300 transition-colors">
                                        Administrator View &rarr;
                                    </a>
                                @endif
                            </div>
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold font-serif-title tracking-tight text-white">
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

                    <!-- Official Member ID Pill & Quick Credential Tools -->
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="bg-white/10 backdrop-blur-md p-3 sm:p-3.5 rounded-2xl border border-white/15 flex items-center justify-between sm:justify-start gap-4 shadow-lg">
                            <div>
                                <span class="block text-[9px] uppercase font-bold text-slate-400 tracking-wider">Official Member ID</span>
                                <span class="text-sm sm:text-base font-extrabold font-mono text-amber-400">{{ $member->member_number }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <!-- Download Official Certificate PDF -->
                                <a href="{{ route('membership.certificate.download', $member->qr_code_token) }}" class="px-3 py-2 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white border border-white/10 transition-colors flex items-center gap-1.5 shadow-sm" title="Download Official Membership Certificate (PDF)">
                                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span class="hidden sm:inline">Certificate PDF</span>
                                </a>
                                <!-- CPD Official Transcript -->
                                <a href="{{ route('member.transcript') }}" class="px-3 py-2 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white border border-white/10 transition-colors flex items-center gap-1.5 shadow-sm" title="View Official Continuing Professional Development (CPD) Transcript">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span class="hidden sm:inline">CPD Transcript</span>
                                </a>
                                @if($member->member_number)
                                    <a href="{{ route('registry.show', $member->member_number) }}" target="_blank" class="px-3 py-2 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white border border-white/10 transition-colors flex items-center gap-1.5 shadow-sm" title="View My Public Certified Practitioner Dossier">
                                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        <span class="hidden sm:inline">Registry Profile</span>
                                    </a>
                                @endif
                                <!-- Switch to Digital ID Tab -->
                                <button type="button" @click="switchTab('digital-id')" class="px-3 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors flex items-center gap-1.5 shadow-sm cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span>Digital ID</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Key Metrics Summary Strip -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-6 border-t border-slate-800/80">
                    <div class="bg-slate-800/60 rounded-2xl p-4 border border-slate-700/60">
                        <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">Member Classification</span>
                        <span class="text-base sm:text-lg font-extrabold text-white mt-1 block">{{ $member->category_label }}</span>
                        <span class="text-[11px] text-emerald-400 font-semibold mt-0.5 block">&bull; Good Standing</span>
                    </div>
                    <button type="button" @click="switchTab('applications')" class="bg-slate-800/60 hover:bg-slate-800 rounded-2xl p-4 border border-slate-700/60 text-left transition-colors cursor-pointer group">
                        <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">Cohort Applications</span>
                        <span class="text-base sm:text-lg font-extrabold text-amber-400 mt-1 block group-hover:underline">{{ $applications->count() }} Submitted &rarr;</span>
                        <span class="text-[11px] text-slate-400 mt-0.5 block">25% Discount Applied</span>
                    </button>
                    <button type="button" @click="switchTab('certificates')" class="bg-slate-800/60 hover:bg-slate-800 rounded-2xl p-4 border border-slate-700/60 text-left transition-colors cursor-pointer group">
                        <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">Earned Credentials</span>
                        <span class="text-base sm:text-lg font-extrabold text-emerald-400 mt-1 block group-hover:underline">{{ $certificates->count() }} Issued &rarr;</span>
                        <span class="text-[11px] text-slate-400 mt-0.5 block">Officially Verified</span>
                    </button>
                    <div class="bg-slate-800/60 rounded-2xl p-4 border border-slate-700/60">
                        <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">Registered Since</span>
                        <span class="text-base sm:text-lg font-extrabold text-slate-200 mt-1 block">{{ \Carbon\Carbon::parse($member->joined_at)->format('M d, Y') }}</span>
                        <span class="text-[11px] text-slate-400 mt-0.5 block font-mono">CAC/IT/No. 7344471</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 25% Member Benefit Banner -->
        <div class="p-6 rounded-3xl bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 text-slate-950 shadow-md flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <span class="w-12 h-12 rounded-2xl bg-slate-950 text-amber-400 font-extrabold text-xl flex items-center justify-center shrink-0 shadow-sm font-serif-title">
                    %
                </span>
                <div>
                    <h3 class="text-base sm:text-lg font-extrabold text-slate-950 font-serif-title">25% Automatic Member Tuition Reduction</h3>
                    <p class="text-xs sm:text-sm text-slate-800 font-medium mt-0.5">As an active member in good standing, you receive an automatic 25% discount across all professional Brand Academy cohorts.</p>
                </div>
            </div>
            <button type="button" @click="switchTab('cohorts')" class="px-5 py-3 rounded-2xl text-xs font-bold bg-slate-950 hover:bg-slate-900 text-white transition-colors shrink-0 flex items-center justify-center gap-1.5 shadow-md cursor-pointer whitespace-nowrap">
                <span>Browse Cohorts (25% Off)</span>
                <span>&rarr;</span>
            </button>
        </div>

        <!-- Member Navigation Hub: 4 Interactive Feature Tiles -->
        <div>
            <div class="mb-4">
                <h3 class="text-base font-bold text-slate-900 font-serif-title">Member Navigation Hub</h3>
                <p class="text-xs text-slate-500">Jump directly to any section of your membership workspace.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Card 1: Workshop Cohorts -->
                <button type="button" @click="switchTab('cohorts')" class="p-5 rounded-3xl bg-white border border-slate-200 hover:border-amber-400 hover:shadow-lg transition-all text-left group cursor-pointer flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-11 h-11 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-slate-950 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">25% Off</span>
                        </div>
                        <h4 class="text-sm font-bold text-slate-900 group-hover:text-amber-700 transition-colors">Workshop Cohorts</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Enroll in professional brand training with 25% member tuition discount.</p>
                    </div>
                    <span class="mt-4 inline-flex items-center gap-1 text-xs font-bold text-amber-600 group-hover:translate-x-1 transition-transform">Browse Cohorts &rarr;</span>
                </button>

                <!-- Card 2: My Certificates -->
                <button type="button" @click="switchTab('certificates')" class="p-5 rounded-3xl bg-white border border-slate-200 hover:border-amber-400 hover:shadow-lg transition-all text-left group cursor-pointer flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-11 h-11 rounded-2xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 font-mono">{{ $certificates->count() }} Issued</span>
                        </div>
                        <h4 class="text-sm font-bold text-slate-900 group-hover:text-amber-700 transition-colors">My Certificates</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Download official PDF certificates &amp; cryptographic verification links.</p>
                    </div>
                    <span class="mt-4 inline-flex items-center gap-1 text-xs font-bold text-amber-600 group-hover:translate-x-1 transition-transform">View Credentials &rarr;</span>
                </button>

                <!-- Card 3: Application History -->
                <button type="button" @click="switchTab('applications')" class="p-5 rounded-3xl bg-white border border-slate-200 hover:border-amber-400 hover:shadow-lg transition-all text-left group cursor-pointer flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-11 h-11 rounded-2xl bg-blue-500/10 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 font-mono">{{ $applications->count() }} Total</span>
                        </div>
                        <h4 class="text-sm font-bold text-slate-900 group-hover:text-amber-700 transition-colors">Application History</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Track admission review status, admission offers, and portfolio submissions.</p>
                    </div>
                    <span class="mt-4 inline-flex items-center gap-1 text-xs font-bold text-amber-600 group-hover:translate-x-1 transition-transform">Track Status &rarr;</span>
                </button>

                <!-- Card 4: Digital Member ID -->
                <button type="button" @click="switchTab('digital-id')" class="p-5 rounded-3xl bg-white border border-slate-200 hover:border-amber-400 hover:shadow-lg transition-all text-left group cursor-pointer flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-11 h-11 rounded-2xl bg-amber-500/10 text-amber-600 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-slate-950 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Live QR</span>
                        </div>
                        <h4 class="text-sm font-bold text-slate-900 group-hover:text-amber-700 transition-colors">Digital Member ID</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">View and download your official 3D card slip with tamper-evident QR code.</p>
                    </div>
                    <span class="mt-4 inline-flex items-center gap-1 text-xs font-bold text-amber-600 group-hover:translate-x-1 transition-transform">Open Digital ID &rarr;</span>
                </button>
            </div>
        </div>

        <!-- Recent Application Activity Snapshot -->
        @if($applications->isNotEmpty())
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-900 font-serif-title">Recent Application Pipeline</h3>
                    <button type="button" @click="switchTab('applications')" class="text-xs font-bold text-amber-600 hover:underline cursor-pointer">
                        View All ({{ $applications->count() }}) &rarr;
                    </button>
                </div>

                <div class="divide-y divide-slate-100">
                    @foreach($applications->take(3) as $app)
                        <div class="py-3 flex items-center justify-between gap-4">
                            <div class="min-w-0">
                                <span class="text-xs font-bold text-slate-900 block truncate">{{ $app->workshop->title }}</span>
                                <span class="text-[10px] text-slate-400">Applied {{ $app->created_at->diffForHumans() }} &bull; {{ $app->workshop->track_label }}</span>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase shrink-0
                                {{ $app->status === 'accepted' ? 'bg-emerald-100 text-emerald-800' :
                                  ($app->status === 'completed' ? 'bg-purple-100 text-purple-800' :
                                  ($app->status === 'waitlisted' ? 'bg-amber-100 text-amber-800' :
                                  ($app->status === 'rejected' ? 'bg-rose-100 text-rose-800' : 'bg-slate-100 text-slate-700'))) }}">
                                {{ $app->status }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Ecosystem Services & Activities Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- 1. LMS Learning Hub Snapshot -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 font-serif-title">LMS Classroom &amp; Short Courses</h3>
                    </div>
                    <a href="{{ route('member.courses.index') }}" class="text-xs font-bold text-amber-600 hover:underline">
                        My Classroom &rarr;
                    </a>
                </div>

                @if($courseEnrollments->isNotEmpty())
                    <div class="divide-y divide-slate-100">
                        @foreach($courseEnrollments as $enrollment)
                            <div class="py-3 flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <span class="text-xs font-bold text-slate-900 block truncate">{{ $enrollment->course->title }}</span>
                                    <div class="flex items-center gap-2 mt-1">
                                        <div class="w-24 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                            <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ $enrollment->progress_percent }}%"></div>
                                        </div>
                                        <span class="text-[10px] text-slate-500 font-mono">{{ $enrollment->progress_percent }}%</span>
                                    </div>
                                </div>
                                <a href="{{ route('member.courses.learn', $enrollment->course->slug) }}" class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shrink-0">
                                    Continue
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-center">
                        <p class="text-xs text-slate-500">Explore self-paced masterclasses with automated verifiable certificates.</p>
                        <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-1 mt-2 text-xs font-bold text-blue-600 hover:underline">
                            Browse Online Courses &rarr;
                        </a>
                    </div>
                @endif
            </div>

            <!-- 2. CAC & Brand IP Legal Filings Snapshot -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 font-serif-title">CAC, Trademark &amp; IP Desk</h3>
                    </div>
                    <a href="{{ route('member.filings.index') }}" class="text-xs font-bold text-amber-600 hover:underline">
                        Case Room &rarr;
                    </a>
                </div>

                @if($serviceFilings->isNotEmpty())
                    <div class="divide-y divide-slate-100">
                        @foreach($serviceFilings as $filing)
                            <div class="py-3 flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <span class="text-xs font-bold text-slate-900 block truncate">{{ $filing->proposed_name }}</span>
                                    <span class="text-[10px] text-slate-500">{{ $filing->service_label }} &bull; Ref: {{ $filing->tracking_code }}</span>
                                </div>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase shrink-0 {{ $filing->status === 'completed' ? 'bg-emerald-100 text-emerald-800' : ($filing->status === 'query_raised' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800') }}">
                                    {{ $filing->status_label }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-center">
                        <p class="text-xs text-slate-500">Protect your enterprise identity with CAC business registration and Trademark filings.</p>
                        <a href="{{ route('services.wizard') }}" class="inline-flex items-center gap-1 mt-2 text-xs font-bold text-emerald-600 hover:underline">
                            File New Service (25% Member Discount) &rarr;
                        </a>
                    </div>
                @endif
            </div>

            <!-- 3. Masterclasses & Upcoming Webinars Snapshot -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 font-serif-title">Live Webinars &amp; Masterclasses</h3>
                    </div>
                    <a href="{{ route('webinars.index') }}" class="text-xs font-bold text-amber-600 hover:underline">
                        Browse Hub &rarr;
                    </a>
                </div>

                @if($webinarRegistrations->isNotEmpty())
                    <div class="divide-y divide-slate-100">
                        @foreach($webinarRegistrations as $reg)
                            <div class="py-3 flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <span class="text-xs font-bold text-slate-900 block truncate">{{ $reg->webinar->title }}</span>
                                    <span class="text-[10px] text-slate-500">{{ $reg->webinar->starts_at->format('M d, Y @ h:i A') }}</span>
                                </div>
                                <a href="{{ route('webinars.calendar', $reg->webinar->slug) }}" class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200 hover:bg-purple-100 shrink-0">
                                    .ICS Invite
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-center">
                        <p class="text-xs text-slate-500">Participate in live masterclasses with industry CMOs and brand researchers.</p>
                        <a href="{{ route('webinars.index') }}" class="inline-flex items-center gap-1 mt-2 text-xs font-bold text-purple-600 hover:underline">
                            View Webinar Schedule &rarr;
                        </a>
                    </div>
                @endif
            </div>

            <!-- 4. Conferences & Summits Passes Snapshot -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 font-serif-title">Summit Passes &amp; CFP</h3>
                    </div>
                    <a href="{{ route('conferences.index') }}" class="text-xs font-bold text-amber-600 hover:underline">
                        Summits &rarr;
                    </a>
                </div>

                @if($conferenceDelegates->isNotEmpty())
                    <div class="divide-y divide-slate-100">
                        @foreach($conferenceDelegates as $del)
                            <div class="py-3 flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <span class="text-xs font-bold text-slate-900 block truncate">{{ $del->conference->title }}</span>
                                    <span class="text-[10px] text-slate-500">{{ $del->ticket->name }} &bull; Pass #{{ $del->badge_code }}</span>
                                </div>
                                <a href="{{ route('conferences.badge', $del->badge_code) }}" target="_blank" class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-300 hover:bg-amber-200 shrink-0">
                                    Digital Pass
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-center">
                        <p class="text-xs text-slate-500">Access annual brand leadership summits and submit empirical research papers.</p>
                        <a href="{{ route('conferences.index') }}" class="inline-flex items-center gap-1 mt-2 text-xs font-bold text-amber-600 hover:underline">
                            Explore Upcoming Summits &rarr;
                        </a>
                    </div>
                @endif
            </div>

        </div>

    </div>

    <!-- ==================== TAB 2: WORKSHOP COHORTS ==================== -->
    <div x-show="activeTab === 'cohorts'" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="space-y-6">

        <section id="cohorts" class="scroll-mt-24 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/15 text-amber-800 border border-amber-500/30">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                        25% Member Benefit Automatically Applied
                    </span>
                    <span class="text-slate-400 text-xs hidden sm:inline">&bull;</span>
                    <span class="text-slate-500 text-xs hidden sm:inline">No Promo Code Required</span>
                </div>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-900 font-serif-title">Cohorts Open for Applications</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Enroll during active application windows with your verified Member ID.</p>
            </div>
            <a href="{{ route('workshops.index') }}" class="text-xs sm:text-sm font-bold text-amber-600 hover:text-amber-700 flex items-center gap-1 self-start sm:self-auto hover:underline">
                <span>View Full Curriculum &amp; Faculty</span>
                <span>&rarr;</span>
            </a>
        </div>

        <!-- Real-Time Cohort Search & Track Filter Bar -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-white p-3 rounded-2xl border border-slate-200/90 shadow-2xs">
            <div class="relative flex-1">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" x-model="cohortSearch" placeholder="Filter cohorts by keyword, track, or subject..." class="w-full pl-9 pr-4 py-2 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
            </div>
            <div class="flex items-center gap-1 overflow-x-auto no-scrollbar py-0.5 text-xs font-semibold">
                <button type="button" @click="cohortTrackFilter = 'all'" :class="cohortTrackFilter === 'all' ? 'bg-slate-900 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap cursor-pointer">All Tracks</button>
                <button type="button" @click="cohortTrackFilter = 'executive'" :class="cohortTrackFilter === 'executive' ? 'bg-slate-900 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap cursor-pointer">Executive</button>
                <button type="button" @click="cohortTrackFilter = 'design'" :class="cohortTrackFilter === 'design' ? 'bg-slate-900 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap cursor-pointer">Design</button>
                <button type="button" @click="cohortTrackFilter = 'strategy'" :class="cohortTrackFilter === 'strategy' ? 'bg-slate-900 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap cursor-pointer">Strategy</button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($openWorkshops as $workshop)
                @php
                    $window = $workshop->application_window_status;
                    $userApplication = $applications->firstWhere('workshop_id', $workshop->id);
                @endphp
                <div x-show="matchesCohortFilter(@js($workshop->title), @js($workshop->track_label))"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="bg-white rounded-3xl border {{ $userApplication ? ($userApplication->status === 'accepted' ? 'border-emerald-300/90 ring-1 ring-emerald-500/20' : ($userApplication->status === 'completed' ? 'border-purple-300/90 ring-1 ring-purple-500/20' : 'border-blue-300/90 ring-1 ring-blue-500/20')) : 'border-slate-200/90 hover:border-amber-400' }} p-6 shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            @if($userApplication)
                                @if($userApplication->status === 'accepted')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Enrolled &bull; Active
                                    </span>
                                @elseif($userApplication->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                        Application Submitted
                                    </span>
                                @elseif($userApplication->status === 'completed')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-800 border border-purple-300">
                                        <svg class="w-3 h-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Cohort Completed
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-300">
                                        Application: {{ ucfirst($userApplication->status) }}
                                    </span>
                                @endif
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $window['badge_class'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    {{ $window['label'] }}
                                </span>
                            @endif
                            <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                                {{ ucfirst($workshop->delivery_mode) }}
                            </span>
                        </div>
                        <h3 class="font-bold text-slate-900 text-base sm:text-lg mb-1 group-hover:text-amber-600 transition-colors leading-snug font-serif-title">
                            {{ $workshop->title }}
                        </h3>
                        <div class="text-xs text-amber-700 font-semibold mb-3">
                            {{ $workshop->track_label }}
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 line-clamp-2 mb-3 leading-relaxed">
                            {{ $workshop->tagline ?? $workshop->description }}
                        </p>

                        @if($userApplication)
                            <div class="mt-3 p-3 rounded-2xl {{ $userApplication->status === 'accepted' ? 'bg-emerald-50/80 border border-emerald-200/90 text-emerald-950' : ($userApplication->status === 'completed' ? 'bg-purple-50/80 border border-purple-200/90 text-purple-950' : 'bg-blue-50/80 border border-blue-200/90 text-blue-950') }} text-xs">
                                <div class="flex items-center justify-between font-bold mb-1">
                                    <span class="flex items-center gap-1.5">
                                        @if($userApplication->status === 'accepted')
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            <span>Admissions Confirmed</span>
                                        @elseif($userApplication->status === 'pending')
                                            <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                                            <span>Under Admissions Review</span>
                                        @elseif($userApplication->status === 'completed')
                                            <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                                            <span>Cohort Completed</span>
                                        @else
                                            <span>Status: {{ ucfirst($userApplication->status) }}</span>
                                        @endif
                                    </span>
                                    <span class="font-mono text-[10px] text-slate-500">{{ $userApplication->created_at->format('M d, Y') }}</span>
                                </div>
                                <p class="text-[11px] leading-relaxed text-slate-600">
                                    @if($userApplication->status === 'accepted')
                                        Your application is accepted and active. You are enrolled in this training cohort.
                                    @elseif($userApplication->status === 'pending')
                                        You have already submitted your application for this cohort. It is currently under review by the admissions committee.
                                    @elseif($userApplication->status === 'completed')
                                        You have successfully graduated from this cohort. Your certificate is verified in your registry portfolio.
                                    @else
                                        Application record on file.
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
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

                        @if($userApplication)
                                @if($userApplication->status === 'accepted')
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('member.portfolio.create', $userApplication->id) }}" class="px-3 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors shadow-xs flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span>Portfolio</span>
                                    </a>
                                    <a href="{{ route('workshops.show', $workshop->slug) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-emerald-100 hover:bg-emerald-200 text-emerald-900 border border-emerald-300 transition-colors flex items-center gap-1">
                                        <span>Enrolled &bull; View &rarr;</span>
                                    </a>
                                </div>
                            @elseif($userApplication->status === 'pending')
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="switchTab('applications')" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-blue-100 hover:bg-blue-200 text-blue-900 border border-blue-300 transition-colors flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                        <svg class="w-3.5 h-3.5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>Already Applied</span>
                                    </button>
                                    <a href="{{ route('workshops.show', $workshop->slug) }}" class="p-2 rounded-xl text-xs font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors border border-slate-200" title="View Workshop Details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
                            @elseif($userApplication->status === 'completed')
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="switchTab('certificates')" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-purple-100 hover:bg-purple-200 text-purple-900 border border-purple-300 transition-colors flex items-center gap-1.5 cursor-pointer">
                                        <svg class="w-3.5 h-3.5 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z"/></svg>
                                        <span>View Credential</span>
                                    </button>
                                    <a href="{{ route('workshops.show', $workshop->slug) }}" class="p-2 rounded-xl text-xs font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors border border-slate-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                </div>
                            @else
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="switchTab('applications')" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-800 border border-slate-300 transition-colors flex items-center gap-1.5 cursor-pointer">
                                        <span>Applied</span>
                                    </button>
                                    <a href="{{ route('workshops.show', $workshop->slug) }}" class="px-2.5 py-2 rounded-xl text-xs font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors border border-slate-200">
                                        <span>Details &nearr;</span>
                                    </a>
                                </div>
                            @endif
                        @else
                            <a href="{{ route('workshops.show', $workshop->slug) }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors shadow-xs flex items-center gap-1">
                                <span>Apply Now</span>
                                <span>&rarr;</span>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-8 sm:p-10 rounded-3xl border border-dashed border-slate-300 text-center shadow-xs">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h4 class="font-bold text-slate-900 text-base mb-1 font-serif-title">Admissions Windows Currently Evaluated</h4>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-lg mx-auto leading-relaxed">
                        All active cohorts are currently in session. The Academy faculty is preparing the upcoming enrollment cycle. You will be notified via email when the next cohort opens.
                    </p>
                    <a href="{{ route('workshops.index') }}" class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white transition-colors">
                        <span>Browse Workshop Archive</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            @endforelse
        </div>
    </section>
    </div>

    <!-- ==================== TAB 3: MY EARNED CERTIFICATES ==================== -->
    <div x-show="activeTab === 'certificates'" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="space-y-6">

    <section id="certificates" class="scroll-mt-24 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                        <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Verifiable Credentials Registry &bull; CAC/IT/No. 7344471
                    </span>
                </div>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-900 font-serif-title">My Earned Certificates</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Official, verifiable credentials awarded upon completing Academy cohorts.</p>
            </div>
            <a href="{{ route('verify.certificate') }}" target="_blank" class="text-xs sm:text-sm font-bold text-slate-600 hover:text-amber-700 flex items-center gap-1 self-start sm:self-auto hover:underline">
                <span>Public Verification Search</span>
                <span>&nearr;</span>
            </a>
        </div>

        <!-- Primary Institutional Credential: Official Certificate of Membership -->
        <div class="bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white rounded-3xl border-2 border-amber-500/40 p-6 sm:p-7 shadow-xl relative overflow-hidden">
            <div class="absolute -right-8 -bottom-8 w-44 h-44 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 text-slate-950 flex items-center justify-center p-2 shadow-md shrink-0">
                        <x-brand-logo class="w-full h-full" />
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                Primary Institutional Credential
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                Good Standing &bull; CAC/IT/No. 7344471
                            </span>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold font-serif-title text-white">
                            Certificate of Foundation Membership
                        </h3>
                        <p class="text-xs text-slate-300 mt-1">
                            Issued to <strong class="text-white">{{ $member->full_name }}</strong> &bull; {{ $member->category_label }} &bull; <span class="font-mono text-amber-400 font-bold">{{ $member->member_number }}</span>
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2.5 self-start lg:self-auto shrink-0">
                    <a href="{{ route('membership.certificate.download', $member->qr_code_token) }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors shadow-md">
                        <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Download PDF Certificate</span>
                    </a>
                    <a href="{{ route('membership.certificate.preview', $member->qr_code_token) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white border border-white/10 transition-colors">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>Preview Certificate</span>
                    </a>
                    <button type="button" @click="copyCertLink('{{ route('verify.certificate', $member->qr_code_token) }}')" class="inline-flex items-center gap-1 px-3 py-2.5 rounded-xl text-xs font-bold border border-slate-700 bg-slate-900/60 hover:bg-slate-800 text-slate-300 transition-colors cursor-pointer">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <span x-text="copiedCertUrl === '{{ route('verify.certificate', $member->qr_code_token) }}' ? 'Copied!' : 'Copy Verification Link'">Copy Verification Link</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="pt-2">
            <h3 class="text-sm font-bold text-slate-900 font-serif-title">Cohort &amp; Workshop Credentials of Achievement</h3>
            <p class="text-xs text-slate-500">Earned certificates awarded upon successful cohort evaluation and graduation.</p>
        </div>

        @if($certificates->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($certificates as $cert)
                    <div class="bg-white rounded-3xl border-2 border-amber-500/40 p-6 sm:p-7 shadow-md relative overflow-hidden flex flex-col justify-between">
                        <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Verified Credential
                                </span>
                                <span class="text-xs font-mono font-bold text-slate-600">{{ $cert->certificate_number }}</span>
                            </div>

                            <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-1 font-serif-title">
                                {{ $cert->course_title }}
                            </h3>
                            <div class="text-xs font-semibold text-amber-700 mb-2">
                                {{ $cert->track_tier }}
                            </div>
                            <p class="text-xs text-slate-500 mb-4">
                                Issued on {{ $cert->issued_at->format('F d, Y') }} &bull; Brands Academy Nigeria Foundation
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center gap-2.5">
                            <a href="{{ route('certificates.download', $cert->verification_token) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white transition-colors shadow-xs">
                                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                <span>Download PDF</span>
                            </a>
                            <a href="{{ route('verify.certificate', $cert->verification_token) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                <span>Verify Online</span>
                            </a>
                            <button type="button" @click="copyCertLink('{{ route('verify.certificate', $cert->verification_token) }}')" class="inline-flex items-center gap-1 px-3 py-2 rounded-xl text-xs font-bold border border-slate-200 hover:bg-slate-50 text-slate-600 transition-colors cursor-pointer">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                <span x-text="copiedCertUrl === '{{ route('verify.certificate', $cert->verification_token) }}' ? 'Copied!' : 'Copy Link'">Copy Link</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Distinguished Credential Journey Roadmap (Polished Empty State) -->
            <div class="bg-gradient-to-br from-white via-amber-50/20 to-white rounded-3xl border border-amber-500/30 p-6 sm:p-8 shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-amber-500/20">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 text-slate-950 flex items-center justify-center shrink-0 shadow-md">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                        <div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-900 border border-amber-500/30 mb-1">
                                Foundation Credential Pathway
                            </span>
                            <h3 class="text-lg sm:text-xl font-bold text-slate-900 font-serif-title">Your Verifiable Certification Portfolio</h3>
                            <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-xl leading-relaxed">
                                Verifiable Certificates of Achievement with secure digital tokens and live QR validation are automatically issued upon cohort graduation and portfolio review.
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('workshops.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors shadow-xs flex items-center justify-center gap-1.5 shrink-0 self-start md:self-auto">
                        <span>Browse Cohorts (25% Off)</span>
                        <span>&rarr;</span>
                    </a>
                </div>

                <!-- 3-Step Milestone Graphic -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-6">
                    <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-2xs">
                        <div class="flex items-center gap-2.5 mb-2">
                            <span class="w-6 h-6 rounded-full bg-amber-500 text-slate-950 font-extrabold text-xs flex items-center justify-center">1</span>
                            <h4 class="text-xs font-bold text-slate-900">Cohort Enrollment</h4>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Apply with your 25% member tuition discount automatically applied without promo codes.
                        </p>
                    </div>

                    <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-2xs">
                        <div class="flex items-center gap-2.5 mb-2">
                            <span class="w-6 h-6 rounded-full bg-slate-900 text-amber-400 font-extrabold text-xs flex items-center justify-center">2</span>
                            <h4 class="text-xs font-bold text-slate-900">Curriculum &amp; Portfolio</h4>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Complete live modules with experienced faculty and submit your practical portfolio.
                        </p>
                    </div>

                    <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-2xs">
                        <div class="flex items-center gap-2.5 mb-2">
                            <span class="w-6 h-6 rounded-full bg-emerald-500 text-white font-extrabold text-xs flex items-center justify-center">3</span>
                            <h4 class="text-xs font-bold text-slate-900">Verifiable Credential</h4>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Receive your official cryptographic certificate, digital badge, and public registry token.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </section>
    </div>

    <!-- ==================== TAB 4: MY APPLICATION HISTORY ==================== -->
    <div x-show="activeTab === 'applications'" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="space-y-6">

    <section id="applications" class="scroll-mt-24 space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-900 font-serif-title">My Application History</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Track admission decisions, tuition verification, and cohort progression.</p>
            </div>
            <!-- Status Filter Pills -->
            <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar py-0.5 text-xs font-semibold">
                <button type="button" @click="appStatusFilter = 'all'" :class="appStatusFilter === 'all' ? 'bg-slate-900 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap cursor-pointer">
                    All ({{ $applications->count() }})
                </button>
                <button type="button" @click="appStatusFilter = 'accepted'" :class="appStatusFilter === 'accepted' ? 'bg-slate-900 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap cursor-pointer">
                    Accepted ({{ $applications->where('status', 'accepted')->count() }})
                </button>
                <button type="button" @click="appStatusFilter = 'pending'" :class="appStatusFilter === 'pending' ? 'bg-slate-900 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap cursor-pointer">
                    Under Review ({{ $applications->where('status', 'pending')->count() }})
                </button>
                <button type="button" @click="appStatusFilter = 'completed'" :class="appStatusFilter === 'completed' ? 'bg-slate-900 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="px-3 py-1.5 rounded-xl transition-all whitespace-nowrap cursor-pointer">
                    Completed ({{ $applications->where('status', 'completed')->count() }})
                </button>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-sm">
            @if($applications->count() > 0)
                <div class="overflow-x-auto touch-scroll">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50/90 border-b border-slate-200 text-slate-500 uppercase font-bold text-[10px] tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Programme / Workshop Cohort</th>
                                <th class="px-6 py-4">Submission Date</th>
                                <th class="px-6 py-4">Tuition Type</th>
                                <th class="px-6 py-4">Admissions Status</th>
                                <th class="px-6 py-4 text-right">Cohort Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($applications as $app)
                                <tr x-show="matchesAppFilter('{{ $app->status }}')"
                                    x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    class="hover:bg-slate-50/60 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-900 text-sm font-serif-title">{{ $app->workshop->title }}</div>
                                        <div class="text-[11px] text-amber-700 font-semibold mt-0.5">{{ $app->workshop->track_label }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 font-mono text-[11px]">
                                        {{ $app->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($app->scholarship_requested)
                                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                                Subsidized
                                            </span>
                                        @else
                                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">
                                                Member Rate (25% Applied)
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($app->status === 'accepted')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                Accepted &bull; Active
                                            </span>
                                        @elseif($app->status === 'pending')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                Under Admissions Review
                                            </span>
                                        @elseif($app->status === 'completed')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-200">
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
                                        <a href="{{ route('workshops.show', $app->workshop->slug) }}" class="font-bold text-slate-700 hover:text-amber-600 text-xs inline-flex items-center gap-1 hover:underline">
                                            <span>View Cohort</span>
                                            <span>&rarr;</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-10 text-center text-xs sm:text-sm text-slate-500">
                    <p>You have not applied for any training cohorts yet.</p>
                    <a href="{{ route('workshops.index') }}" class="mt-3 inline-flex items-center gap-1 text-amber-600 hover:underline font-bold">
                        Browse active cohort application windows &rarr;
                    </a>
                </div>
            @endif
        </div>
    </section>
    </div>

    <!-- ==================== TAB 5: DIGITAL MEMBER ID CARD & VERIFICATION ==================== -->
    <div x-show="activeTab === 'digital-id'" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="space-y-6">

        <section id="digital-id" class="scroll-mt-24 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/15 text-amber-800 border border-amber-500/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Official Credential Active
                        </span>
                        <span class="text-slate-400 text-xs hidden sm:inline">&bull;</span>
                        <span class="text-slate-500 text-xs hidden sm:inline">CAC/IT/No. 7344471</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900 font-serif-title">Digital Member ID &amp; Verification Card</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Your official institutional identification badge with tamper-evident live QR verification code.</p>
                </div>

                <div class="flex items-center gap-2 self-start sm:self-auto">
                    <a href="{{ route('membership.certificate.download', $member->qr_code_token) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white transition-colors shadow-xs">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Download Certificate PDF</span>
                    </a>
                </div>
            </div>

            <!-- Main Digital Card Presentation Card -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

                <!-- Left Column: 3D Physical-Style ID Card (7 cols) -->
                <div class="lg:col-span-7">
                    <div id="digital-id-card-container" class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white p-6 sm:p-8 border-2 border-amber-500/40 shadow-2xl card-preview-glow">
                        <!-- Decorative background light and emblem watermark -->
                        <div class="absolute -right-16 -top-16 w-56 h-56 bg-amber-500/15 rounded-full blur-3xl pointer-events-none"></div>
                        <div class="absolute -left-16 -bottom-16 w-56 h-56 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

                        <!-- Top ID Card Header with 2-Sided Flip Trigger -->
                        <div class="flex items-center justify-between pb-5 border-b border-slate-800/80 relative z-10">
                            <div class="flex items-center gap-3">
                                <x-brand-logo class="w-10 h-10 shrink-0 drop-shadow-md" />
                                <div>
                                    <h3 class="text-xs font-extrabold uppercase tracking-widest text-white font-serif-title">Brands Academy</h3>
                                    <p class="text-[9px] font-bold text-amber-400 uppercase tracking-wider">Nigeria Foundation &bull; CAC/IT/No. 7344471</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                    {{ $member->category_label }}
                                </span>
                                <button type="button" @click="cardSide = cardSide === 'front' ? 'back' : 'front'" class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-slate-900/90 hover:bg-slate-800 text-amber-300 border border-amber-500/30 transition-all flex items-center gap-1.5 cursor-pointer shadow-xs">
                                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    <span x-text="cardSide === 'front' ? 'Flip to Back' : 'Flip to Front'">Flip to Back</span>
                                </button>
                            </div>
                        </div>

                        <!-- Card Front Side -->
                        <div x-show="cardSide === 'front'"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100">
                            <!-- Card Body with Avatar and Details -->
                            <div class="py-6 flex flex-col sm:flex-row items-center sm:items-start justify-between gap-6 relative z-10">
                                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 text-center sm:text-left min-w-0">
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-gradient-to-br from-amber-400 via-amber-500 to-amber-600 text-slate-950 font-extrabold text-2xl sm:text-3xl flex items-center justify-center font-serif-title ring-4 ring-amber-500/30 shadow-lg shrink-0">
                                        {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-xl sm:text-2xl font-bold font-serif-title text-white tracking-tight truncate">
                                            {{ $member->full_name }}
                                        </h4>
                                        <p class="text-xs text-amber-300/90 font-medium mt-0.5">
                                            {{ $member->designation ?? 'Foundation Member' }}
                                        </p>
                                        <p class="text-[11px] text-slate-400 mt-1 truncate">
                                            {{ $member->institution_or_company ?? 'Brands Academy Nigeria Foundation' }}
                                        </p>

                                        <!-- Member ID Callout with Copy -->
                                        <div class="mt-3.5 inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-900/90 border border-slate-700/80">
                                            <span class="text-[9px] uppercase font-bold text-slate-400 tracking-wider">ID:</span>
                                            <span class="text-xs font-mono font-extrabold text-amber-400">{{ $member->member_number }}</span>
                                            <button type="button" @click="copyMemberId()" class="ml-1 text-[10px] text-slate-400 hover:text-white transition-colors cursor-pointer" title="Copy ID">
                                                <svg x-show="!copiedMemberId" class="w-3 h-3 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                                <svg x-show="copiedMemberId" x-cloak class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Scannable 2D QR Code -->
                                <div class="bg-white p-3 rounded-2xl border-2 border-amber-500/40 shadow-xl shrink-0 flex flex-col items-center">
                                    <div class="w-24 h-24 sm:w-28 sm:h-28 flex items-center justify-center">
                                        {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(112)->generate(route('verify.certificate', $member->qr_code_token)) !!}
                                    </div>
                                    <span class="text-[9px] font-mono font-bold text-slate-800 mt-1 uppercase tracking-tight">Scan To Verify</span>
                                </div>
                            </div>

                            <!-- Card Footer Details -->
                            <div class="pt-4 border-t border-slate-800/80 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-400 relative z-10">
                                <div>
                                    <span class="block text-[9px] uppercase font-bold text-slate-400">Jurisdiction</span>
                                    <span class="text-slate-200 font-semibold">{{ $member->state }}, {{ $member->country ?? 'Nigeria' }}</span>
                                </div>
                                <div>
                                    <span class="block text-[9px] uppercase font-bold text-slate-400">Member Status</span>
                                    <span class="inline-flex items-center gap-1 text-emerald-400 font-bold text-xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                        Good Standing
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-[9px] uppercase font-bold text-slate-400">Issued</span>
                                    <span class="text-slate-200 font-mono">{{ \Carbon\Carbon::parse($member->joined_at)->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Back Side (Linear Barcode & Foundation Governance) -->
                        <div x-show="cardSide === 'back'" x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="py-5 space-y-4 relative z-10">

                            <!-- Authentic Code-128 Linear Barcode -->
                            <div class="bg-white p-4 rounded-2xl border border-amber-500/30 text-center max-w-sm mx-auto shadow-md">
                                <img src="{{ $memberBarcode }}" alt="Official Code-128 Linear Barcode" class="h-10 w-full object-contain mx-auto">
                                <span class="block text-[10px] font-mono font-bold text-slate-800 mt-1 uppercase tracking-widest">{{ $member->member_number }}</span>
                            </div>

                            <!-- Statutory Notice & Legal Authority -->
                            <div class="p-3.5 rounded-2xl bg-slate-900/90 border border-slate-800 text-[11px] text-slate-300 leading-relaxed text-center">
                                <p class="text-amber-300 font-bold mb-1">Incorporated Trustee &bull; CAC/IT/No. 7344471</p>
                                <p class="text-[10px] text-slate-400">This pass is the official property of Brands Academy Nigeria Foundation. Governed under Companies and Allied Matters Act 2020 (Part F). Authorised for professional identification and central verification registry queries.</p>
                            </div>

                            <!-- Emergency / Central Registry Contact & Trustee Signature -->
                            <div class="pt-2 border-t border-slate-800/80 flex items-center justify-between text-[10px] text-slate-400">
                                <div class="text-left">
                                    <span class="block font-bold text-slate-300">Central Verification:</span>
                                    <span class="font-mono text-amber-400">brandsacademy.org/verify</span>
                                </div>
                                <div class="text-right">
                                    <span class="block font-bold text-slate-300 font-serif-title italic">Dr. Sinan Ismaila Idris</span>
                                    <span class="block text-[9px] text-amber-400">Director-General / Trustee</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Verification Tools & Quick Actions (5 cols) -->
                <div class="lg:col-span-5 space-y-4">
                    <div class="bg-white rounded-3xl border border-slate-200/90 p-5 sm:p-6 shadow-sm space-y-4">
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 font-serif-title">Official Credential Actions</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Share or present your credentials to clients, employers, and academic institutions.</p>
                        </div>

                        <div class="space-y-2.5 text-xs font-semibold">
                            <!-- Download PDF -->
                            <a href="{{ route('membership.certificate.download', $member->qr_code_token) }}"
                               class="w-full py-2.5 px-4 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold transition-colors flex items-center justify-between shadow-xs">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span>Download Certificate PDF</span>
                                </span>
                                <span class="text-slate-950 font-mono">&darr;</span>
                            </a>

                            <!-- Copy Public Verification URL -->
                            <button type="button" @click="copyVerificationUrl()"
                                    class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white transition-colors flex items-center justify-between cursor-pointer shadow-xs">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                    <span x-text="copiedUrl ? 'Verification URL Copied!' : 'Copy Public Verification Link'"></span>
                                </span>
                                <span class="text-[10px] font-mono text-slate-400" x-text="copiedUrl ? 'OK' : 'COPY'"></span>
                            </button>

                            <!-- Copy Member ID -->
                            <button type="button" @click="copyMemberId()"
                                    class="w-full py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 transition-colors flex items-center justify-between cursor-pointer border border-slate-200">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    <span x-text="copiedMemberId ? 'Member ID Copied!' : 'Copy Member ID (' + memberNumber + ')'"></span>
                                </span>
                                <span class="text-[10px] font-mono text-slate-500" x-text="copiedMemberId ? 'OK' : 'COPY'"></span>
                            </button>

                            <!-- High-Res Standalone Card View -->
                            <a href="{{ route('membership.card', $member->qr_code_token) }}" target="_blank"
                               class="w-full py-2.5 px-4 rounded-xl bg-slate-50 hover:bg-slate-100 text-slate-700 transition-colors flex items-center justify-between border border-slate-200">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    <span>Open Standalone High-Res Pass</span>
                                </span>
                                <span class="text-slate-400 text-[10px]">&nearr;</span>
                            </a>

                            <!-- Print ID Card Slip -->
                            <button type="button" @click="window.print()"
                                    class="w-full py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 transition-colors flex items-center justify-between cursor-pointer border border-slate-200">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    <span>Print ID Card Slip</span>
                                </span>
                                <span class="text-[10px] font-mono text-slate-500">PRINT</span>
                            </button>

                            <!-- Share on WhatsApp -->
                            @php
                                $whatsAppShareUrl = 'https://api.whatsapp.com/send?text=' . urlencode("Verify my official membership with Brands Academy Nigeria Foundation: " . route('verify.certificate', $member->qr_code_token));
                            @endphp
                            <a href="{{ $whatsAppShareUrl }}" target="_blank" rel="noopener noreferrer"
                               class="w-full py-2.5 px-4 rounded-xl bg-[#25D366] hover:bg-[#20ba59] text-white transition-colors flex items-center justify-between shadow-xs">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.303c-.086.086-.177.18-.076.353.101.173.45 743 965 1.202.664.591 1.224.774 1.397.86.173.086.274.072.375-.043.101-.116.433-.506.549-.68.116-.173.231-.144.39-.086s1.011.477 1.184.564.289.13.332.202c.043.072.043.419-.101.824z"/></svg>
                                    <span>Share ID via WhatsApp</span>
                                </span>
                                <span class="text-white text-[10px]">&rarr;</span>
                            </a>
                        </div>
                    </div>

                    <!-- Tamper-evident Security Registry Note -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-slate-600 text-[11px] space-y-1.5 leading-relaxed">
                        <div class="font-bold text-slate-900 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>Official Central Registry Notice</span>
                        </div>
                        <p>This digital membership card is registered under CAC/IT/No. 7344471. Scanning the dynamic QR code immediately queries the live registry to verify active membership standing.</p>
                    </div>
                </div>

            </div>
        </section>
    </div>

    <!-- ==================== TAB 6: MEMBER PROFILE & REGISTRY SETTINGS ==================== -->
    <div x-show="activeTab === 'profile'" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="space-y-6">

    <section id="profile" class="scroll-mt-24 space-y-5">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 font-serif-title">Member Profile &amp; Registry Information</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Keep your official membership directory details, jurisdictional record, and professional affiliations current.</p>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-8 shadow-sm space-y-6">

            <!-- Read-only Official Registry Summary Banner -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-slate-900 text-amber-400 font-extrabold text-sm flex items-center justify-center font-serif-title shrink-0">
                        {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                    </div>
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400">Registered Name &bull; {{ $member->category_label }}</span>
                        <span class="text-sm font-bold text-slate-900">{{ $member->full_name }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-4 text-xs font-mono">
                    <div>
                        <span class="block text-[9px] uppercase font-bold text-slate-400">Member ID</span>
                        <span class="font-extrabold text-amber-700">{{ $member->member_number }}</span>
                    </div>
                    <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>
                    <div>
                        <span class="block text-[9px] uppercase font-bold text-slate-400">Official Email</span>
                        <span class="text-slate-700 font-sans">{{ $member->email }}</span>
                    </div>
                </div>
            </div>

            <!-- Profile Edit Form -->
            <form action="{{ route('member.profile.update') }}#profile" method="POST" @submit="isSubmitting = true" class="space-y-5">
                @csrf

                <!-- Row 1: Phone Number & Country -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Phone Number with Nigerian & International Carrier Detection -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Phone Number *</label>
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
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Country *</label>
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

                <!-- Row 2: State of Residence & Organization -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- State of Residence (Dropdown for Nigeria, Interactive input for Neighbors/International) -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider" x-text="country === 'Nigeria' ? 'State of Residence *' : 'State / Province / Region *'"></label>
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

                    <!-- Organization / Institution -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Organization or Institution</label>
                        <input type="text" name="institution_or_company" value="{{ old('institution_or_company', $member->institution_or_company) }}" placeholder="e.g. Veritas Design Studio / Ahmadu Bello University" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                    </div>
                </div>

                <!-- Row 3: Designation / Professional Title -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Designation / Professional Title</label>
                    <input type="text" name="designation" value="{{ old('designation', $member->designation) }}" placeholder="e.g. Senior Brand Strategist / Marketing Fellow" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                </div>

                <!-- Row 4: Professional Bio -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Professional Bio / Institutional Focus</label>
                        <span class="text-[11px] text-slate-400 font-mono" x-text="`${1000 - bio.length} chars left`"></span>
                    </div>
                    <textarea name="bio" x-model="bio" maxlength="1000" rows="3" placeholder="Brief statement regarding your practice, expertise, and institutional focus..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 leading-relaxed"></textarea>
                </div>

                <div class="pt-2 flex items-center justify-between">
                    <p class="text-[11px] text-slate-400">
                        Changes update your official foundation registry file and verify certificates.
                    </p>
                    <button type="submit" :disabled="isSubmitting" class="px-6 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors flex items-center gap-2 shadow-xs disabled:opacity-70 cursor-pointer">
                        <svg x-show="isSubmitting" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span>Save Profile Changes</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Account Security & Password Card -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-8 shadow-sm space-y-5">
            <div>
                <h3 class="text-base font-bold text-slate-900 font-serif-title">Account Security &amp; Access</h3>
                <p class="text-xs text-slate-500 mt-0.5">Change your member portal account login password.</p>
            </div>

            <form action="{{ route('member.password.update') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Current Password *</label>
                        <input type="password" name="current_password" required autocomplete="current-password" placeholder="••••••••" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                        @error('current_password')
                            <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">New Password *</label>
                        <input type="password" name="password" required autocomplete="new-password" minlength="8" placeholder="At least 8 characters" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                        @error('password')
                            <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Confirm New Password *</label>
                        <input type="password" name="password_confirmation" required autocomplete="new-password" minlength="8" placeholder="Repeat new password" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                    </div>
                </div>

                <div class="pt-2 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <p class="text-[11px] text-slate-400">
                        Use at least 8 characters with a mix of letters, numbers, and symbols.
                    </p>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors flex items-center justify-center gap-2 shadow-xs cursor-pointer self-start sm:self-auto">
                        <span>Update Password</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
    </div>

    <!-- ==================== 5. DIGITAL CREDENTIAL MODAL ==================== -->
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
        <div class="flex min-h-full items-center justify-center p-3 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-slate-900 text-left shadow-2xl transition-all my-4 sm:my-8 w-full max-w-xl max-h-[92vh] overflow-y-auto border border-amber-500/30 p-4 sm:p-8"
                 x-show="showCardModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <!-- Close Button -->
                <button type="button" @click="showCardModal = false" class="absolute top-4 right-4 sm:top-5 sm:right-5 text-slate-400 hover:text-white transition-colors cursor-pointer p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <!-- Credential Header -->
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center p-1.5 shadow-md">
                        <img src="{{ asset('images/logo/bran-logo-128.png') }}" alt="Logo" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white font-serif-title">Foundation Digital Credential</h3>
                        <p class="text-xs text-amber-400">Brands Academy Nigeria Foundation &bull; CAC/IT/No. 7344471</p>
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
                    <button type="button" @click="copyMemberId()" class="py-2.5 px-4 rounded-xl font-bold bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 transition-colors flex items-center justify-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <span x-text="copiedMemberId ? 'Member ID Copied!' : 'Copy Member ID'"></span>
                    </button>

                    <!-- 1-Click Copy Verification URL -->
                    <button type="button" @click="copyVerificationUrl()" class="py-2.5 px-4 rounded-xl font-bold bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 transition-colors flex items-center justify-center gap-2 cursor-pointer">
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
        const validTabs = ['overview', 'cohorts', 'certificates', 'applications', 'digital-id', 'profile'];
        const getInitialTab = () => {
            const hash = (window.location.hash || '').replace('#', '').trim();
            if (validTabs.includes(hash)) return hash;
            const params = new URLSearchParams(window.location.search);
            const queryTab = params.get('tab');
            if (validTabs.includes(queryTab)) return queryTab;
            return config.initialTab || 'overview';
        };

        return {
            activeTab: getInitialTab(),
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
            cardSide: 'front',
            cohortSearch: '',
            cohortTrackFilter: 'all',
            appStatusFilter: 'all',
            copiedCertUrl: '',

            matchesCohortFilter(title, track) {
                const q = (this.cohortSearch || '').toLowerCase().trim();
                const matchesSearch = !q || (title || '').toLowerCase().includes(q) || (track || '').toLowerCase().includes(q);
                let matchesTrack = true;
                if (this.cohortTrackFilter !== 'all') {
                    matchesTrack = (track || '').toLowerCase().includes(this.cohortTrackFilter.toLowerCase());
                }
                return matchesSearch && matchesTrack;
            },

            matchesAppFilter(status) {
                if (this.appStatusFilter === 'all') return true;
                if (this.appStatusFilter === 'accepted') return status === 'accepted';
                if (this.appStatusFilter === 'pending') return status === 'pending';
                if (this.appStatusFilter === 'completed') return status === 'completed';
                return true;
            },

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

            navTo(tabName) {
                this.switchTab(tabName);
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
