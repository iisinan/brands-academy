@extends('layouts.app')

@section('title', 'Advancing Branding & Professional Education in Nigeria')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-slate-950 via-[#0a0f1d] to-slate-950 text-white overflow-hidden py-16 lg:py-24 border-b border-slate-800/80">
    <!-- Subtle Architectural Grid Background -->
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff05_1px,transparent_1px),linear-gradient(to_bottom,#ffffff05_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            
            <!-- Left Column: Editorial & Institutional Mission (7 Columns) -->
            <div class="lg:col-span-7">
                
                <!-- Official Accreditation Kicker -->
                <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-slate-900/90 text-amber-300 border border-amber-500/30 shadow-xs mb-6 backdrop-blur-sm">
                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-amber-500/20 text-amber-400 text-xs">🏛</span>
                    <span class="tracking-wide">Federal Republic of Nigeria &bull; Incorporated Trustees CAC / IT No. 7344471</span>
                </div>

                <!-- Primary Headline -->
                <h1 class="text-3xl sm:text-5xl lg:text-[3.25rem] font-extrabold tracking-tight text-white leading-[1.15] font-serif-title mb-6">
                    The National Standard for <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-200 via-amber-400 to-amber-200">Brand Governance, Strategy</span> & Professional Leadership.
                </h1>

                <!-- Body Narrative -->
                <p class="text-base sm:text-lg text-slate-300 leading-relaxed font-normal mb-8 max-w-2xl">
                    Brands Academy Nigeria Foundation is a chartered educational foundation bridging academic theory and executive industry practice. Governed by distinguished academics and marketing fellows, the academy provides continuous professional membership, scheduled certification cohorts, and the nation’s tamper-proof registry of verified credentials.
                </p>

                <!-- Board & Credibility Strip -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-8 pt-4 border-t border-slate-800/90">
                    <div class="flex items-start gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-white">Prof. Samaila Mande</div>
                            <div class="text-[11px] text-slate-400">Chairman of Trustees, fnimn</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-white">3 Chartered Tiers</div>
                            <div class="text-[11px] text-slate-400">CBA &bull; CBS &bull; CBE Pathway</div>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-white">Cryptographic QR</div>
                            <div class="text-[11px] text-slate-400">Instant Vector Verification</div>
                        </div>
                    </div>
                </div>

                <!-- Primary CTA Row -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-3.5 w-full">
                    <a href="{{ route('membership.register') }}" class="w-full sm:w-auto px-6 py-3.5 rounded-xl text-xs sm:text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md shadow-amber-500/20 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2 group">
                        <span>Join Foundation Membership</span>
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-extrabold bg-slate-950 text-amber-400">24/7/365</span>
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <a href="{{ route('workshops.index') }}" class="w-full sm:w-auto px-5 py-3.5 rounded-xl text-xs sm:text-sm font-bold bg-slate-900/90 hover:bg-slate-800 text-white border border-slate-700/80 transition-all flex items-center justify-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>View Training Cohorts ({{ $openWorkshops->count() }} Open)</span>
                    </a>
                    <a href="{{ route('verify.certificate') }}" class="inline-flex items-center justify-center gap-1.5 text-xs font-semibold text-slate-400 hover:text-amber-300 transition-colors py-2 px-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>Verify Credential</span>
                    </a>
                </div>

            </div>

            <!-- Right Column: Tangible Credential & Verification Specimen (5 Columns) -->
            <div class="lg:col-span-5">
                <div class="relative max-w-md mx-auto lg:max-w-none">
                    
                    <!-- Decorative subtle warm ambient back-glow -->
                    <div class="absolute -inset-1.5 bg-gradient-to-tr from-amber-500/20 via-amber-400/5 to-slate-800/40 rounded-3xl blur-xl opacity-70"></div>

                    <!-- Master Credential Showcase Container -->
                    <div class="relative bg-slate-900/95 rounded-2xl border border-amber-500/30 p-5 shadow-2xl backdrop-blur-md">
                        
                        <!-- Top Registry Status Bar -->
                        <div class="flex items-center justify-between pb-3.5 mb-4 border-b border-slate-800 text-[11px]">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span class="font-bold text-slate-200 uppercase tracking-wider text-[10px]">National Credential Registry</span>
                            </div>
                            <span class="text-amber-400 font-mono text-[10px] font-semibold bg-amber-500/10 px-2 py-0.5 rounded border border-amber-500/20">
                                Specimen &bull; BANF-CERT-2024-00108
                            </span>
                        </div>

                        <!-- Certificate Specimen Card -->
                        <div class="bg-gradient-to-b from-[#FAF8F5] to-[#F4EFE6] text-slate-900 rounded-xl p-5 border-2 border-amber-400/60 shadow-inner relative overflow-hidden">
                            <!-- Delicate Guilloche Corner Borders -->
                            <div class="absolute top-1 left-1 w-6 h-6 border-t-2 border-l-2 border-amber-700/40 pointer-events-none"></div>
                            <div class="absolute top-1 right-1 w-6 h-6 border-t-2 border-r-2 border-amber-700/40 pointer-events-none"></div>
                            <div class="absolute bottom-1 left-1 w-6 h-6 border-b-2 border-l-2 border-amber-700/40 pointer-events-none"></div>
                            <div class="absolute bottom-1 right-1 w-6 h-6 border-b-2 border-r-2 border-amber-700/40 pointer-events-none"></div>

                            <!-- Certificate Header -->
                            <div class="text-center mb-3">
                                <x-brand-logo class="w-10 h-10 mx-auto mb-1.5 drop-shadow-xs" />
                                <div class="font-serif-title font-extrabold text-[13px] tracking-tight text-slate-950 uppercase leading-none">
                                    Brands Academy Nigeria Foundation
                                </div>
                                <div class="text-[8.5px] font-bold text-amber-800 tracking-wider uppercase mt-0.5">
                                    Incorporated Trustees &bull; CAC IT No. 7344471
                                </div>
                                <div class="h-px w-24 bg-gradient-to-r from-transparent via-amber-600 to-transparent mx-auto mt-1.5"></div>
                            </div>

                            <!-- Certificate Conferment Statement -->
                            <div class="text-center my-3">
                                <div class="text-[9px] uppercase tracking-widest text-slate-500 font-semibold">
                                    Official Certificate of Professional Competence
                                </div>
                                <div class="text-[10px] italic text-slate-600 mt-0.5 font-serif-title">
                                    This is to certify that
                                </div>
                                <div class="font-serif-title font-extrabold text-base text-slate-950 tracking-tight my-0.5 border-b border-dashed border-slate-300 pb-0.5 inline-block px-3">
                                    Chidi Okafor
                                </div>
                                <div class="text-[10px] font-bold text-amber-900 mt-1">
                                    Certified Brand Associate (CBA) &bull; Distinction
                                </div>
                                <div class="text-[8.5px] text-slate-500">
                                    Having satisfied all syllabus defenses and capstone portfolio criteria
                                </div>
                            </div>

                            <!-- Dual Signature & Gold Seal Row -->
                            <div class="flex items-end justify-between pt-3 mt-2 border-t border-slate-200/90 text-[8.5px]">
                                <div class="text-center">
                                    <div class="font-serif-title italic text-slate-800 text-[10px] font-semibold -mb-0.5">Prof. Samaila Mande</div>
                                    <div class="w-20 h-px bg-slate-400 mx-auto my-0.5"></div>
                                    <div class="font-bold text-slate-600">Chairman, Trustees</div>
                                </div>

                                <!-- Embossed Gold Seal Emblem -->
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-300 via-amber-500 to-amber-700 p-0.5 shadow-md flex items-center justify-center shrink-0">
                                    <div class="w-full h-full rounded-full border border-amber-200/80 flex flex-col items-center justify-center text-slate-950 text-center leading-none">
                                        <span class="text-[6px] font-extrabold uppercase tracking-tighter">OFFICIAL</span>
                                        <span class="text-[8px] font-black">SEAL</span>
                                        <span class="text-[5.5px] font-bold">CAC 7344471</span>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <div class="font-serif-title italic text-slate-800 text-[10px] font-semibold -mb-0.5">Titus Eveshoyan</div>
                                    <div class="w-20 h-px bg-slate-400 mx-auto my-0.5"></div>
                                    <div class="font-bold text-slate-600">Secretary to Board</div>
                                </div>
                            </div>

                        </div>

                        <!-- Interactive In-Hero Verification Lookup Box -->
                        <div class="mt-4 pt-3.5 border-t border-slate-800">
                            <form action="{{ route('verify.certificate') }}" method="GET" class="space-y-2">
                                <label for="hero-token-input" class="block text-[11px] font-semibold text-slate-300 flex items-center justify-between">
                                    <span>Verify Any Issued Credential</span>
                                    <span class="text-[10px] text-amber-400 font-mono">1-Click Live Test</span>
                                </label>
                                <div class="flex gap-2">
                                    <input 
                                        type="text" 
                                        id="hero-token-input"
                                        name="q" 
                                        value="BANF-CERT-2024-00108"
                                        placeholder="Enter Certificate # or Token" 
                                        class="flex-1 bg-slate-950/80 text-white font-mono text-xs px-3 py-2 rounded-xl border border-slate-700 focus:outline-none focus:border-amber-400 placeholder-slate-500"
                                    >
                                    <button 
                                        type="submit" 
                                        class="px-3.5 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors whitespace-nowrap shadow-xs"
                                    >
                                        Verify Specimen
                                    </button>
                                </div>
                            </form>
                            <div class="flex items-center justify-between text-[10px] text-slate-400 mt-2">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Publicly Auditable
                                </span>
                                <span>Secured under CAMA 2004 Charter</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Institutional Governance & Metrics Strip -->
<section class="bg-slate-950 border-b border-slate-800 text-slate-300 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center md:text-left">
            <div class="border-l-2 border-amber-500/50 pl-3">
                <div class="text-xs uppercase font-extrabold tracking-wider text-amber-400">CAC IT No. 7344471</div>
                <div class="text-[11px] text-slate-400 mt-0.5">Federal Incorporated Trustees</div>
            </div>
            <div class="border-l-2 border-amber-500/50 pl-3">
                <div class="text-xs uppercase font-extrabold tracking-wider text-amber-400">Postgraduate Dean Chair</div>
                <div class="text-[11px] text-slate-400 mt-0.5">Academic Board Oversight</div>
            </div>
            <div class="border-l-2 border-amber-500/50 pl-3">
                <div class="text-xs uppercase font-extrabold tracking-wider text-amber-400">3 Certified Pathways</div>
                <div class="text-[11px] text-slate-400 mt-0.5">CBA &bull; CBS &bull; CBE Accreditations</div>
            </div>
            <div class="border-l-2 border-amber-500/50 pl-3">
                <div class="text-xs uppercase font-extrabold tracking-wider text-amber-400">Cryptographic Ledger</div>
                <div class="text-[11px] text-slate-400 mt-0.5">Tamper-Proof Verification Registry</div>
            </div>
        </div>
    </div>
</section>

<!-- The Two Pillars Architecture Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="text-center max-w-2xl mx-auto mb-10">
        <div class="text-xs font-extrabold uppercase tracking-widest text-amber-600 mb-1">Institutional Operating Framework</div>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-950 font-serif-title">
            The Two Foundation Pillars
        </h2>
        <p class="text-sm text-slate-600 mt-2">
            Structured in strict accordance with the Foundation’s charter to provide continuous membership while maintaining rigorous, time-bound certification cohorts.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        
        <!-- Pillar 1: Ongoing Membership -->
        <div class="bg-white rounded-2xl p-7 sm:p-8 shadow-sm border border-slate-200 relative overflow-hidden group hover:border-amber-400 hover:shadow-md transition-all">
            <div class="flex items-center justify-between mb-5">
                <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 flex items-center justify-center font-serif-title font-bold text-lg">
                    01
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-900 border border-amber-200">
                    <span class="w-2 h-2 rounded-full bg-amber-600"></span>
                    Continuous &bull; Always Open (24/7)
                </span>
            </div>
            <h3 class="text-xl font-bold text-slate-950 mb-2">Evergreen Professional Membership</h3>
            <p class="text-slate-600 text-sm leading-relaxed mb-6">
                Open 365 days a year for students, practitioners, educators, and institutions. Registration generates your official <strong class="text-slate-900">BANF-MBR-YYYY-XXXX</strong> credential, digital ID card with cryptographic QR code, and access to the national practitioner registry.
            </p>
            <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                <span class="text-xs font-semibold text-slate-500">Student &bull; Professional &bull; Fellow</span>
                <a href="{{ route('membership.register') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-700 hover:text-amber-800 group-hover:translate-x-1 transition-all">
                    Register for Membership &rarr;
                </a>
            </div>
        </div>

        <!-- Pillar 2: Scheduled Cohorts & Application Windows -->
        <div class="bg-white rounded-2xl p-7 sm:p-8 shadow-sm border border-slate-200 relative overflow-hidden group hover:border-blue-400 hover:shadow-md transition-all">
            <div class="flex items-center justify-between mb-5">
                <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 flex items-center justify-center font-serif-title font-bold text-lg">
                    02
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-900 border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                    Scheduled Application Windows
                </span>
            </div>
            <h3 class="text-xl font-bold text-slate-950 mb-2">Masterclasses & Certification Cohorts</h3>
            <p class="text-slate-600 text-sm leading-relaxed mb-6">
                Structured certification programmes that open exclusively during designated application windows. Enrolled candidates undergo rigorous syllabus defense and capstone portfolio evaluation, concluding with automated vector certificate issuance.
            </p>
            <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                <span class="text-xs font-semibold text-slate-500">Includes Tuition-Free Community Tracks</span>
                <a href="{{ route('workshops.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-700 hover:text-blue-800 group-hover:translate-x-1 transition-all">
                    Explore Active Cohorts &rarr;
                </a>
            </div>
        </div>

    </div>
</section>

<!-- Live Cohorts Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
        <div>
            <div class="text-xs font-bold uppercase tracking-wider text-amber-600 mb-1">Application Periods</div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-950 font-serif-title">
                Active Training Programmes & Cohorts
            </h2>
        </div>
        <a href="{{ route('workshops.index') }}" class="text-sm font-bold text-slate-700 hover:text-amber-600 flex items-center gap-1 transition-colors">
            View All Cohorts &rarr;
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($allWorkshops as $workshop)
            @php
                $window = $workshop->application_window_status;
                $userApp = null;
                if (auth()->check()) {
                    $userApp = \App\Models\WorkshopApplication::where('workshop_id', $workshop->id)
                        ->where(function ($q) {
                            $q->where('user_id', auth()->id())
                                ->orWhere('applicant_email', auth()->user()->email);
                            if (auth()->user()->member) {
                                $q->orWhere('member_id', auth()->user()->member->id);
                            }
                        })->first();
                }
            @endphp
            <div class="bg-white rounded-2xl border {{ $userApp ? 'border-emerald-300 ring-1 ring-emerald-500/20' : 'border-slate-200' }} p-6 flex flex-col justify-between shadow-xs hover:shadow-md transition-shadow">
                <div>
                    <!-- Status & Track Badges -->
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <div class="flex items-center gap-1.5 flex-wrap">
                            @if($userApp)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold {{ $userApp->status === 'accepted' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-blue-100 text-blue-800 border border-blue-300' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $userApp->status === 'accepted' ? 'bg-emerald-500' : 'bg-blue-500 animate-pulse' }}"></span>
                                    {{ $userApp->status === 'accepted' ? 'Enrolled' : 'Applied' }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $window['badge_class'] }}">
                                    {{ $window['label'] }}
                                </span>
                            @endif
                            @if($workshop->is_featured)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-300">
                                    <span>&#11088; Featured</span>
                                </span>
                            @endif
                        </div>
                        <span class="text-xs font-semibold text-slate-500">
                            {{ $workshop->delivery_mode == 'hybrid' ? 'Hybrid' : ($workshop->delivery_mode == 'online' ? 'Online' : 'In Person') }}
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-slate-900 mb-2 leading-snug">
                        <a href="{{ route('workshops.show', $workshop->slug) }}" class="hover:text-amber-600 transition-colors">
                            {{ $workshop->title }}
                        </a>
                    </h3>

                    <p class="text-xs text-amber-700 font-semibold mb-3">
                        {{ $workshop->track_label }}
                    </p>

                    <p class="text-slate-600 text-sm line-clamp-3 mb-6">
                        {{ $workshop->tagline ?? $workshop->description }}
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <div class="flex justify-between items-center text-xs text-slate-500 mb-4">
                        <div>
                            <span class="block text-[10px] uppercase font-bold text-slate-400">Application Window</span>
                            <span class="font-semibold text-slate-700">{{ $window['detail'] }}</span>
                        </div>
                        <div class="text-right">
                            <span class="block text-[10px] uppercase font-bold text-slate-400">Fee</span>
                            <span class="font-bold {{ $workshop->fee_type == 'free' ? 'text-emerald-700' : 'text-slate-900' }}">
                                {{ $workshop->fee_type == 'free' ? '100% Free Track' : 'NGN ' . number_format($workshop->fee_amount) }}
                            </span>
                        </div>
                    </div>

                    @if($userApp)
                        <a href="{{ route('workshops.show', $workshop->slug) }}" class="w-full inline-flex justify-center items-center gap-1.5 py-2.5 px-4 rounded-xl text-xs font-bold {{ $userApp->status === 'accepted' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-blue-100 text-blue-800 border border-blue-300' }} transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>{{ $userApp->status === 'accepted' ? 'Enrolled • View Cohort' : 'Already Applied • View Status' }}</span>
                        </a>
                    @else
                        <a href="{{ route('workshops.show', $workshop->slug) }}" class="w-full inline-flex justify-center items-center py-2.5 px-4 rounded-xl text-xs font-bold {{ $window['state'] == 'open' ? 'bg-amber-500 hover:bg-amber-400 text-slate-950' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }} transition-colors">
                            {{ $window['state'] == 'open' ? 'Apply for this Cohort' : 'View Syllabus & Status' }}
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 bg-white rounded-2xl border border-dashed border-slate-300">
                <p class="text-slate-500 text-sm">No cohorts announced at this moment. Stay tuned!</p>
            </div>
        @endforelse
    </div>
</section>

<!-- Integrated Foundation Ecosystem Section -->
<section class="bg-slate-950 text-white py-20 border-t border-slate-800 relative overflow-hidden">
    <div class="absolute inset-0 bg-radial-gradient from-amber-500/10 via-transparent to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/15 text-amber-300 border border-amber-500/30 mb-3">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                Integrated Academic &amp; Enterprise Infrastructure
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold font-serif-title text-white tracking-tight">
                A Unified Digital Campus for Brand Science
            </h2>
            <p class="mt-3 text-slate-300 text-sm sm:text-base leading-relaxed">
                Beyond scheduled cohort intakes, Brands Academy provides self-paced virtual learning, live masterclasses, legal IP filing operations, annual academic summits, and empirical journal publications.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- 1. LMS Short Courses -->
            <div class="bg-slate-900/90 rounded-2xl p-6 sm:p-7 border border-slate-800 hover:border-amber-400/60 transition-all group flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-400 flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-blue-400">Self-Paced LMS</span>
                    <h3 class="text-lg font-bold text-white mt-1 mb-2">Short Courses &amp; Quizzes</h3>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed mb-6">
                        Study modular brand curriculum at your own speed with automated grading, 1-on-1 mentor office hours, and instant verifiable certificates.
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-800/80 flex items-center justify-between">
                    <span class="text-[11px] text-slate-500">Video &amp; Assessments</span>
                    <a href="{{ route('courses.index') }}" class="text-xs font-bold text-amber-400 hover:text-amber-300 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Explore Courses &rarr;
                    </a>
                </div>
            </div>

            <!-- 2. Virtual Webinars -->
            <div class="bg-slate-900/90 rounded-2xl p-6 sm:p-7 border border-slate-800 hover:border-amber-400/60 transition-all group flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/20 text-purple-400 flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-purple-400">Live Masterclasses</span>
                    <h3 class="text-lg font-bold text-white mt-1 mb-2">Webinars &amp; Live Video</h3>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed mb-6">
                        Join interactive live sessions with visiting fellows and industry leaders using integrated Google Meet and Zoom conferencing with automated calendar sync.
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-800/80 flex items-center justify-between">
                    <span class="text-[11px] text-slate-500">1-Click RSVP &amp; .ICS</span>
                    <a href="{{ route('webinars.index') }}" class="text-xs font-bold text-amber-400 hover:text-amber-300 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Upcoming Sessions &rarr;
                    </a>
                </div>
            </div>

            <!-- 3. Legal Desk (CAC & IP) -->
            <div class="bg-slate-900/90 rounded-2xl p-6 sm:p-7 border border-slate-800 hover:border-amber-400/60 transition-all group flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-400">Legal Protection</span>
                    <h3 class="text-lg font-bold text-white mt-1 mb-2">CAC, Trademark &amp; IP Desk</h3>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed mb-6">
                        Seamlessly register your business name with CAC, file multi-class trademark protections, and safeguard proprietary brand intellectual property.
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-800/80 flex items-center justify-between">
                    <span class="text-[11px] text-emerald-400">25% Member Discount</span>
                    <a href="{{ route('services.index') }}" class="text-xs font-bold text-amber-400 hover:text-amber-300 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        File Services &rarr;
                    </a>
                </div>
            </div>

            <!-- 4. Conferences & Summits -->
            <div class="bg-slate-900/90 rounded-2xl p-6 sm:p-7 border border-slate-800 hover:border-amber-400/60 transition-all group flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-amber-400">Flagship Events</span>
                    <h3 class="text-lg font-bold text-white mt-1 mb-2">Brand Summits &amp; Conferences</h3>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed mb-6">
                        Nigeria's premier annual brand leadership summit. Secure tiered passes, download cryptographic digital delegate badges, and submit papers.
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-800/80 flex items-center justify-between">
                    <span class="text-[11px] text-slate-500">Call for Papers (CFP)</span>
                    <a href="{{ route('conferences.index') }}" class="text-xs font-bold text-amber-400 hover:text-amber-300 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        View Summits &rarr;
                    </a>
                </div>
            </div>

            <!-- 5. Academic Journal (JBSM) -->
            <div class="bg-slate-900/90 rounded-2xl p-6 sm:p-7 border border-slate-800 hover:border-amber-400/60 transition-all group flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-rose-400">Peer-Reviewed Research</span>
                    <h3 class="text-lg font-bold text-white mt-1 mb-2">JBSM Academic Journal</h3>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed mb-6">
                        Journal of Brand Science &amp; Management. Open-access empirical research, digital DOI archives, and instant APA 7th / Harvard / BibTeX citations.
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-800/80 flex items-center justify-between">
                    <span class="text-[11px] text-slate-500">ISSN &bull; Peer-Reviewed</span>
                    <a href="{{ route('journal.index') }}" class="text-xs font-bold text-amber-400 hover:text-amber-300 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Read Articles &rarr;
                    </a>
                </div>
            </div>

            <!-- 6. Community Chatboard -->
            <div class="bg-slate-900/90 rounded-2xl p-6 sm:p-7 border border-slate-800 hover:border-amber-400/60 transition-all group flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-400">Peer Exchange</span>
                    <h3 class="text-lg font-bold text-white mt-1 mb-2">Community Discussion Board</h3>
                    <p class="text-xs sm:text-sm text-slate-400 leading-relaxed mb-6">
                        Engage in rigorous practitioner debates, pose regulatory questions, exchange case studies, and mark accepted solutions with fellow brand fellows.
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-800/80 flex items-center justify-between">
                    <span class="text-[11px] text-slate-500">Member Advisory Circles</span>
                    <a href="{{ route('forum.index') }}" class="text-xs font-bold text-amber-400 hover:text-amber-300 flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                        Join Discussion &rarr;
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- The 3-Tier Certification Framework -->
<section class="bg-slate-100 py-20 border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <div class="text-xs font-bold uppercase tracking-wider text-amber-600 mb-1">Recognized Competencies</div>
            <h2 class="text-3xl font-extrabold text-slate-950 font-serif-title mb-4">
                The 3-Tier Certification Pathway
            </h2>
            <p class="text-sm text-slate-600">
                Progress from foundational brand literacy to applied campaign strategy and executive leadership. Every tier delivers verifiable digital credentials.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Tier 1 -->
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-xs relative">
                <div class="w-10 h-10 rounded-full bg-slate-900 text-amber-400 font-bold flex items-center justify-center text-sm mb-4">1</div>
                <div class="text-xs font-bold text-amber-600 uppercase tracking-wide">Foundation Track</div>
                <h3 class="text-xl font-extrabold text-slate-900 mt-1 mb-2">Certified Brand Associate (CBA)</h3>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">
                    Designed for early-career professionals, undergraduates, and designers mastering brand architecture, terminology, positioning, and portfolio design.
                </p>
                <div class="text-xs font-semibold text-slate-500 bg-slate-50 p-3 rounded-lg border border-slate-100">
                    Portfolio assessment & guided mentorship included.
                </div>
            </div>

            <!-- Tier 2 -->
            <div class="bg-white rounded-2xl p-8 border-2 border-amber-500 shadow-md relative">
                <div class="absolute -top-3.5 right-6 bg-amber-500 text-slate-950 text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider">Most Popular</div>
                <div class="w-10 h-10 rounded-full bg-amber-500 text-slate-950 font-bold flex items-center justify-center text-sm mb-4">2</div>
                <div class="text-xs font-bold text-amber-600 uppercase tracking-wide">Practitioner Track</div>
                <h3 class="text-xl font-extrabold text-slate-900 mt-1 mb-2">Certified Brand Strategist (CBS)</h3>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">
                    For practicing marketers, brand managers, and communications specialists executing multi-channel brand campaigns and strategic audits.
                </p>
                <div class="text-xs font-semibold text-slate-500 bg-slate-50 p-3 rounded-lg border border-slate-100">
                    Live client brief defense & case analysis.
                </div>
            </div>

            <!-- Tier 3 -->
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-xs relative">
                <div class="w-10 h-10 rounded-full bg-slate-900 text-amber-400 font-bold flex items-center justify-center text-sm mb-4">3</div>
                <div class="text-xs font-bold text-amber-600 uppercase tracking-wide">Executive Track</div>
                <h3 class="text-xl font-extrabold text-slate-900 mt-1 mb-2">Certified Brand Executive (CBE)</h3>
                <p class="text-slate-600 text-sm leading-relaxed mb-6">
                    For business leaders, directors, and public-sector administrators managing organizational reputation, crisis communications, and brand equity.
                </p>
                <div class="text-xs font-semibold text-slate-500 bg-slate-50 p-3 rounded-lg border border-slate-100">
                    Executive retreat & strategic advisory modules.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Institutional Accreditation & Licensing Banner -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-slate-950 rounded-3xl p-8 sm:p-12 text-white border border-slate-800 shadow-xl relative overflow-hidden">
        <!-- Subtle Gold Accent Glow -->
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative max-w-3xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-500/15 text-amber-300 border border-amber-500/30 mb-4">
                Corporate Governance & Higher Education
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold font-serif-title mb-4">
                License the Foundation Curriculum or Commission an Executive Retreat
            </h2>
            <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-8">
                From federal ministries to top African universities, Brands Academy Nigeria Foundation licenses accredited brand management syllabi, certifies communications teams, and establishes institutional branding chairs.
            </p>

            <div class="flex flex-wrap items-center gap-4">
                <a href="{{ route('partnerships') }}" class="px-6 py-3.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold rounded-xl text-xs sm:text-sm transition-all shadow-md shadow-amber-500/20 flex items-center gap-2">
                    <span>Submit Institutional Inquiry</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
                <a href="{{ route('faculty') }}" class="px-5 py-3.5 bg-slate-800 hover:bg-slate-700 text-white font-semibold rounded-xl text-xs sm:text-sm border border-slate-700 transition-colors">
                    Meet the Trustees & Faculty
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
