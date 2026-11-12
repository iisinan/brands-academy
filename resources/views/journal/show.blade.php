@extends(auth()->check() && auth()->user()->member ? 'layouts.member' : 'layouts.app')

@section('title', $article->title . ' | NJBSM')
@section('page_title', $article->title)
@section('meta_description', Str::limit(strip_tags($article->abstract), 160))
@section('og_type', 'article')

@section('content')
<div class="bg-slate-900 text-white py-12 border-b border-slate-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('journal.index') }}" class="text-xs text-amber-400 hover:underline flex items-center gap-1 mb-4 font-medium">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Nigerian Journal of Brand Strategy &amp; Management Archive
        </a>

        <div class="flex flex-wrap items-center gap-3 text-xs text-slate-400 mb-3">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                Open Access (CC-BY 4.0)
            </span>
            <span>&bull;</span>
            <span class="text-slate-300 font-medium">
                {{ $article->issue ? $article->issue->issue_citation : 'Online First / In Press' }}
            </span>
            @if($article->doi)
                <span>&bull;</span>
                <span class="font-mono text-amber-400">doi:{{ $article->doi }}</span>
            @endif
        </div>

        <h1 class="text-2xl sm:text-3xl md:text-4xl font-serif-title font-bold text-white tracking-tight leading-snug mb-6">
            {{ $article->title }}
        </h1>

        <!-- Authors & Affiliations -->
        <div class="space-y-2 pt-4 border-t border-slate-800">
            @foreach($article->authors as $author)
                <div class="flex flex-wrap items-center gap-2 text-xs">
                    <span class="font-bold text-white">{{ $author->full_name }}</span>
                    <span class="text-slate-400">({{ $author->affiliation }})</span>
                    @if($author->orcid_id)
                        <span class="font-mono text-[11px] text-emerald-400">ORCID: {{ $author->orcid_id }}</span>
                    @endif
                    @if($author->is_corresponding)
                        <span class="text-[10px] text-amber-400 font-bold bg-amber-500/10 px-1.5 py-0.2 rounded border border-amber-500/20">Corresponding Author</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Action Bar: Download PDF & Citation -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-10">
        <div class="flex items-center gap-4 text-xs text-slate-500">
            <span><strong>{{ $article->views_count }}</strong> Views</span>
            <span>&bull;</span>
            <span><strong>{{ $article->downloads_count }}</strong> Downloads</span>
            <span>&bull;</span>
            <span>Peer Reviewed</span>
        </div>

        <div class="flex items-center gap-3">
            @if($article->manuscript_pdf_path)
                <a href="{{ route('journal.download', $article->slug) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <span>Download PDF</span>
                </a>
            @endif
            <a href="#citation-box" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs transition-colors">
                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                <span>Cite Article</span>
            </a>
        </div>
    </div>

    <!-- Abstract -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-10 shadow-xs mb-10">
        <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4">Abstract</h2>
        <div class="text-slate-700 leading-relaxed text-sm font-light space-y-4 mb-8">
            {{ $article->abstract }}
        </div>

        <div class="pt-6 border-t border-slate-100">
            <h4 class="text-xs font-bold text-slate-900 mb-2">Keywords</h4>
            <div class="flex flex-wrap items-center gap-2">
                @foreach($article->keywords_array as $kw)
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                        {{ $kw }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Citation Box (Interactive) -->
    <div id="citation-box" class="bg-slate-50 border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-2xs mb-12" x-data="{ tab: 'apa', copied: false }">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-bold text-slate-900">Cite this Article</h3>
            <div class="flex items-center gap-2 text-xs">
                <button type="button" @click="tab = 'apa'" :class="tab === 'apa' ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 border border-slate-200'" class="px-3 py-1 rounded-lg font-bold transition-colors">
                    APA 7th
                </button>
                <button type="button" @click="tab = 'harvard'" :class="tab === 'harvard' ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 border border-slate-200'" class="px-3 py-1 rounded-lg font-bold transition-colors">
                    Harvard
                </button>
                <button type="button" @click="tab = 'bibtex'" :class="tab === 'bibtex' ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 border border-slate-200'" class="px-3 py-1 rounded-lg font-bold transition-colors">
                    BibTeX
                </button>
            </div>
        </div>

        <div class="bg-white p-4 rounded-xl border border-slate-200 text-xs font-mono text-slate-800 leading-relaxed mb-4">
            <template x-if="tab === 'apa'">
                <p id="cite-apa">{{ $article->generateApaCitation() }}</p>
            </template>
            <template x-if="tab === 'harvard'">
                <p id="cite-harvard">{{ $article->generateHarvardCitation() }}</p>
            </template>
            <template x-if="tab === 'bibtex'">
                <pre id="cite-bibtex" class="whitespace-pre-wrap">{{ $article->generateBibtexCitation() }}</pre>
            </template>
        </div>

        <button type="button" @click="navigator.clipboard.writeText(tab === 'apa' ? document.getElementById('cite-apa').innerText : (tab === 'harvard' ? document.getElementById('cite-harvard').innerText : document.getElementById('cite-bibtex').innerText)); copied = true; setTimeout(() => copied = false, 2000)" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-900 hover:bg-blue-600 text-white font-bold text-xs transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
            <span x-text="copied ? 'Citation Copied!' : 'Copy Citation to Clipboard'"></span>
        </button>
    </div>
</div>
@endsection
