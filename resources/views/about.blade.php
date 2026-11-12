@extends('layouts.app')

@section('title', 'About & Manifesto - Brands Academy Nigeria Foundation')

@section('content')

<!-- Header Banner -->
<section class="relative bg-[#3b5d4f] text-white py-16 lg:py-20 border-b border-white/15 overflow-hidden">
    <div class="hidden md:block absolute top-8 right-10 w-48 h-28 furni-dots-light pointer-events-none opacity-60" aria-hidden="true"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20 mb-4">
                Institutional Charter & Profile
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold font-serif-title mb-6">
                About the Foundation
            </h1>
            <p class="text-slate-300 text-lg leading-relaxed font-light">
                Brands Academy Nigeria Foundation is a not-for-profit, non-political educational foundation incorporated under the laws of the Federal Republic of Nigeria.
            </p>
        </div>
    </div>
</section>

<!-- Legal & Institutional Data Table -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-6 sm:p-8">
        <h2 class="text-xs font-bold uppercase tracking-wider text-amber-600 mb-4">Institutional Credential Summary</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 text-sm">
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <span class="text-xs text-slate-500 block uppercase font-bold">Registered Name</span>
                <span class="font-bold text-slate-900">BRANDS ACADEMY NIGERIA FOUNDATION</span>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <span class="text-xs text-slate-500 block uppercase font-bold">CAC Registration Number</span>
                <span class="font-bold text-slate-900 font-mono">CAC/IT/No. 7344471</span>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <span class="text-xs text-slate-500 block uppercase font-bold">Date of Incorporation</span>
                <span class="font-bold text-slate-900">12 February 2024</span>
            </div>
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                <span class="text-xs text-slate-500 block uppercase font-bold">Entity Type</span>
                <span class="font-bold text-slate-900">Incorporated Trustee (Companies and Allied Matters Act 2020, Part F)</span>
            </div>
        </div>

        <!-- Statutory Constitution Summary Strip -->
        <div class="mt-6 pt-6 border-t border-slate-100">
            <div class="flex items-center gap-2 mb-3">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">Statutory Constitution Clauses &amp; Public Transparency</h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs text-slate-600 leading-relaxed">
                <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                    <strong class="text-slate-900 block mb-1">1. Non-Profit Objects Clause</strong>
                    All income and property are dedicated exclusively to educational training, professional certification, and youth vocational advancement.
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                    <strong class="text-slate-900 block mb-1">2. Non-Distribution Clause</strong>
                    No portion of funds, dividends, or profits is distributed to Trustees or members; governance operates strictly in trust.
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                    <strong class="text-slate-900 block mb-1">3. Dissolution Safeguard</strong>
                    Upon dissolution, all residual assets transfer exclusively to an approved non-profit institution with identical educational aims.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Manifesto & Philosophy -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20" id="manifesto">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
        <div class="lg:col-span-5">
            <div class="text-xs font-bold uppercase tracking-wider text-amber-600 mb-2">Our Core Belief</div>
            <h2 class="text-3xl font-extrabold text-slate-950 font-serif-title mb-6 leading-tight">
                The Foundation Manifesto
            </h2>
            <div class="p-6 rounded-2xl bg-amber-500/10 border-l-4 border-amber-500 text-slate-800 text-base italic leading-relaxed mb-6 font-serif-title">
                &ldquo;We believe branding is not decoration — it is strategy, trust and identity made visible. We believe that world-class branding education should not be the preserve of a privileged few, and that a well-trained brand practitioner can transform a small business, a public institution, or a community.&rdquo;
            </div>
            <p class="text-sm text-slate-600 leading-relaxed">
                Registered as an Incorporated Trustee with the Corporate Affairs Commission, the Foundation is governed by a constitution that commits its income and property solely to the promotion of its educational objects, with no distribution of profit to members — the hallmark of a genuine public-benefit institution.
            </p>
        </div>

        <!-- 5 Core Values -->
        <div class="lg:col-span-7">
            <div class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Guiding Principles</div>
            <h3 class="text-2xl font-extrabold text-slate-950 font-serif-title mb-6">Our 5 Core Values</h3>
            <div class="space-y-4">
                <div class="p-5 rounded-xl border border-slate-200 bg-white shadow-xs">
                    <h4 class="font-bold text-slate-900 text-base mb-1 text-amber-700">1. Integrity</h4>
                    <p class="text-sm text-slate-600 leading-relaxed">We operate transparently and hold our income and assets solely in trust for our educational mission.</p>
                </div>
                <div class="p-5 rounded-xl border border-slate-200 bg-white shadow-xs">
                    <h4 class="font-bold text-slate-900 text-base mb-1 text-amber-700">2. Excellence</h4>
                    <p class="text-sm text-slate-600 leading-relaxed">Our curricula and certification tracks are built to internationally benchmarked standards.</p>
                </div>
                <div class="p-5 rounded-xl border border-slate-200 bg-white shadow-xs">
                    <h4 class="font-bold text-slate-900 text-base mb-1 text-amber-700">3. Inclusion</h4>
                    <p class="text-sm text-slate-600 leading-relaxed">We prioritise the educational needs of marginalised communities, including economically disadvantaged groups and ethnic minorities.</p>
                </div>
                <div class="p-5 rounded-xl border border-slate-200 bg-white shadow-xs">
                    <h4 class="font-bold text-slate-900 text-base mb-1 text-amber-700">4. Mentorship</h4>
                    <p class="text-sm text-slate-600 leading-relaxed">We pair every learner with practical, guided support rather than content alone.</p>
                </div>
                <div class="p-5 rounded-xl border border-slate-200 bg-white shadow-xs">
                    <h4 class="font-bold text-slate-900 text-base mb-1 text-amber-700">5. Impact</h4>
                    <p class="text-sm text-slate-600 leading-relaxed">We measure success by learner outcomes and community reach, not enrolment numbers.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Governance: Board of Trustees -->
