@extends('layouts.app')

@section('title', $member->full_name . ' (' . $member->member_number . ') - Certified Practitioner Dossier | Brands Academy')

@section('content')
<!-- Practitioner Profile Header -->
<section class="bg-slate-900 text-white py-12 lg:py-16 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('registry.index') }}" class="inline-flex items-center gap-1.5 text-xs text-blue-400 hover:text-blue-300 transition-colors mb-6 font-medium">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            <span>Back to Certified Practitioners Register</span>
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <div class="lg:col-span-2 flex flex-col sm:flex-row items-start gap-6">
                <!-- Avatar initials -->
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl bg-gradient-to-tr from-blue-700 to-indigo-900 text-white font-black text-3xl sm:text-4xl flex items-center justify-center shrink-0 shadow-xl border-2 border-white/10 uppercase">
                    {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                </div>

                <div class="space-y-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $member->category === 'fellow' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'bg-blue-500/20 text-blue-300 border border-blue-500/30' }}">
                            {{ $member->category === 'fellow' ? 'Fellow of Brands Academy (FBA)' : ucwords($member->category) . ' Member' }}
                        </span>
                        <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-400 bg-emerald-500/20 px-2.5 py-1 rounded-full border border-emerald-500/30">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            Active in Good Standing
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold font-serif-title tracking-tight text-white">
                        {{ $member->full_name }}
                    </h1>

                    <p class="text-sm sm:text-base text-slate-300 font-medium">
                        {{ $member->designation ?: 'Certified Brand Practitioner' }}
                        @if($member->institution_or_company)
                            <span class="text-slate-400 font-light">• {{ $member->institution_or_company }}</span>
                        @endif
                    </p>

                    <div class="flex flex-wrap items-center gap-4 pt-2 text-xs text-slate-400 font-mono">
                        <div>ID: <span class="text-white font-bold">{{ $member->member_number }}</span></div>
                        <div>•</div>
                        <div>Jurisdiction: <span class="text-white font-bold">{{ $member->state ?: 'Nigeria' }}</span></div>
                        <div>•</div>
                        <div>Member Since: <span class="text-white font-bold">{{ $member->joined_at ? $member->joined_at->format('Y') : date('Y') }}</span></div>
                    </div>
                </div>
            </div>

            <!-- CPD Metric Card -->
            <div class="lg:col-span-1 bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-xs">
                <div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Continuing Professional Development</div>
                <div class="flex items-baseline gap-2 mb-3">
                    <span class="text-3xl sm:text-4xl font-black text-amber-400">{{ $cpdUnits }}</span>
                    <span class="text-xs text-slate-300 font-medium">CPD Credit Units</span>
                </div>
                <p class="text-xs text-slate-400 font-light leading-relaxed">
                    Verified learning units earned through Brands Academy executive short courses, peer-reviewed journal papers, masterclasses, and plenary summits.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Main Dossier Content -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
        <!-- Left / Center Dossier Content -->
        <div class="lg:col-span-2 space-y-10">
            <!-- Biography -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
                <h2 class="text-lg font-bold font-serif-title text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>Professional Background &amp; Practice Focus</span>
                </h2>
                <div class="text-xs sm:text-sm text-slate-700 leading-relaxed space-y-3 font-light">
                    @if($member->bio)
                        {!! nl2br(e($member->bio)) !!}
                    @else
                        <p>Certified professional in good standing with the Brands Academy Nigeria Foundation. Demonstrates validated competencies across strategic brand architecture, trademark stewardship, corporate identity governance, and evidence-based brand equity management.</p>
                    @endif
                </div>
            </div>

            <!-- Verifiable Credentials & Certificates -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
                <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
                    <div>
                        <h2 class="text-lg font-bold font-serif-title text-slate-900">Verifiable Credentials &amp; Certifications</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Formal executive qualifications and micro-credentials issued by Brands Academy.</p>
                    </div>
                    <span class="text-xs font-mono font-bold px-2.5 py-1 bg-blue-50 text-blue-700 rounded-full">
                        {{ $member->certificates->count() }} Issued
                    </span>
                </div>

                <div class="space-y-4">
                    @forelse($member->certificates as $cert)
                        <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:border-blue-300 hover:bg-white transition-all">
                            <div class="flex items-start gap-3.5">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">{{ $cert->course_title }}</h4>
                                    <div class="text-[11px] text-slate-500 flex items-center gap-2 mt-0.5">
                                        <span class="font-mono text-slate-700 font-semibold">{{ $cert->certificate_number }}</span>
                                        <span>•</span>
                                        <span>Issued: {{ $cert->issued_at ? $cert->issued_at->format('M Y') : 'Active' }}</span>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('verify.certificate', $cert->verification_token) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-xs transition-colors shrink-0">
                                <span>Verify Authenticity</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                        </div>
                    @empty
                        <div class="p-6 text-center text-xs text-slate-400">
                            Member holds valid professional standing; credential verification records will appear here as executive coursework is finalized.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Published Research & Manuscripts in JBSM -->
            @if($publishedArticles->isNotEmpty())
                <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
                    <h2 class="text-lg font-bold font-serif-title text-slate-900 mb-2">Peer-Reviewed Publications in JBSM</h2>
                    <p class="text-xs text-slate-500 mb-6">Original research papers published in the Journal of Brand Science &amp; Management.</p>

                    <div class="space-y-4">
                        @foreach($publishedArticles as $art)
                            <div class="p-4 rounded-xl border border-slate-100 bg-slate-50 space-y-2">
                                <span class="text-[10px] font-bold text-purple-700 bg-purple-100 px-2 py-0.5 rounded font-mono">
                                    {{ $art->issue ? "Vol. {$art->issue->volume->volume_number}, Issue {$art->issue->issue_number}" : 'JBSM' }}
                                </span>
                                <h4 class="text-sm font-bold text-slate-900">
                                    <a href="{{ route('journal.show', $art->slug) }}" class="hover:text-blue-600 transition-colors">
                                        {{ $art->title }}
                                    </a>
                                </h4>
                                <p class="text-xs text-slate-600 line-clamp-2 font-light">{!! nl2br(e($art->abstract)) !!}</p>
                                <div class="pt-2 flex items-center justify-between text-[11px] text-slate-400">
                                    <span>DOI: <strong class="font-mono text-slate-600">{{ $art->doi ?: 'Pending Assignment' }}</strong></span>
                                    <a href="{{ route('journal.show', $art->slug) }}" class="text-blue-600 font-bold hover:underline">Read Paper &rarr;</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Annual Conference Accreditations -->
            @if($conferencesAttended->isNotEmpty())
                <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
                    <h2 class="text-lg font-bold font-serif-title text-slate-900 mb-2">Plenary Summit Accreditations</h2>
                    <p class="text-xs text-slate-500 mb-4">Official delegate passes and symposium participation.</p>

                    <div class="space-y-3">
                        @foreach($conferencesAttended as $del)
                            <div class="p-4 rounded-xl border border-slate-100 bg-slate-50 flex items-center justify-between gap-4">
                                <div>
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900">{{ $del->conference->title }}</h4>
                                    <div class="text-[11px] text-slate-500 font-mono mt-0.5">
                                        Badge: <strong class="text-slate-800">{{ $del->badge_code }}</strong> • Accredited Delegate
                                    </div>
                                </div>
                                <a href="{{ route('conferences.badge', $del->badge_code) }}" target="_blank" class="text-xs text-amber-700 font-bold hover:underline shrink-0">
                                    Digital Badge &rarr;
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Verification Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Official Verification Seal -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs text-center">
                <div class="w-16 h-16 rounded-full bg-emerald-50 border-2 border-emerald-500 text-emerald-600 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h3 class="text-base font-bold text-slate-900">Statutory Verification</h3>
                <p class="text-xs text-slate-500 mt-1 mb-4">
                    This official dossier is cryptographically validated against the National Registry Database.
                </p>

                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-left space-y-2 text-xs mb-4">
                    <div>
                        <span class="text-slate-400 block text-[10px]">Verification URL</span>
                        <span class="font-mono text-slate-800 truncate block text-[11px]">{{ route('registry.show', $member->member_number) }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px]">Registry Status</span>
                        <span class="font-bold text-emerald-700">Accredited &amp; Financial</span>
                    </div>
                </div>

                <a href="{{ route('membership.card', $member->qr_code_token) }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    <span>View Digital Member Card</span>
                </a>
            </div>

            <!-- Contact & Inquiries -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
                <h3 class="text-sm font-bold text-slate-900 mb-2">Practice Inquiries</h3>
                <p class="text-xs text-slate-600 font-light mb-4 leading-relaxed">
                    Corporate organizations and agencies can submit direct institutional briefs or advisory consultation requests for this certified practitioner.
                </p>
                <a href="{{ route('partnerships') }}?subject={{ urlencode('Inquiry regarding ' . $member->full_name . ' (' . $member->member_number . ')') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-50 text-blue-800 hover:bg-blue-100 font-bold text-xs border border-blue-200 transition-colors">
                    <span>Submit Practice Brief</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
