@extends('layouts.app')

@section('title', '3-Tier Professional Certification Framework (CBA, CBS, CBE) - Brands Academy')

@section('content')

<!-- Hero Section -->
<section class="bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 text-white py-16 sm:py-20 border-b border-slate-800 relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(217,119,6,0.15),rgba(255,255,255,0))] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/15 text-amber-300 border border-amber-500/30 mb-4">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                Official Competency Framework &bull; CAMA 2020 (Part F)
            </div>
            <h1 class="text-3xl sm:text-5xl font-black font-serif-title tracking-tight text-white mb-5 leading-tight">
                The 3-Tier Professional Certification Pathway
            </h1>
            <p class="text-base sm:text-lg text-slate-300 leading-relaxed font-light mb-8">
                From foundational brand literacy to strategic execution and C-suite governance. Every credential awarded by Brands Academy Nigeria Foundation (CAC/IT/No. 7344471) is verifiable online, cryptographically sealed, and catalogued on the National Register.
            </p>
            <div class="flex flex-wrap items-center gap-4">
                <a href="#matrix" class="px-5 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs sm:text-sm transition-all shadow-md shadow-amber-500/20">
                    Compare Certification Tiers
                </a>
                <a href="{{ route('workshops.index') }}" class="px-5 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-semibold text-xs sm:text-sm border border-slate-700 transition-colors">
                    View Scheduled Cohorts
                </a>
                <a href="{{ route('verify.certificate') }}" class="px-5 py-3 rounded-xl bg-slate-800/80 hover:bg-slate-800 text-amber-300 font-medium text-xs sm:text-sm border border-amber-500/30 transition-colors">
                    Verify an Issued Credential &rarr;
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Success Feedback -->
@if(session('success'))
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-900 text-sm flex items-start gap-3">
            <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <div>
                <strong class="font-bold">Expression of Interest Confirmed!</strong>
                <p class="mt-0.5 text-xs text-emerald-800">{{ session('success') }}</p>
            </div>
        </div>
    </section>
@endif

<!-- Overview Quick Navigation -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="#cba" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-md hover:border-blue-400 transition-all flex items-center justify-between group">
            <div>
                <span class="text-[10px] font-bold text-blue-700 uppercase tracking-widest block">Tier 1 &bull; Foundation</span>
                <h3 class="text-base font-bold text-slate-900 group-hover:text-blue-700 transition-colors">Certified Brand Associate (CBA)</h3>
                <span class="text-xs text-slate-500">6 Weeks &bull; Applied Portfolio</span>
            </div>
            <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-700 font-bold flex items-center justify-center text-sm shrink-0">1</div>
        </a>

        <a href="#cbs" class="bg-white p-5 rounded-2xl border-2 border-amber-500 shadow-md hover:shadow-lg transition-all flex items-center justify-between group">
            <div>
                <span class="text-[10px] font-bold text-amber-700 uppercase tracking-widest block">Tier 2 &bull; Practitioner</span>
                <h3 class="text-base font-bold text-slate-900 group-hover:text-amber-700 transition-colors">Certified Brand Strategist (CBS)</h3>
                <span class="text-xs text-slate-500">8 Weeks &bull; Live Client Defense</span>
            </div>
            <div class="w-8 h-8 rounded-full bg-amber-500 text-slate-950 font-bold flex items-center justify-center text-sm shrink-0">2</div>
        </a>

        <a href="#cbe" class="bg-white p-5 rounded-2xl border border-slate-200 shadow-md hover:border-slate-800 transition-all flex items-center justify-between group">
            <div>
                <span class="text-[10px] font-bold text-slate-600 uppercase tracking-widest block">Tier 3 &bull; Executive</span>
                <h3 class="text-base font-bold text-slate-900 group-hover:text-slate-900 transition-colors">Certified Brand Executive (CBE)</h3>
                <span class="text-xs text-amber-700 font-bold">Launching 2027 &bull; Executive Retreat</span>
            </div>
            <div class="w-8 h-8 rounded-full bg-slate-900 text-amber-400 font-bold flex items-center justify-center text-sm shrink-0">3</div>
        </a>
    </div>
</section>

