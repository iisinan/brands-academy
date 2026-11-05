@extends('layouts.app')

@section('title', 'Portfolio Deliverables & Evaluation - Admin')

@section('content')

<!-- Header -->
<section class="bg-slate-900 text-white py-10 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-xs text-amber-400 hover:underline block mb-1">&larr; Admin Dashboard</a>
                <h1 class="text-2xl sm:text-3xl font-extrabold font-serif-title">
                    Portfolio Deliverables & Faculty Evaluation
                </h1>
                <p class="text-slate-300 text-xs mt-1">Review strategic projects, provide mentor feedback, and approve learners for certification.</p>
            </div>
            <a href="{{ route('admin.applications') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white transition-colors">
                Admissions Queue &rarr;
            </a>
        </div>
    </div>
</section>

<!-- Submissions List -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Filter -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs mb-6">
        <form action="{{ route('admin.submissions') }}" method="GET" class="flex flex-wrap items-center gap-3">
            <select name="status" class="px-3 py-2 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                <option value="">All Review Statuses</option>
                <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted (Pending Review)</option>
                <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Mentor Review</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved / Passed</option>
                <option value="revisions_requested" {{ request('status') == 'revisions_requested' ? 'selected' : '' }}>Revisions Requested</option>
            </select>
            <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-900 text-white hover:bg-slate-800 transition-colors">
                Filter
            </button>
            @if(request('status'))
                <a href="{{ route('admin.submissions') }}" class="text-xs font-semibold text-slate-500 hover:underline">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Cards List -->
    <div class="space-y-6">
        @forelse($submissions as $sub)
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs flex flex-col lg:flex-row gap-8 items-start justify-between">
                
                <!-- Left: Submission details -->
                <div class="space-y-4 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $sub->status_badge['class'] }}">
                            {{ $sub->status_badge['label'] }}
                        </span>
                        @if($sub->grade)
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-purple-100 text-purple-800 uppercase">
                                Grade: {{ $sub->grade }}
                            </span>
                        @endif
                        <span class="text-xs text-slate-400">Submitted on {{ $sub->created_at->format('M d, Y') }}</span>
                    </div>

                    <div>
                        <h2 class="text-xl font-bold text-slate-900 leading-snug">
                            {{ $sub->title }}
                        </h2>
                        <div class="text-xs text-slate-500 mt-1">
                            Learner: <strong class="text-slate-800">{{ $sub->application->applicant_name }}</strong> ({{ $sub->application->applicant_email }})
                            @if($sub->member)
                                &bull; <span class="text-amber-700 font-bold">{{ $sub->member->member_number }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="text-xs font-semibold text-amber-800 bg-amber-50 p-2.5 rounded-xl border border-amber-100 inline-block">
                        Programme: {{ $sub->workshop->title }}
                    </div>

                    <div class="text-xs text-slate-700 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <span class="font-bold text-slate-900 block mb-1">Executive Summary:</span>
                        {{ $sub->description }}
                    </div>

                    @if(!empty($sub->deliverables) && is_array($sub->deliverables))
                        <div>
                            <span class="text-xs font-bold text-slate-700 block mb-1.5 uppercase tracking-wider text-[10px]">Key Deliverables:</span>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($sub->deliverables as $deliv)
                                    <span class="inline-block px-2.5 py-1 rounded-lg text-xs bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $deliv }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div>
                        <a href="{{ $sub->deck_url }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors shadow-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            Open Presentation / Deck Link &rarr;
                        </a>
                    </div>
                </div>

                <!-- Right: Mentor / Faculty Evaluation Form -->
                <div class="lg:w-80 w-full bg-slate-50 p-5 rounded-2xl border border-slate-200 shrink-0">
                    <span class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">Faculty / Mentor Grading</span>

                    <form action="{{ route('admin.submissions.evaluate', $sub->id) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Evaluation Decision *</label>
                            <select name="status" required class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-semibold bg-white">
                                <option value="under_review" {{ $sub->status == 'under_review' ? 'selected' : '' }}>Mark Under Review</option>
                                <option value="approved" {{ $sub->status == 'approved' ? 'selected' : '' }}>Approve & Pass (Eligible for Certificate)</option>
                                <option value="revisions_requested" {{ $sub->status == 'revisions_requested' ? 'selected' : '' }}>Request Revisions</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Performance Grade</label>
                            <select name="grade" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-semibold bg-white">
                                <option value="">No Grade Specified</option>
                                <option value="pass" {{ $sub->grade == 'pass' ? 'selected' : '' }}>Pass (Meets Standards)</option>
                                <option value="merit" {{ $sub->grade == 'merit' ? 'selected' : '' }}>Merit (Exceeds Standards)</option>
                                <option value="distinction" {{ $sub->grade == 'distinction' ? 'selected' : '' }}>Distinction (Outstanding Mastery)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Mentor Feedback Remarks *</label>
                            <textarea name="mentor_feedback" rows="3" required placeholder="Constructive remarks on strategic positioning, execution, and areas for improvement..." class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">{{ old('mentor_feedback', $sub->mentor_feedback) }}</textarea>
                        </div>

                        <button type="submit" class="w-full py-2.5 px-4 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white transition-colors">
                            Submit Evaluation
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div class="bg-white rounded-2xl border border-dashed border-slate-300 p-12 text-center text-slate-500 text-xs">
                No portfolio submissions found matching the criteria.
            </div>
        @endforelse

        @if($submissions->hasPages())
            <div class="p-4 bg-white rounded-2xl border border-slate-200">
                {{ $submissions->links() }}
            </div>
        @endif
    </div>

</section>

@endsection
