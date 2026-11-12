@extends('layouts.app')

@section('title', 'Faculty, Governance & Mentorship Network - Brands Academy')

@section('content')

<!-- Header -->
<section class="bg-slate-900 text-white py-16 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20 mb-3">
                Academy Governance & Faculty
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold font-serif-title mb-4">
                Faculty, Trustees & Mentors
            </h1>
            <p class="text-slate-300 text-base sm:text-lg leading-relaxed font-light">
                Governed by distinguished academics and brand practitioners committed to closing the gap between classroom theory and real-world branding excellence.
            </p>
        </div>
    </div>
</section>

<!-- Board of Trustees Grid -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center max-w-2xl mx-auto mb-14">
        <div class="text-xs font-bold uppercase tracking-wider text-amber-600 mb-1">Legal Governance</div>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-950 font-serif-title mb-3">
            The Board of Trustees
        </h2>
        <p class="text-xs sm:text-sm text-slate-600">
            Duly registered with the Corporate Affairs Commission (CAC/IT/No. 7344471) under the Companies and Allied Matters Act 2020 (Part F, Incorporated Trustees).
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Trustee 1 -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 text-center shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-slate-950 to-blue-950 text-amber-400 font-bold text-2xl flex items-center justify-center mx-auto mb-4 font-serif-title shadow-md">
                    SM
                </div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900">Prof. Samaila Mande</h3>
                <div class="text-[11px] font-bold text-amber-700 mt-1 uppercase tracking-wide">PhD, FNIMN, FIMC, CMC</div>
                <div class="text-xs font-semibold text-slate-700 mt-0.5">Chairman, Board of Trustees</div>
                <p class="text-xs text-slate-500 mt-3 leading-relaxed">
                    Senior Professor of Marketing &amp; Advertising, Dean of Postgraduate Studies. Over 25 years directing brand governance, academic accreditation, and executive leadership.
                </p>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-400 font-medium">
                Fellow, National Institute of Marketing of Nigeria
            </div>
        </div>

        <!-- Trustee 2 -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 text-center shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-slate-950 to-blue-950 text-amber-400 font-bold text-2xl flex items-center justify-center mx-auto mb-4 font-serif-title shadow-md">
                    YB
                </div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900">Prof. Imam Yagana Babakura</h3>
                <div class="text-[11px] font-bold text-amber-700 mt-1 uppercase tracking-wide">B.Sc, M.Sc, PhD (Marketing)</div>
                <div class="text-xs font-semibold text-slate-700 mt-0.5">Trustee &amp; Academic Director</div>
                <p class="text-xs text-slate-500 mt-1 font-semibold">University of Maiduguri</p>
                <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                    Faculty of Management Sciences. Over 20 years guiding marketing syllabus rigor, brand equity research, and student assessment benchmarks.
                </p>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-400 font-medium">
                Academic Curriculum &amp; Research Committee
            </div>
        </div>

        <!-- Trustee 3 -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 text-center shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-slate-950 to-blue-950 text-amber-400 font-bold text-2xl flex items-center justify-center mx-auto mb-4 font-serif-title shadow-md">
                    EC
                </div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900">Dr. Okoli Emmanuel Chibuzo</h3>
                <div class="text-[11px] font-bold text-amber-700 mt-1 uppercase tracking-wide">PhD, arpa, MNIMN</div>
                <div class="text-xs font-semibold text-slate-700 mt-0.5">Trustee &amp; Strategic Advisory</div>
                <p class="text-xs text-slate-500 mt-3 leading-relaxed">
                    Corporate strategy consultant and brand practitioner. Focuses on institutional partnerships, public relations governance, and commercial viability.
                </p>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-400 font-medium">
                Advertising &amp; Strategic Communications
            </div>
        </div>

        <!-- Trustee 4 -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 text-center shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between">
            <div>
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-slate-950 to-blue-950 text-amber-400 font-bold text-2xl flex items-center justify-center mx-auto mb-4 font-serif-title shadow-md">
                    TE
                </div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900">Titus Eveshoyan</h3>
                <div class="text-[11px] font-bold text-amber-700 mt-1 uppercase tracking-wide">B.Sc, MNIMN</div>
                <div class="text-xs font-semibold text-slate-700 mt-0.5">Secretary to the Board &amp; Registrar</div>
                <p class="text-xs text-slate-500 mt-3 leading-relaxed">
                    Head of Foundation Secretariat in Kaduna. Directs statutory compliance, youth vocational scholarship allocations, and operational logistics.
                </p>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-400 font-medium">
                Secretariat &amp; Regional Operations, Kaduna
            </div>
        </div>
    </div>
</section>

