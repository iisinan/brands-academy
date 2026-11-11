@extends('layouts.admin')

@section('title', 'Journal of Brand Strategy & Management Editorial Desk')

@section('content')
<div class="space-y-8" x-data="{ showVolumeModal: false, showIssueModal: false }">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Journal Editorial Desk (JBSM)</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Double-blind peer review, volume archiving, DOI assignment, and open-access publication.</p>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" @click="showVolumeModal = true" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs shadow-2xs transition-colors">
                <span>+ New Volume</span>
            </button>
            <button type="button" @click="showIssueModal = true" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition-colors">
                <span>+ New Issue</span>
            </button>
            <a href="{{ route('journal.index') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-blue-600 transition-colors">
                <span>Public Journal &rarr;</span>
            </a>
        </div>
    </div>

    <!-- Metric Counters -->
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Papers</span>
            <span class="text-2xl font-black text-slate-900">{{ $stats['total_papers'] }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider block mb-1">Submitted</span>
            <span class="text-2xl font-black text-blue-600">{{ $stats['submitted'] }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-bold text-amber-600 uppercase tracking-wider block mb-1">Under Peer Review</span>
            <span class="text-2xl font-black text-amber-600">{{ $stats['under_review'] }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider block mb-1">Published</span>
            <span class="text-2xl font-black text-emerald-600">{{ $stats['published'] }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Volumes &amp; Issues</span>
            <span class="text-2xl font-black text-slate-900">{{ $stats['volumes_count'] }}v / {{ $stats['issues_count'] }}i</span>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl text-xs text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <!-- Manuscripts Editorial Queue -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">Manuscripts Editorial Review Queue ({{ $articles->total() }})</h3>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($articles as $article)
                <div class="p-6 sm:p-8 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1 text-xs text-slate-500">
                                <span class="font-bold text-slate-800">{{ $article->authors_formatted ?: 'Primary Author' }}</span>
                                @if($article->issue)
                                    <span>&bull;</span>
                                    <span class="text-blue-600 font-semibold">{{ $article->issue->issue_citation }}</span>
                                @endif
                                @if($article->doi)
                                    <span>&bull;</span>
                                    <span class="font-mono text-slate-400">doi:{{ $article->doi }}</span>
                                @endif
                            </div>
                            <h4 class="text-lg font-serif-title font-bold text-slate-900">{{ $article->title }}</h4>
                            <p class="text-xs text-slate-600 line-clamp-2 mt-1 font-light">{{ $article->abstract }}</p>
                        </div>

                        <div>
                            @php
                                $badge = match($article->submission_status) {
                                    'published' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                    'accepted' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'under_review' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'revision_required' => 'bg-purple-50 text-purple-700 border-purple-200',
                                    default => 'bg-slate-100 text-slate-700 border-slate-200',
                                };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badge }}">
                                {{ ucfirst(str_replace('_', ' ', $article->submission_status)) }}
                            </span>
                        </div>
                    </div>

                    <!-- Editorial Action & Publication Form -->
                    <form action="{{ route('admin.journal.articles.update', $article->id) }}" method="POST" class="bg-slate-50 p-4 rounded-xl border border-slate-200 flex flex-wrap items-center gap-3 text-xs">
                        @csrf
                        <div class="w-40">
                            <select name="submission_status" class="w-full text-xs rounded-lg border-slate-300">
                                <option value="submitted" {{ $article->submission_status === 'submitted' ? 'selected' : '' }}>Submitted (Screening)</option>
                                <option value="under_review" {{ $article->submission_status === 'under_review' ? 'selected' : '' }}>Under Peer Review</option>
                                <option value="revision_required" {{ $article->submission_status === 'revision_required' ? 'selected' : '' }}>Revisions Required</option>
                                <option value="accepted" {{ $article->submission_status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="published" {{ $article->submission_status === 'published' ? 'selected' : '' }}>Published (Live)</option>
                                <option value="declined" {{ $article->submission_status === 'declined' ? 'selected' : '' }}>Declined</option>
                            </select>
                        </div>

                        <div class="w-48">
                            <select name="issue_id" class="w-full text-xs rounded-lg border-slate-300">
                                <option value="">Assign Issue...</option>
                                @foreach($volumes as $v)
                                    @foreach($v->issues as $i)
                                        <option value="{{ $i->id }}" {{ $article->issue_id == $i->id ? 'selected' : '' }}>
                                            Vol. {{ $v->volume_number }} No. {{ $i->issue_number }} ({{ $i->published_date->format('Y') }})
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div class="w-36">
                            <input type="text" name="doi" value="{{ $article->doi }}" placeholder="DOI (e.g. 10.5281/...)" class="w-full text-xs rounded-lg border-slate-300 font-mono">
                        </div>

                        <div class="w-20">
                            <input type="number" name="page_start" value="{{ $article->page_start }}" placeholder="Start" class="w-full text-xs rounded-lg border-slate-300">
                        </div>

                        <div class="w-20">
                            <input type="number" name="page_end" value="{{ $article->page_end }}" placeholder="End" class="w-full text-xs rounded-lg border-slate-300">
                        </div>

                        <button type="submit" class="px-4 py-2 rounded-lg bg-slate-900 hover:bg-blue-600 text-white font-bold text-xs transition-colors">
                            Update
                        </button>

                        @if($article->manuscript_pdf_path)
                            <a href="{{ asset('storage/' . $article->manuscript_pdf_path) }}" target="_blank" class="inline-flex items-center gap-1 font-bold text-blue-600 hover:underline ml-auto">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span>PDF</span>
                            </a>
                        @endif
                    </form>
                </div>
            @empty
                <div class="p-12 text-center text-slate-400 text-xs">
                    No manuscripts currently submitted to the editorial desk.
                </div>
            @endforelse
        </div>

        @if($articles->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $articles->links() }}
            </div>
        @endif
    </div>

    <!-- Volume Modal -->
    <div x-show="showVolumeModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl relative" @click.away="showVolumeModal = false">
            <h3 class="text-base font-bold text-slate-900 mb-4">Create Journal Volume</h3>
            <form action="{{ route('admin.journal.volumes.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Volume Number *</label>
                    <input type="number" name="volume_number" value="{{ ($stats['volumes_count'] ?? 0) + 1 }}" required class="w-full text-xs rounded-xl border-slate-300">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Year *</label>
                    <input type="number" name="year" value="{{ date('Y') }}" required class="w-full text-xs rounded-xl border-slate-300">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Title (Optional)</label>
                    <input type="text" name="title" placeholder="e.g. Volume 1 (2026)" class="w-full text-xs rounded-xl border-slate-300">
                </div>
                <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                    <button type="button" @click="showVolumeModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 text-white font-bold text-xs">Create Volume</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Issue Modal -->
    <div x-show="showIssueModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl relative" @click.away="showIssueModal = false">
            <h3 class="text-base font-bold text-slate-900 mb-4">Create Issue inside Volume</h3>
            <form action="{{ route('admin.journal.issues.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Select Volume *</label>
                    <select name="volume_id" required class="w-full text-xs rounded-xl border-slate-300">
                        @foreach($volumes as $v)
                            <option value="{{ $v->id }}">Volume {{ $v->volume_number }} ({{ $v->year }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Issue Number *</label>
                    <input type="number" name="issue_number" value="1" required class="w-full text-xs rounded-xl border-slate-300">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Issue Title (Optional)</label>
                    <input type="text" name="title" placeholder="e.g. Special Issue on African Brand Equity" class="w-full text-xs rounded-xl border-slate-300">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Publication Date *</label>
                    <input type="date" name="published_date" value="{{ date('Y-m-d') }}" required class="w-full text-xs rounded-xl border-slate-300">
                </div>
                <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                    <button type="button" @click="showIssueModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 text-white font-bold text-xs">Create Issue</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
