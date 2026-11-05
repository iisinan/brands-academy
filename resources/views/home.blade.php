@extends('layouts.app')

@section('title', 'Advancing Branding & Professional Education in Nigeria')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 text-white overflow-hidden py-20 lg:py-28 border-b border-slate-800">
    <!-- Subtle Background Elements -->
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#f59e0b_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="absolute -top-32 -right-32 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/30 mb-6">
                <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                Federal Republic of Nigeria &bull; CAC IT No. 7344471
            </div>

            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-tight font-serif-title mb-6">
                Advancing branding, marketing & professional education.
            </h1>

            <p class="text-lg sm:text-xl text-slate-300 leading-relaxed font-light mb-8">
                A not-for-profit, non-political educational foundation committed to closing the gap between academic theory and industry practice across Nigeria and the wider West African region.
            </p>

            <blockquote class="border-l-2 border-amber-500 pl-4 py-1 mb-10 text-sm sm:text-base italic text-amber-200/90 font-serif-title">
                &ldquo;Branding is not decoration — it is strategy, trust and identity made visible.&rdquo;
                <footer class="text-xs text-amber-400/80 not-italic font-sans mt-1">— Foundation Manifesto</footer>
            </blockquote>

            <div class="flex flex-wrap items-center gap-4">
                <a href="{{ route('membership.register') }}" class="px-6 py-3.5 rounded-xl text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-lg shadow-amber-500/20 transition-all hover:scale-105 flex items-center gap-2">
                    Join Foundation Membership (24/7)
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
                <a href="{{ route('workshops.index') }}" class="px-6 py-3.5 rounded-xl text-sm font-bold bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 transition-all flex items-center gap-2">
                    View Training Cohorts
                </a>
            </div>
        </div>
    </div>
</section>

<!-- The Two Pillars Architecture Banner -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-20">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Pillar 1: Ongoing Membership -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xl border border-slate-200/80 relative overflow-hidden group hover:border-amber-400 transition-all">
            <div class="absolute top-0 right-0 bg-amber-500 text-slate-950 font-extrabold text-[10px] tracking-wider uppercase px-3 py-1 rounded-bl-xl">
                Always Open &bull; 24/7
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center mb-5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Ongoing Foundation Membership</h3>
            <p class="text-slate-600 text-sm leading-relaxed mb-4">
                Open year-round for students, professionals, and institutions. Receive your official <strong>Member ID</strong>, digital credential card, and access to the academy's practitioner community.
            </p>
            <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                <span class="text-xs font-semibold text-slate-500">Student, Professional & Fellow Tracks</span>
                <a href="{{ route('membership.register') }}" class="text-sm font-bold text-amber-600 group-hover:text-amber-700 flex items-center gap-1">
                    Register Now &rarr;
                </a>
            </div>
        </div>

        <!-- Pillar 2: Scheduled Cohorts & Application Windows -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xl border border-slate-200/80 relative overflow-hidden group hover:border-blue-400 transition-all">
            <div class="absolute top-0 right-0 bg-emerald-600 text-white font-extrabold text-[10px] tracking-wider uppercase px-3 py-1 rounded-bl-xl">
                Time-Bound Cohorts
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center mb-5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Workshops & Cohort Windows</h3>
            <p class="text-slate-600 text-sm leading-relaxed mb-4">
                Intensive certification tracks (CBA, CBS, CBE) and vocational masterclasses open for applications during scheduled enrollment windows with automated certificate delivery.
            </p>
            <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                <span class="text-xs font-semibold text-slate-500">Includes 100% Free Community Tracks</span>
                <a href="{{ route('workshops.index') }}" class="text-sm font-bold text-blue-600 group-hover:text-blue-700 flex items-center gap-1">
                    Browse Cohorts &rarr;
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
            @php $window = $workshop->application_window_status; @endphp
            <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between shadow-xs hover:shadow-md transition-shadow">
                <div>
                    <!-- Status & Track Badges -->
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $window['badge_class'] }}">
                            {{ $window['label'] }}
                        </span>
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

                    <a href="{{ route('workshops.show', $workshop->slug) }}" class="w-full inline-flex justify-center items-center py-2.5 px-4 rounded-xl text-xs font-bold {{ $window['state'] == 'open' ? 'bg-amber-500 hover:bg-amber-400 text-slate-950' : 'bg-slate-100 hover:bg-slate-200 text-slate-700' }} transition-colors">
                        {{ $window['state'] == 'open' ? 'Apply for this Cohort' : 'View Syllabus & Status' }}
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12 bg-white rounded-2xl border border-dashed border-slate-300">
                <p class="text-slate-500 text-sm">No cohorts announced at this moment. Stay tuned!</p>
            </div>
        @endforelse
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

<!-- Quick Credential Verification Banner -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="bg-gradient-to-r from-slate-900 to-blue-950 rounded-3xl p-8 sm:p-12 text-white shadow-xl relative overflow-hidden">
        <div class="max-w-2xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-500/20 text-amber-400 border border-amber-500/30 mb-4">
                Tamper-Proof Verification Engine
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold font-serif-title mb-4">
                Verify Any Issued Certificate or Member ID
            </h2>
            <p class="text-slate-300 text-sm leading-relaxed mb-8">
                All certificates generated by Brands Academy Nigeria Foundation feature unique cryptographic tokens and QR codes. Employers and institutions can verify authentic records instantly.
            </p>

            <form action="{{ route('verify.certificate') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="q" placeholder="Enter Certificate # or Verification Token (e.g. BANF-CERT-2024-00108)" class="flex-1 bg-white/10 text-white placeholder-slate-400 px-4 py-3 rounded-xl border border-white/20 focus:outline-none focus:ring-2 focus:ring-amber-400 text-sm">
                <button type="submit" class="px-6 py-3 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold rounded-xl text-sm transition-colors whitespace-nowrap">
                    Verify Credential
                </button>
            </form>
        </div>
    </div>
</section>

@endsection
