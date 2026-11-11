@extends('layouts.app')

@section('title', $conference->title . ' | Brands Academy')

@section('content')
<div class="bg-slate-900 text-white py-16 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('conferences.index') }}" class="text-xs text-amber-400 hover:underline flex items-center gap-1 mb-4 font-medium">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            All Conferences &amp; Summits
        </a>

        <div class="max-w-4xl">
            <div class="flex flex-wrap items-center gap-3 mb-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                    Annual Summit {{ $conference->year }}
                </span>
                <span class="text-xs text-slate-300 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ $conference->starts_at->format('M d') }} - {{ $conference->ends_at->format('M d, Y') }}
                </span>
                <span class="text-xs text-slate-300 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                    {{ $conference->venue ?: 'Abuja / Hybrid Plenary' }}
                </span>
            </div>

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight text-white mb-4">
                {{ $conference->title }}
            </h1>

            @if($conference->theme)
                <p class="text-lg sm:text-xl text-amber-400 font-semibold mb-6">
                    "{{ $conference->theme }}"
                </p>
            @endif

            <p class="text-sm sm:text-base text-slate-300 leading-relaxed font-light mb-8 max-w-3xl">
                {{ $conference->description }}
            </p>

            <div class="flex flex-wrap items-center gap-4">
                <a href="#register-tickets" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-sm shadow-md transition-all">
                    <span>Reserve Delegate Pass</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                </a>
                @if($conference->cfp_open)
                    <a href="{{ route('conferences.cfp', $conference->slug) }}" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-medium border border-slate-700 text-sm transition-all">
                        <span>Submit Paper / Abstract (CFP) &rarr;</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-8 rounded-r-xl text-xs text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 border-l-4 border-rose-500 p-4 mb-8 rounded-r-xl text-xs text-rose-800">
            {{ session('error') }}
        </div>
    @endif

    <!-- Keynote Speakers (if configured) -->
    @if(!empty($conference->keynote_speakers))
        <div class="mb-16">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-2">Keynote Plenary Speakers</h2>
            <p class="text-xs sm:text-sm text-slate-500 mb-8">Distinguished scholars and corporate brand custodians presiding over plenary sessions.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($conference->keynote_speakers as $spk)
                    <div class="bg-white rounded-2xl border border-slate-200 p-6 text-center shadow-2xs">
                        <div class="w-20 h-20 rounded-full bg-slate-100 mx-auto mb-4 flex items-center justify-center font-bold text-slate-400 text-lg">
                            {{ substr($spk['name'] ?? 'Faculty', 0, 1) }}
                        </div>
                        <h4 class="text-sm font-bold text-slate-900">{{ $spk['name'] ?? 'Keynote Speaker' }}</h4>
                        <p class="text-xs text-amber-600 font-medium mt-0.5">{{ $spk['title'] ?? 'Speaker' }}</p>
                        <p class="text-[11px] text-slate-500 mt-2">{{ $spk['organization'] ?? 'Brands Academy Board of Trustees' }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Conference Schedule & Agenda -->
    <div class="mb-16">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-bold text-amber-600 uppercase tracking-wider">Conference Program</span>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight mt-1">Multi-Day Plenary Agenda &amp; Sessions</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Keynotes, paper presentations, panels, and networking tracks.</p>
            </div>
            <div class="text-xs text-slate-500 font-mono">
                {{ $conference->schedules->count() }} {{ \Illuminate\Support\Str::plural('Session', $conference->schedules->count()) }} Scheduled
            </div>
        </div>

        @if($conference->schedules->isNotEmpty())
            @php
                $groupedSchedules = $conference->schedules->groupBy('day_number');
            @endphp
            <div class="space-y-8">
                @foreach($groupedSchedules as $dayNum => $sessions)
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
                        <div class="bg-slate-900 text-white px-6 py-4 flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-amber-500 text-slate-950 font-mono">DAY {{ $dayNum }}</span>
                                <span class="text-sm font-bold">
                                    {{ $sessions->first()->day_date ? $sessions->first()->day_date->format('l, F j, Y') : "Summit Day {$dayNum}" }}
                                </span>
                            </div>
                            <span class="text-xs text-slate-400 font-mono">{{ $sessions->count() }} Sessions</span>
                        </div>

                        <div class="divide-y divide-slate-100">
                            @foreach($sessions as $session)
                                <div class="p-6 hover:bg-slate-50/60 transition-colors">
                                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                        <div class="space-y-1.5 flex-1">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="px-2.5 py-1 rounded text-xs font-bold font-mono bg-slate-100 text-slate-700">
                                                    {{ $session->start_time }} - {{ $session->end_time }}
                                                </span>
                                                @if($session->hall_or_stream)
                                                    <span class="text-xs text-slate-500 flex items-center gap-1">
                                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                        {{ $session->hall_or_stream }}
                                                    </span>
                                                @endif
                                            </div>
                                            <h4 class="text-base font-bold text-slate-900">{{ $session->session_title }}</h4>
                                            @if($session->session_description)
                                                <p class="text-xs text-slate-600 leading-relaxed font-light">{!! nl2br(e($session->session_description)) !!}</p>
                                            @endif
                                        </div>

                                        @if($session->speaker_name)
                                            <div class="sm:text-right shrink-0 bg-slate-50 sm:bg-transparent p-3 sm:p-0 rounded-xl">
                                                <div class="text-xs font-bold text-slate-900">{{ $session->speaker_name }}</div>
                                                <div class="text-[11px] text-amber-600 font-medium">Session Speaker / Chair</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-xs text-slate-500 shadow-xs">
                <svg class="w-8 h-8 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Detailed multi-day schedule is being curated by the Scientific Committee. Registered delegates will receive the complete agenda book.
            </div>
        @endif
    </div>

    <!-- Delegate Registration Tickets Section -->
    <div id="register-tickets" class="mb-16 scroll-mt-24">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mb-2">
                Select Your Delegate Pass
            </h2>
            <p class="text-xs sm:text-sm text-slate-500">
                Official accreditation, delegate kit, networking luncheons, and digital badge. Active members receive an automatic 25% discount.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($conference->tickets as $ticket)
                @php
                    $isMember = auth()->user() && auth()->user()->member?->isPaid();
                    $price = $ticket->calculatePriceFor(auth()->user());
                @endphp
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-xl transition-all flex flex-col justify-between group">
                    <div class="p-6 sm:p-8">
                        <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $ticket->name }}</h3>
                        <div class="flex items-baseline gap-2 mb-6">
                            <span class="text-3xl font-black text-slate-900">₦{{ number_format($price, 0) }}</span>
                            @if($isMember)
                                <span class="text-xs text-slate-400 line-through">₦{{ number_format($ticket->regular_price, 0) }}</span>
                                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">25% Member Pass</span>
                            @else
                                <span class="text-xs text-slate-400">Regular</span>
                            @endif
                        </div>

                        <ul class="space-y-2.5 text-xs text-slate-600 mb-6">
                            @if(!empty($ticket->benefits))
                                @foreach($ticket->benefits as $b)
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                        <span>{{ $b }}</span>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    <div class="p-6 sm:p-8 pt-0">
                        @if($ticket->isSoldOut())
                            <button disabled class="w-full py-3 rounded-xl bg-slate-100 text-slate-400 font-bold text-xs cursor-not-allowed">
                                Sold Out
                            </button>
                        @else
                            <!-- Simple Registration Modal Trigger / Form -->
                            <form action="{{ route('conferences.register', $conference->slug) }}" method="POST">
                                @csrf
                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                                <div class="space-y-3 mb-4 text-left">
                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="text" name="first_name" value="{{ old('first_name', auth()->user()?->member?->first_name ?: auth()->user()?->name) }}" required placeholder="First Name *" class="text-xs rounded-lg border-slate-300 w-full focus:ring-blue-500">
                                        <input type="text" name="last_name" value="{{ old('last_name', auth()->user()?->member?->last_name) }}" required placeholder="Last Name *" class="text-xs rounded-lg border-slate-300 w-full focus:ring-blue-500">
                                    </div>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()?->email) }}" required placeholder="Email Address *" class="text-xs rounded-lg border-slate-300 w-full focus:ring-blue-500">
                                    <input type="text" name="organization" value="{{ old('organization') }}" placeholder="Organization / Institution" class="text-xs rounded-lg border-slate-300 w-full focus:ring-blue-500">
                                </div>

                                <button type="submit" class="w-full py-3 rounded-xl bg-slate-900 hover:bg-amber-500 hover:text-slate-950 text-white font-bold text-xs transition-colors shadow-sm">
                                    Register Delegate Pass &rarr;
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
