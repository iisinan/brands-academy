@extends(auth()->check() && auth()->user()->member ? 'layouts.member' : 'layouts.app')

@section('title', 'Workshops & Certification Cohorts - Application Periods')
@section('page_title', 'Workshops & Certification Cohorts')

@section('content')

<!-- Header -->
<section class="bg-slate-900 text-white py-14 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20 mb-3">
            Cohort Application Windows
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold font-serif-title mb-3">
            Workshops & Certification Programmes
        </h1>
        <p class="text-slate-300 text-sm sm:text-base max-w-3xl leading-relaxed font-light">
            Each cohort operates with a strict application window. When applications open, members and public candidates can apply for review. Once the window closes, admissions review commences.
        </p>
    </div>
</section>

<!-- Filter Tabs & Listing -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Track Filter Bar -->
    <div class="flex items-center gap-2 overflow-x-auto touch-scroll no-scrollbar mb-4">
        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mr-2 shrink-0">Framework:</span>
        <a href="{{ route('workshops.index', array_filter(['status' => $statusFilter !== 'all' ? $statusFilter : null])) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap shrink-0 transition-all {{ $trackFilter == 'all' ? 'bg-slate-900 text-amber-400 shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
            All Tracks
        </a>
        <a href="{{ route('workshops.index', array_filter(['track' => 'cba', 'status' => $statusFilter !== 'all' ? $statusFilter : null])) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap shrink-0 transition-all {{ $trackFilter == 'cba' ? 'bg-slate-900 text-amber-400 shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
            Tier 1: CBA (Associate)
        </a>
        <a href="{{ route('workshops.index', array_filter(['track' => 'cbs', 'status' => $statusFilter !== 'all' ? $statusFilter : null])) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap shrink-0 transition-all {{ $trackFilter == 'cbs' ? 'bg-slate-900 text-amber-400 shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
            Tier 2: CBS (Strategist)
        </a>
        <a href="{{ route('workshops.index', array_filter(['track' => 'cbe', 'status' => $statusFilter !== 'all' ? $statusFilter : null])) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap shrink-0 transition-all {{ $trackFilter == 'cbe' ? 'bg-slate-900 text-amber-400 shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
            Tier 3: CBE (Executive &bull; 2027)
        </a>
        <a href="{{ route('certifications') }}" class="ml-auto text-xs font-bold text-amber-700 hover:text-amber-800 whitespace-nowrap shrink-0 inline-flex items-center gap-1">
            <span>Framework Details &amp; Prerequisites &rarr;</span>
        </a>
    </div>

    <!-- Status Filters -->
    <div class="flex items-center gap-2 overflow-x-auto touch-scroll no-scrollbar mb-8 border-b border-slate-200 pb-4">
        <a href="{{ route('workshops.index', array_filter(['track' => $trackFilter !== 'all' ? $trackFilter : null])) }}" class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap shrink-0 transition-all {{ $statusFilter == 'all' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
            All Programmes ({{ $counts['all'] }})
        </a>
        <a href="{{ route('workshops.index', array_filter(['status' => 'open', 'track' => $trackFilter !== 'all' ? $trackFilter : null])) }}" class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap shrink-0 transition-all {{ $statusFilter == 'open' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white text-emerald-800 hover:bg-emerald-50 border border-emerald-200' }}">
            Applications Open Now ({{ $counts['open'] }})
        </a>
        <a href="{{ route('workshops.index', array_filter(['status' => 'upcoming', 'track' => $trackFilter !== 'all' ? $trackFilter : null])) }}" class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap shrink-0 transition-all {{ $statusFilter == 'upcoming' ? 'bg-amber-600 text-white shadow-xs' : 'bg-white text-amber-800 hover:bg-amber-50 border border-amber-200' }}">
            Opening Soon ({{ $counts['upcoming'] }})
        </a>
        <a href="{{ route('workshops.index', array_filter(['status' => 'closed', 'track' => $trackFilter !== 'all' ? $trackFilter : null])) }}" class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap shrink-0 transition-all {{ $statusFilter == 'closed' ? 'bg-slate-700 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
            Applications Closed ({{ $counts['closed'] }})
        </a>
    </div>

    <!-- Free Community Track & Scholarship Explainer Banner -->
    <div class="mb-10 p-6 sm:p-7 rounded-3xl bg-gradient-to-r from-emerald-950 via-slate-900 to-slate-950 text-white border border-emerald-800/60 shadow-lg relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 mb-2.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    Non-Profit Public Benefit Mission &bull; CAMA 2020 Part F
                </div>
                <h3 class="text-xl font-bold font-serif-title text-white mb-2">
                    Tuition-Free Community &amp; Youth Vocational Scholarships
                </h3>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-light">
                    In fulfillment of our statutory non-profit constitution, the Foundation allocates 100% tuition-free seats in our vocational cohorts for unemployed youth, early-career apprentices, and applicants from marginalised communities across Nigeria.
                </p>
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs text-slate-300">
                    <div class="flex items-center gap-2">
                        <span class="text-emerald-400 font-bold">&check;</span>
                        <span><strong>Who Qualifies:</strong> Youth (under 30), undergraduates, job-seekers</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-emerald-400 font-bold">&check;</span>
                        <span><strong>Coverage:</strong> 100% Tuition, Live Mentorship &amp; Assessment</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-emerald-400 font-bold">&check;</span>
                        <span><strong>Turnaround:</strong> Decisions within 5 working days of window close</span>
                    </div>
                </div>
            </div>
            <div class="shrink-0 flex flex-col sm:flex-row lg:flex-col gap-2.5">
                <a href="{{ route('workshops.index', ['track' => 'cba']) }}" class="px-5 py-3 rounded-xl text-xs font-bold bg-emerald-500 hover:bg-emerald-400 text-slate-950 transition-all text-center shadow-md">
                    Apply for Free Vocational Track &rarr;
                </a>
                <a href="{{ route('about') }}#manifesto" class="px-5 py-2.5 rounded-xl text-xs font-semibold bg-slate-800/80 hover:bg-slate-700 text-slate-300 transition-colors text-center border border-slate-700">
                    Read Foundation Charter
                </a>
            </div>
        </div>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($workshops as $workshop)
            @php
                $window = $workshop->application_window_status;
                $userApp = null;
                if (auth()->check()) {
                    $u = auth()->user();
                    $m = $u->member;
                    $userApp = \App\Models\WorkshopApplication::where(function ($q) use ($workshop) {
                            $q->where('workshop_id', $workshop->id);
                            if ($workshop->track_type) {
                                $q->orWhereHas('workshop', fn ($wq) => $wq->where('track_type', $workshop->track_type));
                            }
                        })
                        ->where(function ($q) use ($u, $m) {
                            $q->where('user_id', $u->id)
                                ->orWhere('applicant_email', $u->email);
                            if ($m) {
                                $q->orWhere('member_id', $m->id);
                                if ($m->email) {
                                    $q->orWhere('applicant_email', $m->email);
                                }
                            }
                        })->first();
                }
            @endphp
            <div class="bg-white rounded-2xl border {{ $userApp ? 'border-emerald-300 ring-1 ring-emerald-500/20' : 'border-slate-200' }} p-6 flex flex-col justify-between shadow-xs hover:shadow-md transition-all group">
                <div>
                    <!-- Top Window Banner -->
                    <div class="flex items-center justify-between gap-2 mb-4">
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
                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            {{ $workshop->delivery_mode }}
                        </span>
                    </div>

                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-extrabold uppercase tracking-wide mb-2 {{ $workshop->track_type === 'cba' ? 'bg-blue-50 text-blue-800 border border-blue-200' : ($workshop->track_type === 'cbs' ? 'bg-amber-50 text-amber-900 border border-amber-300' : 'bg-slate-100 text-slate-800 border border-slate-200') }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $workshop->track_type === 'cba' ? 'bg-blue-600' : ($workshop->track_type === 'cbs' ? 'bg-amber-600' : 'bg-slate-600') }}"></span>
                        {{ $workshop->track_label }}
                    </div>

                    <h2 class="text-xl font-bold text-slate-900 group-hover:text-amber-600 transition-colors mb-2 leading-snug">
                        <a href="{{ route('workshops.show', $workshop->slug) }}">
                            {{ $workshop->title }}
                        </a>
                    </h2>

                    <p class="text-sm text-slate-600 line-clamp-3 mb-6 leading-relaxed">
                        {{ $workshop->tagline ?? $workshop->description }}
                    </p>

                    <!-- Key Dates Summary -->
                    <div class="bg-slate-50 p-4 rounded-xl space-y-2 text-xs border border-slate-100 mb-6">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Application Closes:</span>
                            <span class="font-bold text-slate-800">{{ $workshop->application_deadline->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Cohort Duration:</span>
                            <span class="font-semibold text-slate-700">{{ $workshop->starts_at->format('M d') }} – {{ $workshop->ends_at->format('M d, Y') }}</span>
                        </div>
                        @if($workshop->capacity)
                            <div class="flex justify-between">
                                <span class="text-slate-500">Cohort Seats:</span>
                                <span class="font-semibold text-slate-700">Max {{ $workshop->capacity }} Participants</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-4">
                    <div>
                        @if($workshop->fee_type == 'free')
                            <span class="block text-[10px] uppercase font-bold text-slate-400">Tuition</span>
                            <span class="font-extrabold text-sm text-emerald-700">100% Free Track</span>
                        @elseif(auth()->check() && auth()->user()->member)
                            <span class="block text-[10px] uppercase font-bold text-slate-400">Member Tuition (25% Off)</span>
                            <div class="flex items-baseline gap-1.5">
                                <span class="font-extrabold text-sm text-slate-900 font-mono">NGN {{ number_format($workshop->member_fee_amount) }}</span>
                                <span class="text-[10px] text-slate-400 line-through">NGN {{ number_format($workshop->fee_amount) }}</span>
                            </div>
                        @else
                            <span class="block text-[10px] uppercase font-bold text-slate-400">Tuition</span>
                            <div class="flex items-baseline gap-1">
                                <span class="font-extrabold text-sm text-slate-900 font-mono">NGN {{ number_format($workshop->fee_amount) }}</span>
                                <span class="text-[9px] font-bold text-amber-800 bg-amber-100 px-1 rounded">25% off for Members</span>
                            </div>
                        @endif
                    </div>

                    @if($userApp)
                        <a href="{{ route('workshops.show', $workshop->slug) }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-bold {{ $userApp->status === 'accepted' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-blue-100 text-blue-800 border border-blue-300' }} transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>{{ $userApp->status === 'accepted' ? 'Enrolled • View' : 'Applied • View' }}</span>
                        </a>
                    @else
                        <a href="{{ route('workshops.show', $workshop->slug) }}" class="inline-flex items-center px-4 py-2.5 rounded-xl text-xs font-bold {{ $window['state'] == 'open' ? 'bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-xs' : 'bg-slate-900 hover:bg-slate-800 text-white' }} transition-colors">
                            {{ $window['state'] == 'open' ? 'Apply Now' : 'View Details' }}
                        </a>
                    @endif
                </div>
            </div>
        @empty
            @if($trackFilter === 'cbe')
                <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 rounded-3xl p-8 sm:p-12 text-white border border-slate-800 shadow-xl relative overflow-hidden">
                    <div class="absolute -right-16 -bottom-16 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="max-w-2xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30 mb-4">
                            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                            Executive Track &bull; Launching 2027
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-extrabold font-serif-title text-white mb-3">
                            Certified Brand Executive (CBE) — Inaugural Cohort
                        </h3>
                        <p class="text-slate-300 text-sm leading-relaxed mb-6 font-light">
                            The CBE track is an exclusive executive residential retreat and strategic boardroom masterclass designed for C-Suite leaders, Managing Directors, Permanent Secretaries, and Agency Founders.
                            The Board of Trustees is scheduling the inaugural cohort for 2027 in Abuja.
                        </p>
                        <div class="bg-slate-800/80 rounded-2xl p-5 border border-slate-700/80 mb-6 text-xs text-slate-300 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Target Candidates:</span>
                                <span class="font-bold text-white">CEOs, CMOs, Directors, Public Administrators</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Prerequisites:</span>
                                <span class="font-bold text-white">10+ Years Executive Practice or CBS Credential</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Delivery Format:</span>
                                <span class="font-bold text-amber-400">3-Day Executive Residential Retreat</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-4">
                            <a href="{{ route('certifications') }}#waitlist" class="px-6 py-3 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-all shadow-md shadow-amber-500/20 inline-flex items-center gap-2">
                                <span>Register Interest for 2027 Cohort</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                            <a href="{{ route('certifications') }}#cbe" class="px-5 py-3 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 transition-colors">
                                View Executive Syllabus
                            </a>
                            <a href="{{ route('workshops.index') }}" class="text-xs font-semibold text-slate-400 hover:text-slate-200">
                                View All Available Cohorts &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-16 bg-white rounded-2xl border border-dashed border-slate-300">
                    <svg class="w-10 h-10 text-slate-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-slate-700 font-bold mb-1">No programmes match this filter</p>
                    <p class="text-slate-500 text-xs mb-4">Try selecting 'All Tracks' or 'All Programmes' to view active and upcoming cohorts.</p>
                    <a href="{{ route('workshops.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold bg-slate-900 text-white hover:bg-slate-800">
                        Reset Filters
                    </a>
                </div>
            @endif
        @endforelse
    </div>

</section>

@endsection
