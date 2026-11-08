@extends('layouts.admin')

@section('title', 'Admissions Queue & Cohort Applications - Admin')
@section('page_title', 'Admissions Queue & Cohort Applications')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header Actions Strip -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-serif-title">
                    Cohort Admissions &amp; Applications
                </h1>
            </div>
            <p class="text-xs text-slate-500 mt-1">
                Review candidate statements of purpose, evaluate admission status, and dispatch verified certificates.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.workshops') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                &larr; Workshops
            </a>
            <a href="{{ route('admin.certificates') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors shadow-xs">
                Issued Certificates Registry &rarr;
            </a>
        </div>
    </div>
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs mb-6">
        <form action="{{ route('admin.applications') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <select name="workshop_id" class="px-3 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white flex-1">
                <option value="">All Cohorts / Workshops</option>
                @foreach($workshops as $ws)
                    <option value="{{ $ws->id }}" {{ request('workshop_id') == $ws->id ? 'selected' : '' }}>{{ $ws->title }}</option>
                @endforeach
            </select>

            <select name="status" class="px-3 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Review</option>
                <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                <option value="waitlisted" {{ request('status') == 'waitlisted' ? 'selected' : '' }}>Waitlisted</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Not Selected</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Graduated / Certificate Issued</option>
            </select>

            <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white transition-colors">
                Filter Admissions
            </button>
            @if(request()->hasAny(['workshop_id', 'status']))
                <a href="{{ route('admin.applications') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 transition-colors text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Applications List -->
    <div class="space-y-4">
        @forelse($applications as $app)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                
                <!-- Left: Candidate Details & Goals -->
                <div class="space-y-3 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $app->status_badge['class'] }}">
                            {{ $app->status_badge['label'] }}
                        </span>
                        @if($app->scholarship_requested)
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                Scholarship / Subsidy Requested
                            </span>
                        @endif
                        <span class="text-xs text-slate-400">Applied on {{ $app->created_at->format('M d, Y \a\t h:i A') }}</span>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-slate-900 leading-snug">
                            {{ $app->applicant_name }}
                        </h3>
                        <div class="text-xs text-slate-500 flex flex-wrap items-center gap-x-3 gap-y-1 mt-0.5">
                            <span><strong>Email:</strong> {{ $app->applicant_email }}</span>
                            <span>&bull;</span>
                            <span><strong>Phone:</strong> {{ $app->applicant_phone }}</span>
                            @if($app->applicant_organization)
                                <span>&bull;</span>
                                <span><strong>Org:</strong> {{ $app->applicant_organization }}</span>
                            @endif
                            @if($app->member)
                                <span>&bull;</span>
                                <span class="text-amber-700 font-bold">Member ID: {{ $app->member->member_number }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="text-xs font-semibold text-amber-800 bg-amber-50/60 p-2.5 rounded-lg border border-amber-100 inline-block">
                        Cohort: {{ $app->workshop->title }} ({{ $app->workshop->track_label }})
                    </div>

                    @if($app->statement_of_purpose)
                        <div class="text-xs text-slate-700 bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="font-bold text-slate-900 block mb-0.5">Statement of Purpose:</span>
                            {{ $app->statement_of_purpose }}
                        </div>
                    @endif

                    @if($app->scholarship_reason)
                        <div class="text-xs text-amber-900 bg-amber-50/80 p-3 rounded-xl border border-amber-200">
                            <span class="font-bold text-amber-900 block mb-0.5">Subsidy Need:</span>
                            {{ $app->scholarship_reason }}
                        </div>
                    @endif

                    @if($app->portfolio_link)
                        <div class="text-xs">
                            <strong class="text-slate-600">Portfolio URL:</strong>
                            <a href="{{ $app->portfolio_link }}" target="_blank" class="text-amber-600 hover:underline font-mono ml-1">
                                {{ $app->portfolio_link }} &rarr;
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Right: Action Buttons -->
                <div class="lg:w-72 bg-slate-50 p-4 rounded-xl border border-slate-200 shrink-0 space-y-3">
                    <span class="block text-[10px] uppercase font-bold text-slate-400">Admissions Actions</span>
                    
                    <!-- Status Form -->
                    <form action="{{ route('admin.applications.status', $app->id) }}" method="POST" class="space-y-2">
                        @csrf
                        <select name="status" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-300 text-xs font-semibold bg-white">
                            <option value="pending" {{ $app->status == 'pending' ? 'selected' : '' }}>Pending Review</option>
                            <option value="accepted" {{ $app->status == 'accepted' ? 'selected' : '' }}>Accept Candidate</option>
                            <option value="waitlisted" {{ $app->status == 'waitlisted' ? 'selected' : '' }}>Waitlist Candidate</option>
                            <option value="rejected" {{ $app->status == 'rejected' ? 'selected' : '' }}>Decline Application</option>
                            <option value="completed" {{ $app->status == 'completed' ? 'selected' : '' }}>Completed / Graduated</option>
                        </select>
                        <button type="submit" class="w-full py-1.5 px-3 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors">
                            Update Status
                        </button>
                    </form>

                    <!-- Issue Certificate Button (Post-Workshop) -->
                    <div class="pt-2 border-t border-slate-200">
                        @if($app->certificate)
                            <div class="space-y-1.5 text-center">
                                <span class="text-[10px] font-bold text-emerald-700 block">
                                    &check; Certificate Generated
                                </span>
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('certificates.preview', $app->certificate->verification_token) }}" target="_blank" class="px-2.5 py-1 rounded bg-slate-200 hover:bg-slate-300 text-slate-800 text-[10px] font-bold">
                                        Preview PDF
                                    </a>
                                    <form action="{{ route('admin.certificates.email', $app->certificate->verification_token) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1 rounded bg-amber-500 hover:bg-amber-400 text-slate-950 text-[10px] font-bold">
                                            Resend Email
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <form action="{{ route('admin.applications.issue-certificate', $app->id) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Generate certificate PDF and dispatch email to {{ $app->applicant_email }}?')" class="w-full py-2 px-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-xs transition-colors flex items-center justify-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    Issue & Email Certificate
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

            </div>
        @empty
            <div class="bg-white rounded-2xl border border-dashed border-slate-300 p-12 text-center text-slate-500">
                No applications found matching your criteria.
            </div>
        @endforelse

        @if($applications->hasPages())
            <div class="p-4 bg-white rounded-2xl border border-slate-200">
                {{ $applications->links() }}
            </div>
        @endif
    </div>

</div>

@endsection
