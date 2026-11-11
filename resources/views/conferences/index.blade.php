@extends('layouts.app')

@section('title', 'Annual Conferences & Brand Summits | Brands Academy')

@section('content')
<div class="bg-slate-900 text-white py-16 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20 mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Pan-African Brand Leadership Summits
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-white mb-4">
                Academic Conferences & Brand Leadership Summits
            </h1>
            <p class="text-base sm:text-lg text-slate-300 leading-relaxed font-light">
                Convening global brand scholars, C-suite executives, and regulatory custodians to shape corporate identity, brand valuation, and market policy across African economies.
            </p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Upcoming Summits -->
    <div class="mb-16">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Upcoming Summits & Assemblies</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Confirmed dates, plenary sessions, and call for papers.</p>
            </div>
        </div>

        @if($upcoming->isEmpty())
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-xs">
                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-1">No Upcoming Summits Announced</h3>
                <p class="text-xs text-slate-500">The 2026 Nigeria Brand Leadership Summit schedule will be published shortly.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($upcoming as $conf)
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-xl transition-all flex flex-col justify-between group">
                        <div class="p-6 sm:p-8">
                            <div class="flex items-center justify-between gap-2 mb-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                    Annual Summit {{ $conf->year }}
                                </span>
                                <span class="text-xs text-slate-500 font-medium">
                                    {{ $conf->starts_at->format('M d') }} - {{ $conf->ends_at->format('M d, Y') }}
                                </span>
                            </div>

                            <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 group-hover:text-amber-600 transition-colors mb-2">
                                <a href="{{ route('conferences.show', $conf->slug) }}">
                                    {{ $conf->title }}
                                </a>
                            </h3>

                            @if($conf->theme)
                                <p class="text-xs font-semibold text-blue-700 mb-4 bg-blue-50/70 p-2.5 rounded-lg border border-blue-100">
                                    Theme: "{{ $conf->theme }}"
                                </p>
                            @endif

                            <p class="text-xs text-slate-600 leading-relaxed mb-6 font-light line-clamp-3">
                                {{ $conf->description }}
                            </p>

                            <div class="flex items-center gap-4 text-xs text-slate-500 pt-4 border-t border-slate-100">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span>{{ $conf->venue ?: 'Abuja / Hybrid Plenary' }}</span>
                                </div>
                                @if($conf->cfp_open)
                                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                        Call For Papers Open
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="p-6 sm:p-8 pt-0 flex items-center justify-between gap-4 border-t border-slate-100/80 mt-4">
                            <div>
                                <span class="text-[10px] text-slate-400 block uppercase font-bold tracking-wider">Delegate Passes From</span>
                                <span class="text-base sm:text-lg font-black text-slate-900">
                                    ₦{{ number_format($conf->getLowestPriceFor(auth()->user()), 0) }}
                                </span>
                                @auth
                                    @if(auth()->user()->member?->isPaid())
                                        <span class="text-[10px] text-emerald-600 font-bold ml-1">(25% Member Rate)</span>
                                    @endif
                                @endauth
                            </div>

                            <a href="{{ route('conferences.show', $conf->slug) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-amber-500 hover:text-slate-950 text-white font-bold text-xs shadow-xs transition-all">
                                <span>Register &amp; Syllabus &rarr;</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Past Summits & Proceedings -->
    @if($past->isNotEmpty())
        <div>
            <h3 class="text-xl font-bold text-slate-900 mb-6">Summit Archive & Past Proceedings</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($past as $p)
                    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-2xs">
                        <span class="text-xs font-mono text-slate-400 block mb-1">{{ $p->year }}</span>
                        <h4 class="text-sm font-bold text-slate-900 mb-1">{{ $p->title }}</h4>
                        <p class="text-xs text-slate-500 line-clamp-2 mb-3">{{ $p->theme }}</p>
                        <a href="{{ route('conferences.show', $p->slug) }}" class="text-xs font-bold text-blue-600 hover:underline">
                            View Proceedings &rarr;
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
