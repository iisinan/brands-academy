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
            Duly registered with the Corporate Affairs Commission (RC/IT No. 7344471) and ratified under CAMA CAP C20 LFN 2004.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Trustee 1 -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 text-center shadow-xs hover:shadow-md transition-shadow">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-slate-950 to-blue-950 text-amber-400 font-bold text-2xl flex items-center justify-center mx-auto mb-4 font-serif-title shadow-md">
                SM
            </div>
            <h3 class="text-lg font-bold text-slate-900">Prof. Samaila Mande</h3>
            <div class="text-xs font-bold text-amber-700 mt-1">Chairman, Board of Trustees</div>
            <p class="text-xs text-slate-500 mt-3 leading-relaxed">
                Senior academic and brand governance fellow directing the foundation's strategic educational policy.
            </p>
        </div>

        <!-- Trustee 2 -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 text-center shadow-xs hover:shadow-md transition-shadow">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-slate-950 to-blue-950 text-amber-400 font-bold text-2xl flex items-center justify-center mx-auto mb-4 font-serif-title shadow-md">
                YB
            </div>
            <h3 class="text-lg font-bold text-slate-900">Prof. Imam Yagana Babakura</h3>
            <div class="text-xs font-bold text-amber-700 mt-1">Trustee & Academic Director</div>
            <p class="text-xs text-slate-500 mt-1 font-semibold">University of Maiduguri</p>
            <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                Dept. of Marketing, Faculty of Management Sciences. Guiding academic syllabus rigor and accreditation.
            </p>
        </div>

        <!-- Trustee 3 -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 text-center shadow-xs hover:shadow-md transition-shadow">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-slate-950 to-blue-950 text-amber-400 font-bold text-2xl flex items-center justify-center mx-auto mb-4 font-serif-title shadow-md">
                EC
            </div>
            <h3 class="text-lg font-bold text-slate-900">Dr. Okoli Emmanuel Chibuzo</h3>
            <div class="text-xs font-bold text-amber-700 mt-1">Trustee</div>
            <p class="text-xs text-slate-500 mt-3 leading-relaxed">
                Strategy consultant focusing on institutional partnerships, public relations, and curriculum alignment.
            </p>
        </div>

        <!-- Trustee 4 -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 text-center shadow-xs hover:shadow-md transition-shadow">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-slate-950 to-blue-950 text-amber-400 font-bold text-2xl flex items-center justify-center mx-auto mb-4 font-serif-title shadow-md">
                TE
            </div>
            <h3 class="text-lg font-bold text-slate-900">Titus Eveshoyan</h3>
            <div class="text-xs font-bold text-amber-700 mt-1">Secretary to the Board</div>
            <p class="text-xs text-slate-500 mt-3 leading-relaxed">
                Leading the Foundation secretariat, legal compliance, and community outreach operations in Kaduna State.
            </p>
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
                        <span><strong>Community Priority:</strong> Dedicated mentorship allocation for youth in marginalized communities.</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-6 bg-gradient-to-br from-slate-950 to-slate-900 rounded-3xl p-8 text-white shadow-xl">
                <div class="w-12 h-12 rounded-xl bg-amber-500 text-slate-950 font-bold text-xl flex items-center justify-center font-serif-title mb-6">
                    B
                </div>
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
