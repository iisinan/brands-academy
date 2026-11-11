@extends('layouts.app')

@section('title', 'Submit Manuscript | Journal of Brand Strategy & Management')

@section('content')
<div class="bg-slate-900 text-white py-12 border-b border-slate-800">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('journal.index') }}" class="text-xs text-amber-400 hover:underline flex items-center gap-1 mb-2 font-medium">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Journal Archive
        </a>
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20 mb-3">
            Editorial Submission Portal
        </div>
        <h1 class="text-2xl sm:text-3xl font-serif-title font-bold text-white tracking-tight">
            Submit Manuscript for Double-Blind Peer Review
        </h1>
        <p class="text-xs sm:text-sm text-slate-300 mt-1 font-light">
            Empirical research papers, theoretical commentaries, and case analyses in branding and intangible asset management.
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

    <form action="{{ route('journal.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-6">
        @csrf

        <div>
            <label class="block text-xs font-bold text-slate-800 mb-1">Article Title *</label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Assessing the Impact of Brand Valuation on Equity Capital Cost in Emerging Markets" class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-800 mb-1">Structured Abstract (200 - 400 words) *</label>
            <p class="text-[11px] text-slate-400 mb-2">Outline Purpose, Methodology, Findings, and Managerial Implications.</p>
            <textarea name="abstract" rows="6" required placeholder="Type or paste your academic abstract here..." class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500">{{ old('abstract') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-800 mb-1">Keywords (Comma-separated) *</label>
            <input type="text" name="keywords" value="{{ old('keywords') }}" required placeholder="e.g. Brand Valuation, Corporate Reputation, African Markets, Intangible Capital" class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500">
        </div>

        <div class="pt-4 border-t border-slate-100">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-4">Corresponding / Primary Author</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-[11px] font-semibold text-slate-700 mb-1">Full Name *</label>
                    <input type="text" name="primary_author_name" value="{{ old('primary_author_name', auth()->user()?->name) }}" required class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-700 mb-1">Email Address *</label>
                    <input type="email" name="primary_author_email" value="{{ old('primary_author_email', auth()->user()?->email) }}" required class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-semibold text-slate-700 mb-1">Institutional Affiliation *</label>
                    <input type="text" name="primary_author_affiliation" value="{{ old('primary_author_affiliation') }}" required placeholder="e.g. Lagos Business School, Pan-Atlantic University" class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-slate-700 mb-1">ORCID iD (Optional)</label>
                    <input type="text" name="primary_author_orcid" value="{{ old('primary_author_orcid') }}" placeholder="0000-0002-xxxx-xxxx" class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100">
            <label class="block text-xs font-bold text-slate-800 mb-1">Additional Co-Authors (Optional)</label>
            <p class="text-[11px] text-slate-400 mb-2">Enter each co-author on a separate line formatted as: <span class="font-mono">Full Name | Institution | Email</span></p>
            <textarea name="coauthors" rows="3" placeholder="Prof. Emeka Okafor | University of Abuja | emeka@uniabuja.edu.ng&#10;Dr. Amina Yusuf | Ahmadu Bello University | amina@abu.edu.ng" class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500">{{ old('coauthors') }}</textarea>
        </div>

        <div class="p-4 rounded-xl border border-dashed border-slate-300 bg-slate-50">
            <label class="block text-xs font-bold text-slate-800 mb-1">Upload Manuscript PDF *</label>
            <p class="text-[11px] text-slate-500 mb-2">Ensure the uploaded manuscript follows APA 7th style formatting.</p>
            <input type="file" name="manuscript_pdf" required accept=".pdf" class="text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
            <p class="text-[11px] text-slate-400">Accepted articles are assigned DOIs and indexed under CC-BY 4.0.</p>
            <button type="submit" class="px-6 py-3 rounded-xl bg-slate-900 hover:bg-amber-500 hover:text-slate-950 text-white font-bold text-xs shadow-xs transition-colors">
                Submit Manuscript to JBSM &rarr;
            </button>
        </div>
    </form>
</div>
@endsection