<!-- Detailed Tier Sections -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-16">

    <!-- TIER 1: CBA -->
    <div id="cba" class="scroll-mt-24 bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 shadow-sm">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            <div class="lg:col-span-7">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-800 border border-blue-200 mb-3">
                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                    Tier 1: Foundation Track
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold font-serif-title text-slate-900 mb-3">
                    Certified Brand Associate (CBA)
                </h2>
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-6">
                    The Certified Brand Associate (CBA) designation is Nigeria's premier foundational benchmark for entry-level brand managers, creative agency juniors, graphic designers transitioning to strategic roles, and marketing graduates. It bridges academic theory with commercial industry execution.
                </p>

                <!-- Prerequisites & Format -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-xs">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-slate-400 uppercase font-bold block mb-1">Prerequisites</span>
                        <p class="text-slate-700 font-medium">B.Sc / HND in any discipline OR 1+ year practical experience in design, content, or marketing.</p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-slate-400 uppercase font-bold block mb-1">Duration &amp; Delivery</span>
                        <p class="text-slate-700 font-medium">6 weeks intensive &bull; Hybrid (Kaduna Training Center + Virtual Live Cohort Sessions).</p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-slate-400 uppercase font-bold block mb-1">Assessment Format</span>
                        <p class="text-slate-700 font-medium">60-question objective assessment + Capstone portfolio project review by Foundation Fellows.</p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-slate-400 uppercase font-bold block mb-1">Post-Nominal Designation</span>
                        <p class="text-slate-900 font-bold">CBA &bull; Verifiable QR Digital Certificate &bull; Good-standing registry listing.</p>
                    </div>
                </div>

                <!-- Syllabus Modules -->
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-900 mb-3">Core Curriculum (5 Modules):</h3>
                <ul class="space-y-2 text-xs sm:text-sm text-slate-600 mb-8">
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-800 font-bold flex items-center justify-center shrink-0 mt-0.5 text-[11px]">1</span>
                        <span><strong>Principles of Strategic Branding:</strong> Architecture models, equity definitions, and brand terminology.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-800 font-bold flex items-center justify-center shrink-0 mt-0.5 text-[11px]">2</span>
                        <span><strong>Audience Research &amp; Segmentation:</strong> Primary consumer profiling, qualitative surveys, and persona mapping.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-800 font-bold flex items-center justify-center shrink-0 mt-0.5 text-[11px]">3</span>
                        <span><strong>Brand Identity &amp; Visual Systems:</strong> Guidelines authoring, typographic hierarchies, color psychology, and tone of voice.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-800 font-bold flex items-center justify-center shrink-0 mt-0.5 text-[11px]">4</span>
                        <span><strong>Multi-channel Brand Rollout:</strong> Collateral development, touchpoint consistency, and campaign messaging briefs.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-blue-100 text-blue-800 font-bold flex items-center justify-center shrink-0 mt-0.5 text-[11px]">5</span>
                        <span><strong>Portfolio Defense &amp; Capstone:</strong> Presentation of a comprehensive brand book before faculty adjudicators.</span>
                    </li>
                </ul>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('workshops.index', ['track' => 'cba']) }}" class="px-5 py-3 rounded-xl text-xs sm:text-sm font-bold bg-blue-700 hover:bg-blue-800 text-white shadow-md transition-all">
                        View Scheduled CBA Cohorts &rarr;
                    </a>
                    <a href="{{ route('membership.register') }}" class="px-4 py-3 rounded-xl text-xs sm:text-sm font-bold bg-slate-100 hover:bg-slate-200 text-slate-800 transition-colors">
                        Join BANF as an Associate Member
                    </a>
                </div>
            </div>

            <!-- Active Cohort Card -->
            <div class="lg:col-span-5 bg-gradient-to-br from-slate-900 to-blue-950 rounded-2xl p-6 sm:p-8 text-white flex flex-col justify-between shadow-lg">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-amber-400 block mb-2">Upcoming CBA Cohort</span>
                    <h3 class="text-xl font-bold font-serif-title mb-2">Cohort 2026-1 (Foundations)</h3>
                    <p class="text-xs text-slate-300 leading-relaxed mb-6 font-light">
                        Applications are currently open. Cohort capacity is limited to 45 candidates to maintain guided 1-on-1 mentorship.
                    </p>

                    <div class="bg-white/10 rounded-xl p-4 space-y-2 text-xs mb-6 backdrop-blur-xs border border-white/10">
                        <div class="flex justify-between">
                            <span class="text-slate-300">Standard Tuition:</span>
                            <span class="font-bold text-white">₦15,000</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-300">Registered BANF Member:</span>
                            <span class="font-bold text-amber-400">₦11,250 (25% off)</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-300">Lead Faculty:</span>
                            <span class="font-semibold text-white">Prof. Samaila Mande &amp; Fellows</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('workshops.index', ['track' => 'cba']) }}" class="w-full py-3 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 text-center transition-colors shadow-md">
                    Apply for Next CBA Cohort
                </a>
            </div>
        </div>
    </div>

    <!-- TIER 2: CBS -->
    <div id="cbs" class="scroll-mt-24 bg-white rounded-3xl border-2 border-amber-500 p-8 sm:p-12 shadow-md relative">
        <div class="absolute -top-3.5 right-8 bg-amber-500 text-slate-950 text-xs font-extrabold px-3.5 py-1 rounded-full uppercase tracking-wider shadow-xs">
            Most Popular Track
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            <div class="lg:col-span-7">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-900 border border-amber-300 mb-3">
                    <span class="w-2 h-2 rounded-full bg-amber-600"></span>
                    Tier 2: Practitioner Track
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold font-serif-title text-slate-900 mb-3">
                    Certified Brand Strategist (CBS)
                </h2>
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-6">
                    Designed for practicing marketers, senior brand executives, communications directors, and creative entrepreneurs. The CBS focuses on applied market differentiation, category positioning, financial brand valuation, and crisis communications across African markets.
                </p>

                <!-- Prerequisites & Format -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-xs">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-slate-400 uppercase font-bold block mb-1">Prerequisites</span>
                        <p class="text-slate-700 font-medium">CBA credential OR minimum 4 years verifiable marketing, communications, or agency experience.</p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-slate-400 uppercase font-bold block mb-1">Duration &amp; Delivery</span>
                        <p class="text-slate-700 font-medium">8 weeks intensive &bull; Virtual Cohort Studio with live case studies &amp; guest masterclasses.</p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-slate-400 uppercase font-bold block mb-1">Assessment Format</span>
                        <p class="text-slate-700 font-medium">Live client brief defense before a panel of Board Fellows + comprehensive strategy simulation exam.</p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <span class="text-slate-400 uppercase font-bold block mb-1">Post-Nominal Designation</span>
                        <p class="text-slate-900 font-bold">CBS &bull; Verifiable Credential Token &bull; Listing as Certified Strategist.</p>
                    </div>
                </div>

                <!-- Syllabus Modules -->
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-900 mb-3">Core Curriculum (5 Modules):</h3>
                <ul class="space-y-2 text-xs sm:text-sm text-slate-600 mb-8">
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-amber-100 text-amber-900 font-bold flex items-center justify-center shrink-0 mt-0.5 text-[11px]">1</span>
                        <span><strong>Advanced Category Positioning:</strong> Blue-ocean differentiation, category framing, and competitive disruption.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-amber-100 text-amber-900 font-bold flex items-center justify-center shrink-0 mt-0.5 text-[11px]">2</span>
                        <span><strong>Brand Equity Valuation:</strong> Perception auditing, brand net-worth calculation, and investor pitch metrics.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-amber-100 text-amber-900 font-bold flex items-center justify-center shrink-0 mt-0.5 text-[11px]">3</span>
                        <span><strong>Crisis PR &amp; Reputation Governance:</strong> Mitigating social shocks, stakeholder communication grids, and executive media handling.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-amber-100 text-amber-900 font-bold flex items-center justify-center shrink-0 mt-0.5 text-[11px]">4</span>
                        <span><strong>Intellectual Property &amp; Legal Protection:</strong> CAC trademark classification, Nice Agreement Classes, and IP defense.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-amber-100 text-amber-900 font-bold flex items-center justify-center shrink-0 mt-0.5 text-[11px]">5</span>
                        <span><strong>Live Client Brief Defense:</strong> Real-world commercial brief executed, presented, and defended before the Board.</span>
                    </li>
                </ul>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('workshops.index', ['track' => 'cbs']) }}" class="px-5 py-3 rounded-xl text-xs sm:text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md transition-all">
                        View Scheduled CBS Cohorts &rarr;
                    </a>
                    <a href="{{ route('registry.index') }}" class="px-4 py-3 rounded-xl text-xs sm:text-sm font-bold bg-slate-100 hover:bg-slate-200 text-slate-800 transition-colors">
                        Inspect Certified Strategists on Register
                    </a>
                </div>
            </div>

            <!-- Active Cohort Card -->
            <div class="lg:col-span-5 bg-gradient-to-br from-slate-950 via-slate-900 to-amber-950 rounded-2xl p-6 sm:p-8 text-white flex flex-col justify-between shadow-lg">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-amber-400 block mb-2">Upcoming CBS Cohort</span>
                    <h3 class="text-xl font-bold font-serif-title mb-2">Cohort 2026-1 (Applied Strategy)</h3>
                    <p class="text-xs text-slate-300 leading-relaxed mb-6 font-light">
                        Opening soon for applications. Cohort strictly capped at 30 practitioners.
                    </p>

                    <div class="bg-white/10 rounded-xl p-4 space-y-2 text-xs mb-6 backdrop-blur-xs border border-white/10">
                        <div class="flex justify-between">
                            <span class="text-slate-300">Standard Tuition:</span>
                            <span class="font-bold text-white">₦45,000</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-300">Registered BANF Member:</span>
                            <span class="font-bold text-amber-400">₦33,750 (25% off)</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-300">Format:</span>
                            <span class="font-semibold text-white">Live Virtual Cohort Studio</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('workshops.index', ['track' => 'cbs']) }}" class="w-full py-3 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 text-center transition-colors shadow-md">
                    View Opening Dates &amp; Syllabus
                </a>
            </div>
        </div>
    </div>

    <!-- TIER 3: CBE -->
    <div id="cbe" class="scroll-mt-24 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 rounded-3xl border border-slate-800 p-8 sm:p-12 text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30 mb-3">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                Tier 3: Executive Track &bull; Launching 2027
            </div>
            <h2 class="text-2xl sm:text-4xl font-extrabold font-serif-title text-white mb-3">
                Certified Brand Executive (CBE)
            </h2>
            <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-8 max-w-3xl font-light">
                The highest professional qualification conferred by Brands Academy Nigeria Foundation. Exclusively curated for Chief Executives, Board Directors, Permanent Secretaries, and Agency Founders who steer public perception, nation branding, and large-scale corporate enterprise equity.
            </p>

            <!-- Prerequisites & Format -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8 text-xs">
                <div class="p-4 rounded-xl bg-slate-900/80 border border-slate-800">
                    <span class="text-amber-400 uppercase font-bold block mb-1">Target Candidates</span>
                    <p class="text-slate-300">CEOs, CMOs, Board Directors, Permanent Secretaries, Agency Principals.</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-900/80 border border-slate-800">
                    <span class="text-amber-400 uppercase font-bold block mb-1">Prerequisites</span>
                    <p class="text-slate-300">10+ years executive leadership OR CBS designation with 5+ years post-certification practice.</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-900/80 border border-slate-800">
                    <span class="text-amber-400 uppercase font-bold block mb-1">Delivery Format</span>
                    <p class="text-slate-300">3-Day Executive Residential Retreat (Abuja) + Boardroom Strategic Advisory Modules.</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-900/80 border border-slate-800">
                    <span class="text-amber-400 uppercase font-bold block mb-1">Post-Nominal</span>
                    <p class="text-amber-400 font-bold">CBE &bull; Full Fellowship eligibility (FBA) &bull; National Register Senior Listing.</p>
                </div>
            </div>

            <!-- Executive Syllabus Outline -->
            <div class="bg-slate-900/90 rounded-2xl p-6 sm:p-8 border border-slate-800 mb-8">
                <h3 class="text-sm font-bold uppercase tracking-wider text-amber-400 mb-4">Executive Retreat Syllabus Modules:</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs sm:text-sm text-slate-300">
                    <div class="flex items-start gap-2.5">
                        <span class="text-amber-400 font-bold mt-0.5">&bull;</span>
                        <span><strong>Corporate Governance &amp; Brand Stewardship:</strong> Fiduciary responsibility of the Board for brand integrity and cultural resonance.</span>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="text-amber-400 font-bold mt-0.5">&bull;</span>
                        <span><strong>Nation Branding &amp; Foreign Direct Investment:</strong> Framing regional narratives, public sector diplomacy, and state investment branding.</span>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="text-amber-400 font-bold mt-0.5">&bull;</span>
                        <span><strong>M&amp;A Brand Valuation &amp; Portfolio Rationalization:</strong> Managing brand architecture during mergers, acquisitions, and cross-border rollouts.</span>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <span class="text-amber-400 font-bold mt-0.5">&bull;</span>
                        <span><strong>High-Stakes Crisis Leadership:</strong> Navigating parliamentary inquiries, regulatory disputes, and enterprise-threatening reputational events.</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-4">
                <a href="#waitlist" class="px-6 py-3.5 rounded-xl text-xs sm:text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-all shadow-md shadow-amber-500/20 inline-flex items-center gap-2">
                    <span>Register Interest for Inaugural 2027 Cohort</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
                <a href="{{ route('faculty') }}" class="px-5 py-3.5 rounded-xl text-xs sm:text-sm font-bold bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 transition-colors">
                    Meet the Board of Trustees &amp; Fellows
                </a>
            </div>
        </div>
    </div>

