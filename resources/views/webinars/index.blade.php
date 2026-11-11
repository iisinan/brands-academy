@extends('layouts.app')

@section('title', 'Webinars & Virtual Masterclasses - Brands Academy')

@section('content')

<!-- Header -->
<section class="bg-slate-900 text-white py-14 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-purple-500/10 text-purple-400 border border-purple-500/20 mb-3">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
            Live Video Masterclasses
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold font-serif-title mb-3">
            Webinars & Brand Strategy Masterclasses
        </h1>
        <p class="text-slate-300 text-sm sm:text-base max-w-3xl leading-relaxed font-light">
            Interactive virtual sessions hosted via Google Meet featuring prominent brand practitioners, IP attorneys, and enterprise leaders. Register to receive your calendar invite and live room access.
        </p>
    </div>
</section>

<!-- Upcoming Webinars -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold font-serif-title text-slate-900">Upcoming Live Sessions</h2>
            <p class="text-xs text-slate-500">Scheduled live video events with interactive faculty Q&A.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($upcomingWebinars as $webinar)
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden flex flex-col justify-between shadow-xs hover:shadow-md transition-all group">
                <div class="p-6">
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold {{ $webinar->isLive() ? 'bg-rose-100 text-rose-800 animate-pulse' : 'bg-purple-50 text-purple-700 border border-purple-200' }}">
                            @if($webinar->isLive())
                                <span class="w-2 h-2 rounded-full bg-rose-600"></span>
                                Live Now
                            @else
                                {{ $webinar->starts_at->format('M d, Y • h:i A') }}
                            @endif
                        </span>
                        <span class="text-xs text-slate-400 font-mono">{{ $webinar->duration_minutes }} Mins</span>
                    </div>

                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-purple-600 transition-colors line-clamp-2 mb-2">
                        <a href="{{ route('webinars.show', $webinar->slug) }}">
                            {{ $webinar->title }}
                        </a>
                    </h3>

                    <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed mb-6 font-light">
                        {{ $webinar->summary ?: 'An executive brand masterclass exploring innovative frameworks and real-world execution.' }}
                    </p>

                    <!-- Speaker -->
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                        <div class="w-10 h-10 rounded-full bg-purple-700 text-white flex items-center justify-center font-bold text-xs uppercase shrink-0">
                            {{ substr($webinar->speaker_name, 0, 2) }}
                        </div>
                        <div class="truncate">
                            <div class="text-xs font-bold text-slate-900 truncate">{{ $webinar->speaker_name }}</div>
                            <div class="text-[11px] text-slate-500 truncate">{{ $webinar->speaker_title ?: 'Guest Keynote Speaker' }}</div>
                        </div>
                    </div>
                </div>

                <div class="p-6 pt-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-4">
                    <div>
                        <div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Access</div>
                        @if($webinar->fee_type === 'free' || $webinar->regular_price <= 0)
                            <span class="text-sm font-extrabold text-emerald-600">Free Public Access</span>
                        @else
                            <span class="text-sm font-extrabold text-slate-900">₦{{ number_format($webinar->regular_price, 2) }}</span>
                            <span class="text-[10px] text-blue-700 font-bold block">(25% off for members)</span>
                        @endif
                    </div>

                    <a href="{{ route('webinars.show', $webinar->slug) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold shadow-xs transition-all">
                        <span>RSVP / Details</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-dashed border-slate-300 p-8">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                <h3 class="text-base font-bold text-slate-800 mb-1">No upcoming webinars scheduled</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">Check back shortly or view our on-demand short courses catalog.</p>
            </div>
        @endforelse
    </div>

    <!-- Past Webinars & Replays -->
    @if($pastWebinars->isNotEmpty())
        <div class="mt-16 pt-10 border-t border-slate-200">
            <h2 class="text-xl sm:text-2xl font-bold font-serif-title text-slate-900 mb-6">Past Masterclasses & Replays</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pastWebinars as $past)
                    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-xs">
                        <span class="text-[11px] font-semibold text-slate-400 block mb-1">Concluded • {{ $past->starts_at->format('M d, Y') }}</span>
                        <h4 class="text-sm font-bold text-slate-900 line-clamp-2 mb-2">{{ $past->title }}</h4>
                        <div class="text-xs text-slate-600 mb-4">{{ $past->speaker_name }}</div>
                        <a href="{{ route('webinars.show', $past->slug) }}" class="inline-flex items-center gap-1 text-xs font-bold text-purple-600 hover:text-purple-700">
                            <span>View Replay Details</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</section>

@endsection
