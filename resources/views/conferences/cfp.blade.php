@extends('layouts.app')

@section('title', 'Call For Papers - ' . $conference->title . ' | Brands Academy')

@section('content')
<div class="bg-slate-900 text-white py-12 border-b border-slate-800">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('conferences.show', $conference->slug) }}" class="text-xs text-amber-400 hover:underline flex items-center gap-1 mb-2 font-medium">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to {{ $conference->title }}
        </a>
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 mb-3">
            Scientific Review Committee
        </div>
        <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
            Call For Papers &amp; Academic Abstracts
        </h1>
        <p class="text-xs sm:text-sm text-slate-300 mt-1 font-light">
            Theme: "{{ $conference->theme ?: 'Brand Strategy, Governance and African Market Leadership' }}"
        </p>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if ($errors->any())
        <div class="bg-rose-50 border-l-4 border-rose-500 p-4 mb-8 rounded-r-xl">
            <ul class="list-disc list-inside text-xs text-rose-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('conferences.cfp.submit', $conference->slug) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-6">
        @csrf

        <div>
            <label class="block text-xs font-bold text-slate-800 mb-1">Paper / Abstract Title *</label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Empirical Assessment of Brand Valuation Frameworks in Nigerian Commercial Banking" class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-800 mb-1">Primary Author Name *</label>
                <input type="text" name="author_name" value="{{ old('author_name', auth()->user()?->name) }}" required class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-800 mb-1">Corresponding Email *</label>
                <input type="email" name="author_email" value="{{ old('author_email', auth()->user()?->email) }}" required class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-800 mb-1">Institutional Affiliation *</label>
            <input type="text" name="author_institution" value="{{ old('author_institution') }}" required placeholder="e.g. University of Lagos, Department of Marketing" class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-800 mb-1">Structured Abstract (200 - 500 words) *</label>
            <p class="text-[11px] text-slate-400 mb-2">Include Background, Methodology, Key Findings, and Practical / Policy Implications.</p>
            <textarea name="abstract_text" rows="6" required placeholder="Type or paste your conference abstract here..." class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500">{{ old('abstract_text') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-800 mb-1">Keywords (Comma-separated)</label>
            <input type="text" name="keywords" value="{{ old('keywords') }}" placeholder="e.g. Brand Valuation, Intangible Assets, Banking, Africa" class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500">
        </div>

        <div class="p-4 rounded-xl border border-dashed border-slate-300 bg-slate-50">
            <label class="block text-xs font-bold text-slate-800 mb-1">Full Manuscript (Optional, PDF only)</label>
            <p class="text-[11px] text-slate-500 mb-2">Accepted papers will be considered for fast-track publication in the Journal of Brand Strategy & Management (JBSM).</p>
            <input type="file" name="manuscript_pdf" accept=".pdf" class="text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <p class="text-[11px] text-slate-400">All submissions undergo double-blind review by the Scientific Editorial Board.</p>
            <button type="submit" class="px-6 py-3 rounded-xl bg-slate-900 hover:bg-amber-500 hover:text-slate-950 text-white font-bold text-xs shadow-xs transition-colors">
                Submit Abstract &rarr;
            </button>
        </div>
    </form>
</div>
@endsection