<section class="bg-slate-100 py-20 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <div class="text-xs font-bold uppercase tracking-wider text-amber-600 mb-1">Governance</div>
            <h2 class="text-3xl font-extrabold text-slate-950 font-serif-title mb-4">Board of Trustees</h2>
            <p class="text-sm text-slate-600">
                Trustees nominated at the founding meeting of 1 October 2023 and confirmed upon incorporation on 12 February 2024.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs text-center flex flex-col justify-between">
                <div>
                    <div class="w-16 h-16 rounded-full bg-slate-900 text-amber-400 font-bold text-xl flex items-center justify-center mx-auto mb-4 font-serif-title shadow-xs">
                        SM
                    </div>
                    <h3 class="font-bold text-slate-900 text-base">Prof. Samaila Mande</h3>
                    <div class="text-[11px] font-bold text-amber-700 mt-0.5">PhD, FNIMN, FIMC, CMC</div>
                    <div class="text-xs font-semibold text-slate-700 mt-1">Chairman, Board of Trustees</div>
                    <div class="text-[11px] text-slate-500 mt-2">Senior Professor of Marketing &amp; Brand Governance</div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs text-center flex flex-col justify-between">
                <div>
                    <div class="w-16 h-16 rounded-full bg-slate-900 text-amber-400 font-bold text-xl flex items-center justify-center mx-auto mb-4 font-serif-title shadow-xs">
                        YB
                    </div>
                    <h3 class="font-bold text-slate-900 text-base">Prof. Imam Yagana Babakura</h3>
                    <div class="text-[11px] font-bold text-amber-700 mt-0.5">PhD (Marketing)</div>
                    <div class="text-xs font-semibold text-slate-700 mt-1">Trustee &amp; Academic Director</div>
                    <div class="text-[11px] text-slate-500 mt-2">Dept. of Marketing, University of Maiduguri</div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs text-center flex flex-col justify-between">
                <div>
                    <div class="w-16 h-16 rounded-full bg-slate-900 text-amber-400 font-bold text-xl flex items-center justify-center mx-auto mb-4 font-serif-title shadow-xs">
                        EC
                    </div>
                    <h3 class="font-bold text-slate-900 text-base">Dr. Okoli Emmanuel Chibuzo</h3>
                    <div class="text-[11px] font-bold text-amber-700 mt-0.5">PhD, arpa, MNIMN</div>
                    <div class="text-xs font-semibold text-slate-700 mt-1">Trustee &amp; Strategic Advisory</div>
                    <div class="text-[11px] text-slate-500 mt-2">Corporate Strategy Consultant &amp; ARCON Fellow</div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs text-center flex flex-col justify-between">
                <div>
                    <div class="w-16 h-16 rounded-full bg-slate-900 text-amber-400 font-bold text-xl flex items-center justify-center mx-auto mb-4 font-serif-title shadow-xs">
                        TE
                    </div>
                    <h3 class="font-bold text-slate-900 text-base">Titus Eveshoyan</h3>
                    <div class="text-[11px] font-bold text-amber-700 mt-0.5">B.Sc, MNIMN</div>
                    <div class="text-xs font-semibold text-slate-700 mt-1">Secretary to the Board &amp; Registrar</div>
                    <div class="text-[11px] text-slate-500 mt-2">Head of Foundation Secretariat, Kaduna</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- The 6-Step Admission Model -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="text-center max-w-2xl mx-auto mb-16">
        <div class="text-xs font-bold uppercase tracking-wider text-amber-600 mb-1">Admissions Pathway</div>
        <h2 class="text-3xl font-extrabold text-slate-950 font-serif-title mb-4">The 6-Step Admission Model</h2>
        <p class="text-sm text-slate-600">A straightforward, transparent pathway accessible to students, professionals and community learners.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-xs font-extrabold text-amber-600 mb-1">STEP 1</div>
            <h4 class="font-bold text-slate-900 text-sm mb-2">Enquiry</h4>
            <p class="text-xs text-slate-600">Learners submit an enquiry or view open cohort schedules.</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-xs font-extrabold text-amber-600 mb-1">STEP 2</div>
            <h4 class="font-bold text-slate-900 text-sm mb-2">Application</h4>
            <p class="text-xs text-slate-600">Complete application during open cohort window.</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-xs font-extrabold text-amber-600 mb-1">STEP 3</div>
            <h4 class="font-bold text-slate-900 text-sm mb-2">Assessment</h4>
            <p class="text-xs text-slate-600">Review for fit and scholarship / community-priority criteria.</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-xs font-extrabold text-amber-600 mb-1">STEP 4</div>
            <h4 class="font-bold text-slate-900 text-sm mb-2">Enrolment</h4>
            <p class="text-xs text-slate-600">Successful candidates receive offer letters & complete onboarding.</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-xs font-extrabold text-amber-600 mb-1">STEP 5</div>
            <h4 class="font-bold text-slate-900 text-sm mb-2">Orientation</h4>
            <p class="text-xs text-slate-600">Mentor pairing session and platform walkthrough.</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-xs font-extrabold text-amber-600 mb-1">STEP 6</div>
            <h4 class="font-bold text-slate-900 text-sm mb-2">Commencement</h4>
            <p class="text-xs text-slate-600">Live instruction, portfolio builds & certificate issuance.</p>
        </div>
    </div>