<!-- Teaching Faculty & Cohort Facilitators Section -->
<section class="bg-slate-50 py-16 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <div class="text-xs font-bold uppercase tracking-wider text-amber-600 mb-1">Teaching Faculty</div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-950 font-serif-title mb-3">
                Cohort Facilitators &amp; Course Leaders
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                The experienced brand directors, design architects, and intellectual property practitioners who lead live Saturday masterclasses and mentor cohort learners.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Facilitator 1 -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between">
                <div>
                    <div class="w-16 h-16 rounded-2xl bg-amber-500/10 text-amber-700 font-bold text-xl flex items-center justify-center mx-auto mb-4 font-serif-title border border-amber-500/20">
                        SM
                    </div>
                    <h3 class="text-base font-bold text-slate-900 text-center">Prof. Samaila Mande</h3>
                    <div class="text-[11px] font-bold text-amber-700 text-center mt-0.5">Lead Facilitator &bull; Strategy</div>
                    <div class="text-[11px] text-slate-500 text-center mt-1 font-medium">CBA &amp; CBS Cohorts</div>
                    <p class="text-xs text-slate-600 mt-3 leading-relaxed text-center">
                        Directs Module 1 &amp; Module 5: Brand Positioning Frameworks, Strategic Governance, and Executive Defense.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-500 text-center">
                    <span class="inline-block px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 font-semibold">25+ Yrs Experience</span>
                </div>
            </div>

            <!-- Facilitator 2 -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between">
                <div>
                    <div class="w-16 h-16 rounded-2xl bg-blue-500/10 text-blue-700 font-bold text-xl flex items-center justify-center mx-auto mb-4 font-serif-title border border-blue-500/20">
                        DH
                    </div>
                    <h3 class="text-base font-bold text-slate-900 text-center">Arc. Dahiru Hassan</h3>
                    <div class="text-[11px] font-bold text-blue-700 text-center mt-0.5">Lead Brand Architect</div>
                    <div class="text-[11px] text-slate-500 text-center mt-1 font-medium">Design Systems &amp; Visual Identity</div>
                    <p class="text-xs text-slate-600 mt-3 leading-relaxed text-center">
                        Directs Module 3: Visual Identity Systems, Typography, Design Standards Manuals, and Spatial Brand Architecture.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-500 text-center">
                    <span class="inline-block px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 font-semibold">14+ Yrs Creative Dir.</span>
                </div>
            </div>

            <!-- Facilitator 3 -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between">
                <div>
                    <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 text-emerald-700 font-bold text-xl flex items-center justify-center mx-auto mb-4 font-serif-title border border-emerald-500/20">
                        ZA
                    </div>
                    <h3 class="text-base font-bold text-slate-900 text-center">Barr. Zainab Al-Hassan</h3>
                    <div class="text-[11px] font-bold text-emerald-700 text-center mt-0.5">Senior Facilitator &bull; IP Law</div>
                    <div class="text-[11px] text-slate-500 text-center mt-1 font-medium">Trademark &amp; Regulatory Protection</div>
                    <p class="text-xs text-slate-600 mt-3 leading-relaxed text-center">
                        Directs Module 4: Trademarks Registry Filings, Copyright Safeguards, Licensing Agreements, and Regulatory Defense.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-500 text-center">
                    <span class="inline-block px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 font-semibold">LL.M, IP Attorney</span>
                </div>
            </div>

            <!-- Facilitator 4 -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs hover:shadow-md transition-shadow flex flex-col justify-between">
                <div>
                    <div class="w-16 h-16 rounded-2xl bg-purple-500/10 text-purple-700 font-bold text-xl flex items-center justify-center mx-auto mb-4 font-serif-title border border-purple-500/20">
                        CN
                    </div>
                    <h3 class="text-base font-bold text-slate-900 text-center">Chidi Nwosu</h3>
                    <div class="text-[11px] font-bold text-purple-700 text-center mt-0.5">Senior Facilitator &bull; Insights</div>
                    <div class="text-[11px] text-slate-500 text-center mt-1 font-medium">Market Research &amp; Analytics</div>
                    <p class="text-xs text-slate-600 mt-3 leading-relaxed text-center">
                        Directs Module 2: Quantitative Consumer Research, Brand Equity Valuation, Persona Mapping, and Campaign ROI.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-500 text-center">
                    <span class="inline-block px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 font-semibold">MBA, FMCG Brand Lead</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mentorship Network Section -->
<section class="bg-slate-100 py-16 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-6 space-y-4">
                <span class="text-xs font-bold uppercase tracking-wider text-amber-600 block">Guided Mentorship Framework</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-950 font-serif-title">
                    Practitioners, Not Theorists Alone
                </h2>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Every Academy learner is paired with a mentor drawn from our network of brand strategists, creative directors, and communications practitioners.
                </p>
                <div class="space-y-3 pt-2">
                    <div class="p-4 rounded-xl bg-white border border-slate-200 text-xs text-slate-700 flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-amber-100 text-amber-800 font-bold flex items-center justify-center shrink-0 mt-0.5">&check;</span>
                        <span><strong>1-on-1 Portfolio Reviews:</strong> Mentors critique live decks, client pitches, and visual guidelines.</span>
                    </div>
                    <div class="p-4 rounded-xl bg-white border border-slate-200 text-xs text-slate-700 flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-amber-100 text-amber-800 font-bold flex items-center justify-center shrink-0 mt-0.5">&check;</span>
                        <span><strong>Career Transition Support:</strong> Bridging the jump into marketing leadership or launching brand studios.</span>
                    </div>
                    <div class="p-4 rounded-xl bg-white border border-slate-200 text-xs text-slate-700 flex items-start gap-3">
                        <span class="w-5 h-5 rounded-full bg-amber-100 text-amber-800 font-bold flex items-center justify-center shrink-0 mt-0.5">&check;</span>
                        <span><strong>Community Priority:</strong> Dedicated mentorship allocation for youth in marginalised communities.</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-6 bg-gradient-to-br from-slate-950 to-slate-900 rounded-3xl p-8 text-white shadow-xl">
                <x-brand-logo class="w-14 h-14 mb-6 drop-shadow-md" />
                <h3 class="text-xl font-bold font-serif-title mb-2">Join as a Mentor or Fellow</h3>
                <p class="text-xs text-slate-300 leading-relaxed mb-6 font-light">
                    Are you a senior brand director, strategist, or marketing executive passionate about nurturing the next generation of African brand practitioners?
                </p>
                <a href="{{ route('membership.register') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors shadow-md">
                    Register as a Fellow / Academic Member
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

        </div>
    </div>
</section>

@endsection