</section>

<!-- Comparison Matrix -->
<section id="matrix" class="scroll-mt-20 bg-slate-100 py-16 border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-wider text-amber-700 block mb-1">Side-by-Side Comparison</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold font-serif-title text-slate-950">
                Certification Framework Matrix
            </h2>
            <p class="text-slate-600 text-xs sm:text-sm mt-2">
                Evaluate which certification level matches your professional standing, career aspirations, and organizational role.
            </p>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-slate-900 text-white border-b border-slate-800">
                            <th class="p-4 sm:p-5 font-bold">Feature</th>
                            <th class="p-4 sm:p-5 font-bold text-blue-300">Tier 1: CBA (Associate)</th>
                            <th class="p-4 sm:p-5 font-bold text-amber-300">Tier 2: CBS (Strategist)</th>
                            <th class="p-4 sm:p-5 font-bold text-emerald-300">Tier 3: CBE (Executive)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-700">
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-slate-900 bg-slate-50">Target Experience</td>
                            <td class="p-4 sm:p-5">0 – 3 years (Early career / graduates)</td>
                            <td class="p-4 sm:p-5">4 – 9 years (Brand managers / leads)</td>
                            <td class="p-4 sm:p-5 font-semibold text-slate-900">10+ years (C-Suite / Directors)</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-slate-900 bg-slate-50">Prerequisites</td>
                            <td class="p-4 sm:p-5">Degree / HND or practical foundation</td>
                            <td class="p-4 sm:p-5">CBA or 4+ yrs verified practice</td>
                            <td class="p-4 sm:p-5 font-semibold text-slate-900">CBS or 10+ yrs executive leadership</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-slate-900 bg-slate-50">Duration &amp; Format</td>
                            <td class="p-4 sm:p-5">6 Weeks (Hybrid / Virtual)</td>
                            <td class="p-4 sm:p-5">8 Weeks (Virtual Cohort Studio)</td>
                            <td class="p-4 sm:p-5 font-semibold text-slate-900">3-Day Executive Retreat + Advisory</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-slate-900 bg-slate-50">Assessment Format</td>
                            <td class="p-4 sm:p-5">Objective Exam + Capstone Portfolio</td>
                            <td class="p-4 sm:p-5">Strategy Exam + Live Client Defense</td>
                            <td class="p-4 sm:p-5 font-semibold text-slate-900">Boardroom Policy Brief &amp; Peer Review</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-slate-900 bg-slate-50">Post-Nominal Usage</td>
                            <td class="p-4 sm:p-5 font-mono font-bold text-blue-700">CBA</td>
                            <td class="p-4 sm:p-5 font-mono font-bold text-amber-700">CBS</td>
                            <td class="p-4 sm:p-5 font-mono font-bold text-emerald-700">CBE</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-slate-900 bg-slate-50">Digital Credential</td>
                            <td class="p-4 sm:p-5">Verifiable QR + PDF Certificate</td>
                            <td class="p-4 sm:p-5">Verifiable QR + PDF Certificate</td>
                            <td class="p-4 sm:p-5">Verifiable QR + Hardcover Seal + PDF</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-slate-900 bg-slate-50">Public Registry Status</td>
                            <td class="p-4 sm:p-5">Active Certified Associate</td>
                            <td class="p-4 sm:p-5">Active Certified Strategist</td>
                            <td class="p-4 sm:p-5">Senior Executive &bull; Fellowship Eligible</td>
                        </tr>
                        <tr>
                            <td class="p-4 sm:p-5 font-bold text-slate-900 bg-slate-50">Next Available Cohort</td>
                            <td class="p-4 sm:p-5">
                                <a href="{{ route('workshops.index', ['track' => 'cba']) }}" class="text-blue-700 font-bold hover:underline">
                                    Cohort 2026-1 (Open) &rarr;
                                </a>
                            </td>
                            <td class="p-4 sm:p-5">
                                <a href="{{ route('workshops.index', ['track' => 'cbs']) }}" class="text-amber-700 font-bold hover:underline">
                                    Cohort 2026-1 (Opening Soon) &rarr;
                                </a>
                            </td>
                            <td class="p-4 sm:p-5">
                                <a href="#waitlist" class="text-emerald-700 font-bold hover:underline">
                                    Launching 2027 (Waitlist) &rarr;
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Expression of Interest / Waitlist Form -->
<section id="waitlist" class="scroll-mt-24 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 shadow-xl">
        <div class="text-center max-w-xl mx-auto mb-8">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-500/10 text-amber-700 border border-amber-500/20 mb-2">
                Executive Waitlist &bull; Admissions Briefing
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold font-serif-title text-slate-900">
                Register Your Interest
            </h2>
            <p class="text-slate-600 text-xs sm:text-sm mt-1">
                Express interest in the 2027 Certified Brand Executive (CBE) inaugural cohort or receive advance syllabus briefings for CBA / CBS tracks.
            </p>
        </div>

        <form action="{{ route('certifications.interest') }}" method="POST" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Certification Tier of Interest *</label>
                    <select name="tier" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <option value="CBE" selected>Tier 3: Certified Brand Executive (CBE) — 2027 Cohort</option>
                        <option value="CBS">Tier 2: Certified Brand Strategist (CBS) — Upcoming Cohort</option>
                        <option value="CBA">Tier 1: Certified Brand Associate (CBA) — Upcoming Cohort</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Full Legal Name *</label>
                    <input type="text" name="full_name" value="{{ old('full_name', auth()->user()?->name) }}" required placeholder="e.g. Dr. Aliyu Bello" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Official Email Address *</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()?->email) }}" required placeholder="bello@organization.com" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Phone / WhatsApp Number *</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="e.g. +234 803 123 4567" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Organization / Enterprise *</label>
                    <input type="text" name="organization" value="{{ old('organization') }}" required placeholder="e.g. First Bank of Nigeria / Ministry of Commerce" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Current Role / Designation *</label>
                    <input type="text" name="job_title" value="{{ old('job_title') }}" required placeholder="e.g. Chief Marketing Officer / Managing Director" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Years of Strategic / Professional Experience *</label>
                <select name="experience_years" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="1-3 years">1 – 3 Years</option>
                    <option value="4-9 years">4 – 9 Years</option>
                    <option value="10-15 years" selected>10 – 15 Years</option>
                    <option value="15+ years">Over 15 Years (Executive Practice)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Executive Notes / Specific Objectives (Optional)</label>
                <textarea name="notes" rows="3" placeholder="Briefly describe your current brand oversight or what you hope to achieve through this credential..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('notes') }}</textarea>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-3.5 rounded-xl text-xs sm:text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-all shadow-md shadow-amber-500/20">
                    Submit Expression of Interest &bull; Reserve 2027 Priority
                </button>
                <p class="text-[11px] text-slate-400 text-center mt-2">
                    Submitted under NDPA 2023 privacy standards. Your details are reviewed strictly by the BANF Admissions Directorate.
                </p>
            </div>
        </form>
    </div>
</section>

<!-- Statutory Seal Notice -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <div class="p-6 bg-slate-900 rounded-3xl text-white text-xs text-slate-300 flex flex-col sm:flex-row items-center justify-between gap-4 border border-slate-800">
        <div>
            <span class="font-bold text-amber-400 block mb-0.5">Statutory Ratifying Authority</span>
            <span>Brands Academy Nigeria Foundation &bull; CAC/IT/No. 7344471 &bull; Companies and Allied Matters Act 2020 (Part F, Incorporated Trustees)</span>
        </div>
        <a href="{{ route('verify.certificate') }}" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs whitespace-nowrap shrink-0 border border-slate-700 transition-colors">
            Instant Credential Verification &rarr;
        </a>
    </div>
</section>

@endsection