</section>

<!-- Statutory Charters & Governance Documents -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
    <div class="bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 rounded-3xl p-8 sm:p-10 text-white border border-slate-800 shadow-xl">
        <div class="max-w-2xl mb-8">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-500/15 text-amber-300 border border-amber-500/30 mb-3">
                Official Foundation Charters
            </span>
            <h3 class="text-2xl font-bold font-serif-title text-white mb-2">Governance &amp; Statutory Charters</h3>
            <p class="text-slate-300 text-xs sm:text-sm leading-relaxed font-light">
                In strict adherence to the Companies and Allied Matters Act 2020 (Part F) and the Nigeria Data Protection Act 2023, Brands Academy Nigeria Foundation publishes its governance policies for full public transparency.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <a href="{{ route('legal.ethics') }}" class="p-5 rounded-2xl bg-slate-900/90 border border-slate-800 hover:border-amber-500/60 transition-all group block">
                <div class="w-9 h-9 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center font-bold text-sm mb-3 group-hover:scale-105 transition-transform">§</div>
                <h4 class="font-bold text-white text-sm mb-1 group-hover:text-amber-300 transition-colors">Code of Ethics &amp; Charter</h4>
                <p class="text-xs text-slate-400 leading-relaxed">The 7 Canons of professional practice required of all certified members and Fellows.</p>
                <span class="text-[11px] font-bold text-amber-400 mt-3 inline-flex items-center gap-1">Read Charter &rarr;</span>
            </a>

            <a href="{{ route('legal.privacy') }}" class="p-5 rounded-2xl bg-slate-900/90 border border-slate-800 hover:border-emerald-500/60 transition-all group block">
                <div class="w-9 h-9 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center font-bold text-sm mb-3 group-hover:scale-105 transition-transform">✓</div>
                <h4 class="font-bold text-white text-sm mb-1 group-hover:text-emerald-300 transition-colors">Privacy Policy (NDPA 2023)</h4>
                <p class="text-xs text-slate-400 leading-relaxed">Statutory data processing standards, identity upload safeguards, and user rights.</p>
                <span class="text-[11px] font-bold text-emerald-400 mt-3 inline-flex items-center gap-1">Read Policy &rarr;</span>
            </a>

            <a href="{{ route('legal.terms') }}" class="p-5 rounded-2xl bg-slate-900/90 border border-slate-800 hover:border-blue-500/60 transition-all group block">
                <div class="w-9 h-9 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center font-bold text-sm mb-3 group-hover:scale-105 transition-transform">⚖</div>
                <h4 class="font-bold text-white text-sm mb-1 group-hover:text-blue-300 transition-colors">Terms of Use &amp; Refunds</h4>
                <p class="text-xs text-slate-400 leading-relaxed">Admissions turnaround, 100% refund window, deferral terms, and statutory disclaimers.</p>
                <span class="text-[11px] font-bold text-blue-400 mt-3 inline-flex items-center gap-1">Read Terms &rarr;</span>
            </a>
        </div>
    </div>
</section>

@endsection
