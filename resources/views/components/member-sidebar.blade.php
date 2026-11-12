@props([
    'member' => null,
    'openWorkshops' => null,
    'certificates' => null,
    'applications' => null
])

@php
    $member = $member ?? auth()->user()?->member;
    if (!$member && auth()->check()) {
        $member = auth()->user()->member;
    }
    $openWorkshops = $openWorkshops ?? \App\Models\Workshop::where('status', 'published')->where('application_starts_at', '<=', now())->where('application_deadline', '>=', now())->get();
    $certificates = $certificates ?? ($member ? $member->certificates()->get() : collect());
    $applications = $applications ?? ($member ? $member->applications()->get() : collect());
    $isOnDashboard = request()->routeIs('member.dashboard');
@endphp

@if($member)
<div class="space-y-5" x-data="{
    localCopiedId: false,
    localCopiedUrl: false,
    copyMemberIdLocal() {
        if (navigator.clipboard) {
            navigator.clipboard.writeText('{{ $member->member_number }}');
            this.localCopiedId = true;
            setTimeout(() => this.localCopiedId = false, 2500);
        }
    },
    copyUrlLocal() {
        if (navigator.clipboard) {
            navigator.clipboard.writeText('{{ route('verify.certificate', $member->qr_code_token) }}');
            this.localCopiedUrl = true;
            setTimeout(() => this.localCopiedUrl = false, 2500);
        }
    }
}">

    <!-- Member Identity Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-xs relative overflow-hidden">
        <!-- Ambient Subtle Accent Glow -->
        <div class="absolute -right-8 -top-8 w-28 h-28 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="flex items-center gap-3.5 mb-4 relative z-10">
            <!-- Member Initials Avatar -->
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 via-amber-500 to-amber-600 text-slate-950 font-extrabold text-xl flex items-center justify-center shadow-md font-serif-title ring-2 ring-amber-500/30 shrink-0">
                {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
            </div>

            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-1.5 mb-1">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/15 text-amber-800 border border-amber-500/25 truncate">
                        {{ $member->category_label }}
                    </span>
                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Active
                    </span>
                </div>
                <h3 class="text-sm font-extrabold text-slate-900 truncate font-serif-title leading-snug">
                    {{ $member->full_name }}
                </h3>
                <p class="text-[11px] text-slate-500 truncate">
                    {{ $member->designation ?? 'Foundation Member' }}
                </p>
            </div>
        </div>

        <!-- Official Member ID Pill with 1-Click Copy -->
        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200/70 flex items-center justify-between gap-2">
            <div class="min-w-0">
                <span class="block text-[9px] uppercase font-bold text-slate-400 tracking-wider">Member ID</span>
                <span class="text-xs font-extrabold font-mono text-amber-700 block truncate">{{ $member->member_number }}</span>
            </div>
            <button type="button" @click="typeof copyMemberId === 'function' ? copyMemberId() : copyMemberIdLocal()" class="px-2 py-1 rounded-lg text-[10px] font-bold bg-white hover:bg-amber-50 text-slate-700 hover:text-amber-700 border border-slate-200 hover:border-amber-300 transition-colors flex items-center gap-1 shrink-0 shadow-2xs cursor-pointer" title="Copy Member ID">
                <svg x-show="!(typeof copiedMemberId !== 'undefined' ? copiedMemberId : localCopiedId)" class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                <svg x-show="typeof copiedMemberId !== 'undefined' ? copiedMemberId : localCopiedId" x-cloak class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span x-text="(typeof copiedMemberId !== 'undefined' ? copiedMemberId : localCopiedId) ? 'Copied!' : 'Copy'"></span>
            </button>
        </div>

        <!-- Key Details Strip -->
        <div class="mt-3 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
            <span>Jurisdiction:</span>
            <span class="font-semibold text-slate-700 truncate max-w-[150px] text-right">{{ $member->state }}, {{ $member->country ?? 'Nigeria' }}</span>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="bg-white rounded-2xl border border-slate-200/80 p-2.5 shadow-xs space-y-1">
        <div class="px-3 py-1.5 text-[10px] uppercase font-bold text-slate-400 tracking-wider">
            Portal Navigation
        </div>

        <!-- Overview -->
        @if($isOnDashboard)
            <button type="button" @click="scrollTo('overview')"
                    :class="activeSection === 'overview' ? 'bg-amber-500/10 text-amber-900 font-bold border-amber-500/30' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900 border-transparent'"
                    class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs transition-all border text-left cursor-pointer group">
                <span class="flex items-center gap-2.5">
                    <span :class="activeSection === 'overview' ? 'text-amber-600' : 'text-slate-400 group-hover:text-slate-600'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    </span>
                    <span>Dashboard Overview</span>
                </span>
                <span class="text-[10px] text-slate-400 font-mono">&rarr;</span>
            </button>
        @else
            <a href="{{ route('member.dashboard') }}#overview"
               class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs transition-all border border-transparent text-slate-700 hover:bg-slate-50 hover:text-slate-900 text-left group">
                <span class="flex items-center gap-2.5">
                    <span class="text-slate-400 group-hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    </span>
                    <span>Dashboard Overview</span>
                </span>
                <span class="text-[10px] text-slate-400 font-mono">&rarr;</span>
            </a>
        @endif

        <!-- Cohorts Open for Applications -->
        @if($isOnDashboard)
            <button type="button" @click="scrollTo('cohorts')"
                    :class="activeSection === 'cohorts' ? 'bg-amber-500/10 text-amber-900 font-bold border-amber-500/30' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900 border-transparent'"
                    class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs transition-all border text-left cursor-pointer group">
                <span class="flex items-center gap-2.5">
                    <span :class="activeSection === 'cohorts' ? 'text-amber-600' : 'text-slate-400 group-hover:text-slate-600'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </span>
                    <span>Workshop Cohorts</span>
                </span>
                <span class="flex items-center gap-1.5">
                    @if($openWorkshops->count() > 0)
                        <span class="px-1.5 py-0.2 rounded-full text-[9px] font-extrabold bg-amber-500 text-slate-950 font-mono">
                            {{ $openWorkshops->count() }} Open
                        </span>
                    @endif
                    <span class="px-1.5 py-0.2 rounded text-[9px] font-bold bg-emerald-100 text-emerald-800">
                        25% Off
                    </span>
                </span>
            </button>
        @else
            <a href="{{ route('member.dashboard') }}#cohorts"
               class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs transition-all border border-transparent text-slate-700 hover:bg-slate-50 hover:text-slate-900 text-left group">
                <span class="flex items-center gap-2.5">
                    <span class="text-slate-400 group-hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </span>
                    <span>Workshop Cohorts</span>
                </span>
                <span class="flex items-center gap-1.5">
                    @if($openWorkshops->count() > 0)
                        <span class="px-1.5 py-0.2 rounded-full text-[9px] font-extrabold bg-amber-500 text-slate-950 font-mono">
                            {{ $openWorkshops->count() }} Open
                        </span>
                    @endif
                    <span class="px-1.5 py-0.2 rounded text-[9px] font-bold bg-emerald-100 text-emerald-800">
                        25% Off
                    </span>
                </span>
            </a>
        @endif

        <!-- Earned Certificates -->
        @if($isOnDashboard)
            <button type="button" @click="scrollTo('certificates')"
                    :class="activeSection === 'certificates' ? 'bg-amber-500/10 text-amber-900 font-bold border-amber-500/30' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900 border-transparent'"
                    class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs transition-all border text-left cursor-pointer group">
                <span class="flex items-center gap-2.5">
                    <span :class="activeSection === 'certificates' ? 'text-amber-600' : 'text-slate-400 group-hover:text-slate-600'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </span>
                    <span>My Certificates</span>
                </span>
                @if($certificates->count() > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 font-mono">
                        {{ $certificates->count() }} Issued
                    </span>
                @else
                    <span class="text-[10px] text-slate-400">0</span>
                @endif
            </button>
        @else
            <a href="{{ route('member.dashboard') }}#certificates"
               class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs transition-all border border-transparent text-slate-700 hover:bg-slate-50 hover:text-slate-900 text-left group">
                <span class="flex items-center gap-2.5">
                    <span class="text-slate-400 group-hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </span>
                    <span>My Certificates</span>
                </span>
                @if($certificates->count() > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 font-mono">
                        {{ $certificates->count() }} Issued
                    </span>
                @else
                    <span class="text-[10px] text-slate-400">0</span>
                @endif
            </a>
        @endif

        <!-- Application History -->
        @if($isOnDashboard)
            <button type="button" @click="scrollTo('applications')"
                    :class="activeSection === 'applications' ? 'bg-amber-500/10 text-amber-900 font-bold border-amber-500/30' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900 border-transparent'"
                    class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs transition-all border text-left cursor-pointer group">
                <span class="flex items-center gap-2.5">
                    <span :class="activeSection === 'applications' ? 'text-amber-600' : 'text-slate-400 group-hover:text-slate-600'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    </span>
                    <span>Application History</span>
                </span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 font-mono">
                    {{ $applications->count() }}
                </span>
            </button>
        @else
            <a href="{{ route('member.dashboard') }}#applications"
               class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs transition-all border border-transparent text-slate-700 hover:bg-slate-50 hover:text-slate-900 text-left group">
                <span class="flex items-center gap-2.5">
                    <span class="text-slate-400 group-hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    </span>
                    <span>Application History</span>
                </span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 font-mono">
                    {{ $applications->count() }}
                </span>
            </a>
        @endif

        <!-- Digital ID Card (Triggers Quick View Modal) -->
        <a href="{{ route('membership.card', $member->qr_code_token) }}" target="_blank"
           class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs text-slate-700 hover:bg-amber-50 hover:text-amber-900 transition-all border border-transparent hover:border-amber-200 text-left group">
            <span class="flex items-center gap-2.5">
                <span class="text-amber-500 group-hover:text-amber-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </span>
                <span>Digital Member ID</span>
            </span>
            <span class="px-1.5 py-0.2 rounded text-[9px] font-bold bg-amber-500/20 text-amber-800">
                Live QR
            </span>
        </a>

        <!-- Profile Settings -->
        @if($isOnDashboard)
            <button type="button" @click="scrollTo('profile')"
                    :class="activeSection === 'profile' ? 'bg-amber-500/10 text-amber-900 font-bold border-amber-500/30' : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900 border-transparent'"
                    class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs transition-all border text-left cursor-pointer group">
                <span class="flex items-center gap-2.5">
                    <span :class="activeSection === 'profile' ? 'text-amber-600' : 'text-slate-400 group-hover:text-slate-600'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </span>
                    <span>Profile &amp; Settings</span>
                </span>
                <span class="text-[10px] text-slate-400 font-mono">&rarr;</span>
            </button>
        @else
            <a href="{{ route('member.dashboard') }}#profile"
               class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-xs transition-all border border-transparent text-slate-700 hover:bg-slate-50 hover:text-slate-900 text-left group">
                <span class="flex items-center gap-2.5">
                    <span class="text-slate-400 group-hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </span>
                    <span>Profile &amp; Settings</span>
                </span>
                <span class="text-[10px] text-slate-400 font-mono">&rarr;</span>
            </a>
        @endif
    </nav>

    <!-- 25% Member Benefit Callout Card -->
    <div class="p-4 rounded-2xl bg-gradient-to-br from-amber-500/10 via-amber-500/5 to-transparent border border-amber-500/30 text-slate-900">
        <div class="flex items-start gap-2.5 mb-2">
            <span class="w-6 h-6 rounded-lg bg-amber-500 text-slate-950 flex items-center justify-center font-extrabold text-xs shrink-0 shadow-2xs">
                %
            </span>
            <div>
                <h4 class="text-xs font-bold text-slate-900 leading-tight">25% Member Tuition Discount</h4>
                <p class="text-[11px] text-slate-600 mt-0.5 leading-relaxed">
                    Automatically applied on all Brands Academy cohorts when you apply while logged in.
                </p>
            </div>
        </div>
        <a href="{{ route('workshops.index') }}" class="mt-2.5 w-full py-2 px-3 rounded-xl text-[11px] font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors flex items-center justify-center gap-1 shadow-2xs">
            <span>Browse All Cohorts</span>
            <span>&rarr;</span>
        </a>
    </div>

    <!-- Quick Credential Actions -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-xs space-y-2.5">
        <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">
            Credential Tools
        </div>

        <!-- Download Certificate PDF -->
        <a href="{{ route('membership.certificate.download', $member->qr_code_token) }}"
           class="w-full py-2.5 px-3 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white transition-colors flex items-center justify-between shadow-2xs group">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Certificate PDF</span>
            </span>
            <span class="text-[10px] text-slate-400 group-hover:text-amber-400">&darr;</span>
        </a>

        <!-- Open High-Res Digital Card -->
        <a href="{{ route('membership.card', $member->qr_code_token) }}" target="_blank"
           class="w-full py-2.5 px-3 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-800 transition-colors flex items-center justify-between">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>Open Digital Card</span>
            </span>
            <span class="text-[10px] text-slate-400">&nearr;</span>
        </a>

        <!-- Copy Verification Link -->
        <button type="button" @click="copyVerificationUrl()"
                class="w-full py-2.5 px-3 rounded-xl text-xs font-bold border border-slate-200 hover:bg-slate-50 text-slate-700 transition-colors flex items-center justify-between cursor-pointer">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                <span x-text="copiedUrl ? 'Link Copied!' : 'Copy Verification Link'"></span>
            </span>
            <span class="text-[10px] text-slate-400">URL</span>
        </button>

        <!-- Share on WhatsApp -->
        @php
            $whatsAppShareUrl = 'https://api.whatsapp.com/send?text=' . urlencode("Verify my official membership with Brands Academy Nigeria Foundation: " . route('verify.certificate', $member->qr_code_token));
        @endphp
        <a href="{{ $whatsAppShareUrl }}" target="_blank" rel="noopener noreferrer"
           class="w-full py-2.5 px-3 rounded-xl text-xs font-bold bg-[#25D366]/10 hover:bg-[#25D366]/20 text-[#1da851] border border-[#25D366]/30 transition-colors flex items-center justify-between">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.303c-.086.086-.177.18-.076.353.101.173.45 743 965 1.202.664.591 1.224.774 1.397.86.173.086.274.072.375-.043.101-.116.433-.506.549-.68.116-.173.231-.144.39-.086s1.011.477 1.184.564.289.13.332.202c.043.072.043.419-.101.824z"/></svg>
                <span>Share on WhatsApp</span>
            </span>
            <span class="text-[10px] text-[#1da851]">&nearr;</span>
        </a>
    </div>

    <!-- Admin Control Panel Link (Conditional for Administrators) -->
    @if(auth()->user()?->isAdmin())
        <div class="p-3.5 rounded-2xl bg-slate-900 border border-slate-800 text-white shadow-xs">
            <span class="block text-[10px] uppercase font-bold text-amber-400 tracking-wider mb-1">Administrative Privileges</span>
            <a href="{{ route('admin.dashboard') }}" class="w-full py-2 px-3 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors flex items-center justify-center gap-1.5 shadow-xs">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Admin Operations Panel</span>
            </a>
        </div>
    @endif

    <!-- Footer: Support & Sign Out -->
    <div class="px-3 pt-2 text-[11px] text-slate-400 space-y-2">
        <div class="flex items-center justify-between text-slate-500">
            <span>Incorporated Trustee</span>
            <span class="font-bold text-slate-700">CAC/IT/No. 7344471</span>
        </div>
        <div class="flex items-center justify-between text-slate-500">
            <span>Support</span>
            <a href="mailto:thebrandsacademy@gmail.com" class="hover:text-amber-600 transition-colors">thebrandsacademy@gmail.com</a>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="pt-2">
            @csrf
            <button type="submit" class="w-full py-2 px-3 rounded-xl text-xs font-bold text-slate-600 hover:text-rose-600 hover:bg-rose-50 border border-slate-200 transition-colors flex items-center justify-center gap-1.5 cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Sign Out</span>
            </button>
        </form>
    </div>

</div>
@endif
