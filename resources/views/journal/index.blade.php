@extends('layouts.app')

@section('title', 'Journal of Brand Strategy & Management (JBSM) | Brands Academy')

@section('content')
<div class="bg-slate-900 text-white py-16 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Peer-Reviewed Open-Access Academic Journal &bull; ISSN Applied
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-serif-title font-extrabold tracking-tight text-white mb-4">
                Journal of Brand Strategy &amp; Management
            </h1>
            <p class="text-base sm:text-lg text-slate-300 leading-relaxed font-light mb-8">
                An international, double-blind peer-reviewed quarterly journal publishing empirical and conceptual contributions in corporate identity, brand valuation, market signaling, and intellectual property governance in emerging economies.
            </p>
            <div class="flex flex-wrap items-center gap-4">
                <a href="{{ route('journal.submit') }}" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-md transition-all">
                    <span>Submit Manuscript for Review</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-8 rounded-r-xl text-xs text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <!-- Current Issue Banner -->
    @if($latestIssue)
        <div class="bg-slate-50 border border-slate-200 rounded-3xl p-6 sm:p-10 mb-12 shadow-2xs">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 mb-2">
                        Current Issue: {{ $latestIssue->issue_citation }}
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-serif-title font-bold text-slate-900">
                        {{ $latestIssue->title ?: 'Current Research & Empirical Findings' }}
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Published on {{ $latestIssue->published_date->format('F d, Y') }} &bull; Open Access Under CC-BY 4.0
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('journal.index', ['issue' => $latestIssue->id]) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-blue-600 text-white font-bold text-xs shadow-xs transition-colors">
                        <span>View Issue Table of Contents &rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Search & Volume Browser -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <!-- Search bar -->
        <form action="{{ route('journal.index') }}" method="GET" class="w-full md:w-96">
            <div class="relative">
                <input type="text" name="q" value="{{ $search }}" placeholder="Search articles, authors, DOIs..." class="w-full text-xs rounded-xl border-slate-200 pl-9 pr-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </form>

        <!-- Archive Filter -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('journal.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors {{ empty($selectedIssue) ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                All Issues
            </a>
            @foreach($volumes as $vol)
                @foreach($vol->issues as $iss)
                    <a href="{{ route('journal.index', ['issue' => $iss->id]) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ $selectedIssue == $iss->id ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Vol. {{ $vol->volume_number }}({{ $iss->issue_number }})
                    </a>
                @endforeach
            @endforeach
        </div>
    </div>

    <!-- Articles List -->
    <div class="space-y-6">
        @forelse($articles as $art)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-2xs hover:shadow-md transition-shadow">
                <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 mb-2">
                    <span class="font-semibold text-blue-600">
                        {{ $art->issue ? $art->issue->issue_citation : 'In Press' }}
                    </span>
                    @if($art->doi)
                        <span>&bull;</span>
                        <span class="font-mono text-slate-400">doi:{{ $art->doi }}</span>
                    @endif
                    @if($art->page_start && $art->page_end)
                        <span>&bull;</span>
                        <span>pp. {{ $art->page_start }}-{{ $art->page_end }}</span>
                    @endif
                </div>

                <h3 class="text-xl sm:text-2xl font-serif-title font-bold text-slate-900 hover:text-blue-600 transition-colors mb-2">
                    <a href="{{ route('journal.show', $art->slug) }}">
                        {{ $art->title }}
                    </a>
                </h3>

                <p class="text-xs font-medium text-slate-700 mb-4">
                    {{ $art->authors_formatted }}
                </p>

                <p class="text-xs text-slate-600 leading-relaxed font-light line-clamp-3 mb-6">
                    {{ $art->abstract }}
                </p>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-4 border-t border-slate-100 text-xs">
                    <div class="flex flex-wrap items-center gap-1.5">
                        @foreach($art->keywords_array as $kw)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-600">
                                {{ $kw }}
                            </span>
                        @endforeach
                    </div>

                    <div class="flex items-center gap-4 shrink-0">
                        <span class="text-slate-400 text-[11px]">{{ $art->views_count }} views &bull; {{ $art->downloads_count }} downloads</span>
                        <a href="{{ route('journal.show', $art->slug) }}" class="inline-flex items-center gap-1 font-bold text-blue-600 hover:underline">
                            <span>Read Article &rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl border border-dashed border-slate-300 p-12 text-center shadow-2xs">
                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-1">No Academic Articles Found</h3>
                <p class="text-xs text-slate-500 max-w-md mx-auto mb-6 leading-relaxed">
                    @if($search || $selectedIssue)
                        No peer-reviewed papers matched your query <span class="font-semibold text-slate-800">"{{ $search ?: 'Selected Volume' }}"</span>. Try searching with broader keywords or browse all volumes.
                    @else
                        No published articles are currently available in this journal archive view.
                    @endif
                </p>
                <div class="flex flex-wrap items-center justify-center gap-3">
                    @if($search || $selectedIssue)
                        <a href="{{ route('journal.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
                            <span>Reset Search &amp; Filters</span>
                        </a>
                    @endif
                    <a href="{{ route('journal.submit') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-xs transition-all">
                        <span>Submit New Manuscript &rarr;</span>
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    @if($articles->hasPages())
        <div class="mt-8">
            {{ $articles->links() }}
        </div>
    @endif
</div>
@endsection
