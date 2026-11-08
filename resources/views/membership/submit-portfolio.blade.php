@extends('layouts.app')

@section('title', 'Submit Portfolio Deliverables - Brands Academy')

@push('styles')
<style>
    @keyframes checkmarkPop {
        0% { transform: scale(0) rotate(-15deg); opacity: 0; }
        60% { transform: scale(1.2) rotate(4deg); opacity: 1; }
        100% { transform: scale(1) rotate(0deg); opacity: 1; }
    }
    @keyframes strokeCheck {
        0% { stroke-dashoffset: 32; }
        100% { stroke-dashoffset: 0; }
    }
    .anim-check-pop {
        animation: checkmarkPop 0.36s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        transform-origin: center center;
    }
    .anim-check-stroke {
        stroke-dasharray: 32;
        stroke-dashoffset: 32;
        animation: strokeCheck 0.32s cubic-bezier(0.65, 0, 0.45, 1) 0.08s forwards;
    }
    .field-interactive {
        transition: border-color 0.22s ease, box-shadow 0.22s ease, background-color 0.22s ease, transform 0.15s ease;
    }
</style>
@endpush

@section('content')

<!-- Header -->
<section class="bg-slate-900 text-white py-12 sm:py-14 border-b border-slate-800 relative overflow-hidden">
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <a href="{{ route('member.dashboard') }}" class="text-xs text-amber-400 hover:underline inline-flex items-center gap-1 mb-3">
            <span>&larr;</span>
            <span>Back to Member Dashboard</span>
        </a>
        <div class="flex items-center gap-2 mb-2">
            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                Practical Assessment & Mentorship Gateway
            </span>
            <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-800 text-slate-300 border border-slate-700">
                {{ $application->workshop->track_label }}
            </span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold font-serif-title tracking-tight">
            Submit Portfolio: {{ $application->workshop->title }}
        </h1>
        <p class="text-slate-300 text-xs sm:text-sm mt-2 leading-relaxed font-light">
            Brands Academy evaluates learners based on demonstrable strategic outputs, practical decks, and real-world brand deliverables.
        </p>
    </div>
</section>

