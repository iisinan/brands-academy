@extends('layouts.app')

@section('title', 'Submit Portfolio Deliverables - Brands Academy')

@section('content')

<!-- Header -->
<section class="bg-slate-900 text-white py-12 border-b border-slate-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('member.dashboard') }}" class="text-xs text-amber-400 hover:underline block mb-2">&larr; Back to Member Dashboard</a>
        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-400 border border-amber-500/30 mb-2">
            Practical Assessment & Mentorship Gateway
        </span>
        <h1 class="text-2xl sm:text-3xl font-extrabold font-serif-title">
            Submit Portfolio Project: {{ $application->workshop->title }}
        </h1>
        <p class="text-slate-300 text-xs sm:text-sm mt-1 leading-relaxed">
            Brands Academy assesses learners by practical output, strategic deliverables, and portfolio decks rather than examinations alone.
        </p>
    </div>
</section>

<!-- Submission Form -->
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-lg">

        @if($application->portfolioSubmissions->count() > 0)
            <div class="mb-8 p-5 bg-slate-50 rounded-2xl border border-slate-200">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Previous Submissions</h3>
                <div class="space-y-3">
                    @foreach($application->portfolioSubmissions as $sub)
                        <div class="p-4 bg-white rounded-xl border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <span class="font-bold text-slate-900 text-sm block">{{ $sub->title }}</span>
                                <span class="text-xs text-slate-500">Submitted {{ $sub->created_at->format('M d, Y') }}</span>
                                @if($sub->mentor_feedback)
                                    <div class="mt-2 text-xs text-amber-900 bg-amber-50 p-2.5 rounded-lg border border-amber-200">
                                        <strong>Mentor Remarks:</strong> {{ $sub->mentor_feedback }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="inline-block px-2.5 py-1 rounded-full text-xs font-bold border {{ $sub->status_badge['class'] }}">
                                    {{ $sub->status_badge['label'] }}
                                </span>
                                <a href="{{ $sub->deck_url }}" target="_blank" class="text-xs font-bold text-amber-600 hover:underline">
                                    View Deck &rarr;
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <h2 class="text-lg font-bold text-slate-900 mb-2 font-serif-title">New Portfolio Submission</h2>
        <p class="text-xs text-slate-500 mb-6">Provide the link to your slide deck, Figma file, Google Drive folder, or Behance case study.</p>

        <form action="{{ route('member.portfolio.store', $application->id) }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Project Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Comprehensive Brand Strategy & Identity for Zenith Organics" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Portfolio Deck / Presentation URL *</label>
                <input type="url" name="deck_url" value="{{ old('deck_url') }}" required placeholder="https://drive.google.com/..., Figma, or Behance link" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                <span class="block text-[11px] text-slate-400 mt-1">Please ensure link sharing permissions are set to &quot;Anyone with the link can view&quot;.</span>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Strategic Deliverables List (One per line)</label>
                <textarea name="deliverables" rows="3" placeholder="Brand Positioning Matrix&#10;Customer Archetype Analysis&#10;Visual Identity & Style Guide" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-mono focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('deliverables') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Project Summary & Reflection *</label>
                <textarea name="description" rows="4" required placeholder="Describe your methodology, key insights uncovered, and how your strategic solution addresses the client brief..." class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="w-full py-4 px-6 rounded-xl text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md transition-all">
                Submit Portfolio for Faculty & Mentor Evaluation
            </button>
        </form>

    </div>
</section>

@endsection
