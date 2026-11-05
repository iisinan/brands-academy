@extends('layouts.app')

@section('title', 'Workshops & Certification Cohorts - Application Periods')

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

    <!-- Filters -->
    <div class="flex flex-wrap items-center gap-2 mb-8 border-b border-slate-200 pb-4">
        <a href="{{ route('workshops.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $statusFilter == 'all' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
            All Programmes ({{ $counts['all'] }})
        </a>
        <a href="{{ route('workshops.index', ['status' => 'open']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $statusFilter == 'open' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white text-emerald-800 hover:bg-emerald-50 border border-emerald-200' }}">
            Applications Open Now ({{ $counts['open'] }})
        </a>
        <a href="{{ route('workshops.index', ['status' => 'upcoming']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $statusFilter == 'upcoming' ? 'bg-amber-600 text-white shadow-xs' : 'bg-white text-amber-800 hover:bg-amber-50 border border-amber-200' }}">
            Opening Soon ({{ $counts['upcoming'] }})
        </a>
        <a href="{{ route('workshops.index', ['status' => 'closed']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $statusFilter == 'closed' ? 'bg-slate-700 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
            Applications Closed ({{ $counts['closed'] }})
        </a>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($workshops as $workshop)
            @php $window = $workshop->application_window_status; @endphp
            <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between shadow-xs hover:shadow-md transition-all group">
                <div>
                    <!-- Top Window Banner -->
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $window['badge_class'] }}">
                            {{ $window['label'] }}
                        </span>
                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            {{ $workshop->delivery_mode }}
                        </span>
                    </div>

                    <h2 class="text-xl font-bold text-slate-900 group-hover:text-amber-600 transition-colors mb-2 leading-snug">
                        <a href="{{ route('workshops.show', $workshop->slug) }}">
                            {{ $workshop->title }}
                        </a>
                    </h2>

                    <div class="text-xs font-bold text-amber-700 mb-3">
                        {{ $workshop->track_label }}
                    </div>

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
                        <span class="block text-[10px] uppercase font-bold text-slate-400">Tuition</span>
                        <span class="font-extrabold text-sm {{ $workshop->fee_type == 'free' ? 'text-emerald-700' : 'text-slate-900' }}">
                            {{ $workshop->fee_type == 'free' ? '100% Free Track' : 'NGN ' . number_format($workshop->fee_amount) }}
                        </span>
                    </div>

                    <a href="{{ route('workshops.show', $workshop->slug) }}" class="inline-flex items-center px-4 py-2.5 rounded-xl text-xs font-bold {{ $window['state'] == 'open' ? 'bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-xs' : 'bg-slate-900 hover:bg-slate-800 text-white' }} transition-colors">
                        {{ $window['state'] == 'open' ? 'Apply Now' : 'View Details' }}
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16 bg-white rounded-2xl border border-dashed border-slate-300">
                <svg class="w-10 h-10 text-slate-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-slate-700 font-bold mb-1">No programmes match this filter</p>
                <p class="text-slate-500 text-xs">Try selecting 'All Programmes' to view active and upcoming cohorts.</p>
            </div>
        @endforelse
    </div>

</section>

@endsection