<!-- Submission Content Area -->
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12"
         x-data="portfolioSubmissionForm()">
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-lg">

        @if($application->portfolioSubmissions->count() > 0)
            <div class="mb-10 p-5 sm:p-6 bg-slate-50 rounded-2xl border border-slate-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Previous Submissions History</h3>
                    <span class="text-xs text-slate-500 font-semibold">{{ $application->portfolioSubmissions->count() }} submission(s)</span>
                </div>
                <div class="space-y-4">
                    @foreach($application->portfolioSubmissions as $sub)
                        <div class="p-4 sm:p-5 bg-white rounded-xl border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-2xs">
                            <div class="space-y-1">
                                <span class="font-bold text-slate-900 text-sm sm:text-base block">{{ $sub->title }}</span>
                                <span class="text-xs text-slate-500 block">Submitted on {{ $sub->created_at->format('M d, Y &bull; h:i A') }}</span>
                                @if($sub->mentor_feedback)
                                    <div class="mt-2 text-xs text-amber-900 bg-amber-50/80 p-3 rounded-xl border border-amber-200/80">
                                        <strong class="text-amber-800">Faculty & Mentor Evaluation:</strong>
                                        <p class="mt-0.5 text-slate-700">{{ $sub->mentor_feedback }}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold border {{ $sub->status_badge['class'] }}">
                                    {{ $sub->status_badge['label'] }}
                                </span>
                                <a href="{{ $sub->deck_url }}" target="_blank" rel="noopener noreferrer" class="px-3.5 py-1.5 rounded-lg text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors flex items-center gap-1">
                                    <span>View Deck</span>
                                    <span>&rarr;</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mb-6">
            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 font-serif-title">New Portfolio Submission</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Submit your final project deliverables, Figma link, Google Drive folder, or Behance presentation for mentor evaluation.</p>
        </div>

        <form action="{{ route('member.portfolio.store', $application->id) }}" method="POST" @submit="isSubmitting = true" class="space-y-6">
            @csrf

            <!-- Project Title -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Project Title *</label>
                    <span x-show="isTitleValid" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                        <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 anim-check-stroke text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <span>Looks great</span>
                    </span>
                </div>
                <input type="text" name="title" x-model="title" required
                       class="w-full px-4 py-3 rounded-xl border text-sm field-interactive focus:outline-none"
                       :class="isTitleValid ? 'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10' : 'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20'"
                       placeholder="e.g. Comprehensive Brand Strategy & Identity Architecture for Zenith Organics">
            </div>

            <!-- Deck URL with platform detection -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Portfolio Deck / Presentation URL *</label>
                    <div class="flex items-center gap-1.5">
                        <span x-show="detectedPlatform" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[10px] font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            <span x-text="detectedPlatform"></span>
                        </span>
                        <span x-show="isUrlValid" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                            <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 flex items-center justify-center">
                                <svg class="w-2.5 h-2.5 anim-check-stroke text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span>Valid Link</span>
                        </span>
                    </div>
                </div>
                <input type="url" name="deck_url" x-model="deckUrl" required
                       class="w-full px-4 py-3 rounded-xl border text-sm field-interactive focus:outline-none font-mono text-xs sm:text-sm"
                       :class="isUrlValid ? 'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10' : 'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20'"
                       placeholder="https://drive.google.com/..., Figma, Behance, or Notion URL">
                <span class="block text-[11px] text-slate-400 mt-1">Please ensure link sharing permissions are set to &quot;Anyone with the link can view&quot;.</span>
            </div>

            <!-- Strategic Deliverables List -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Strategic Deliverables List (One per line)</label>
                    <span class="text-[11px] text-slate-400" x-text="`${deliverablesCount} deliverable(s) listed`"></span>
                </div>
                <textarea name="deliverables" x-model="deliverables" rows="3"
                          placeholder="Brand Positioning Matrix&#10;Customer Archetype Analysis&#10;Visual Identity & Style Guide"
                          class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-mono focus:outline-none focus:ring-2 focus:ring-amber-500"></textarea>
            </div>

            <!-- Project Reflection & Summary -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase">Project Summary & Reflection *</label>
                    <span class="text-[11px] text-slate-400" x-text="`${description.trim().length} characters`"></span>
                </div>
                <textarea name="description" x-model="description" rows="4" required
                          placeholder="Describe your methodology, key market insights uncovered, and how your strategic solution addresses the client or business problem..."
                          class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" :disabled="isSubmitting" class="w-full py-4 px-6 rounded-2xl text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-75">
                <svg x-show="isSubmitting" class="w-4 h-4 animate-spin text-slate-950" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span>Submit Portfolio for Faculty & Mentor Evaluation</span>
            </button>
        </form>

    </div>
</section>

@endsection

@push('scripts')
<script>
    function portfolioSubmissionForm() {
        return {
            title: @js(old('title', '')),
            deckUrl: @js(old('deck_url', '')),
            deliverables: @js(old('deliverables', '')),
            description: @js(old('description', '')),
            isSubmitting: false,

            get isTitleValid() {
                return (this.title || '').trim().length >= 5;
            },

            get isUrlValid() {
                const u = (this.deckUrl || '').trim();
                return u.startsWith('http://') || u.startsWith('https://');
            },

            get detectedPlatform() {
                const u = (this.deckUrl || '').toLowerCase();
                if (u.includes('drive.google.com') || u.includes('docs.google.com')) return 'Google Drive';
                if (u.includes('figma.com')) return 'Figma';
                if (u.includes('behance.net')) return 'Behance';
                if (u.includes('notion.site') || u.includes('notion.so')) return 'Notion';
                if (u.includes('canva.com')) return 'Canva';
                if (u.includes('github.com')) return 'GitHub';
                if (u.includes('dropbox.com')) return 'Dropbox';
                return '';
            },

            get deliverablesCount() {
                if (!this.deliverables) return 0;
                return this.deliverables.split('\n').filter(line => line.trim().length > 0).length;
            }
        };
    }
</script>
@endpush
