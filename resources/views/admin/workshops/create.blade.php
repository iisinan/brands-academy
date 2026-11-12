@extends('layouts.admin')

@section('title', 'Create Workshop Cohort - Admin')
@section('page_title', 'Create Workshop Cohort')

@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.workshops') }}" class="text-xs font-bold text-amber-600 hover:underline block mb-1">&larr; Back to Workshops Directory</a>
            <h1 class="text-2xl font-extrabold text-slate-900 font-serif-title">
                Configure New Certification Cohort
            </h1>
            <p class="text-slate-500 text-xs mt-1">
                Configure curriculum, delivery mode, publication status for the landing page, and time-bound application windows.
            </p>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-sm">
        
        <form action="{{ route('admin.workshops.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Landing Page Visibility & Publication Control -->
            <div class="p-5 rounded-2xl bg-amber-50/70 border border-amber-200 space-y-3">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <h3 class="font-bold text-slate-900 text-xs uppercase tracking-wider">Landing Page Visibility &amp; Status</h3>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Publication Status *</label>
                        <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                            <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>Published (Live on Public Landing Page)</option>
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft (Hidden from Public Landing Page)</option>
                        </select>
                    </div>

                    <div class="flex items-center pt-5 sm:pt-6">
                        <label class="inline-flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="w-4 h-4 rounded text-amber-500 border-slate-300 focus:ring-amber-500">
                            <span class="text-xs font-bold text-slate-800">Pin as Featured Workshop on Landing Page</span>
                        </label>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Cohort Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Certified Brand Associate (CBA) — Cohort 2026-1" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Certification Track *</label>
                    <select name="track_type" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                        <option value="cba">Tier 1: Certified Brand Associate (CBA)</option>
                        <option value="cbs">Tier 2: Certified Brand Strategist (CBS)</option>
                        <option value="cbe">Tier 3: Certified Brand Executive (CBE)</option>
                        <option value="community">Community &amp; Youth Vocational (Free-Access Track)</option>
                        <option value="executive">Executive Masterclass / Retreat</option>
                        <option value="workshop">Specialized Workshop</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Delivery Mode *</label>
                    <select name="delivery_mode" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                        <option value="hybrid">Hybrid (Virtual + In-Person Hub)</option>
                        <option value="online">100% Virtual Live Cohort</option>
                        <option value="in_person">In-Person Learning Center</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Short Tagline</label>
                <input type="text" name="tagline" value="{{ old('tagline') }}" placeholder="Brief summary of the programme's core focus" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Comprehensive Description *</label>
                <textarea name="description" rows="4" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Curriculum Topics (One module per line)</label>
                <textarea name="curriculum_topics" rows="4" placeholder="Module 1: Principles of Brand Architecture&#10;Module 2: Customer Personas &amp; Positioning&#10;Module 3: Portfolio Assessment &amp; Mentorship" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 font-mono text-xs">{{ old('curriculum_topics') }}</textarea>
            </div>

            <!-- Application Window Configuration -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h3 class="font-bold text-slate-900 text-sm">Application Window (Opening &amp; Closing Dates)</h3>
                </div>
                <p class="text-xs text-slate-600">
                    The portal will automatically open and accept applications starting on the Opening Date and lock the form the moment the Deadline passes.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Application Opens At *</label>
                        <input type="datetime-local" name="application_starts_at" value="{{ old('application_starts_at', now()->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Application Deadline *</label>
                        <input type="datetime-local" name="application_deadline" value="{{ old('application_deadline', now()->addDays(14)->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                    </div>
                </div>
            </div>

            <!-- Training Run Dates -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Training Starts At *</label>
                    <input type="datetime-local" name="starts_at" value="{{ old('starts_at', now()->addDays(21)->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Training Ends At *</label>
                    <input type="datetime-local" name="ends_at" value="{{ old('ends_at', now()->addDays(60)->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
            </div>

            <!-- Tuition & Capacity -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tuition Type *</label>
                    <select name="fee_type" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                        <option value="free">100% Free / Sponsored Track</option>
                        <option value="subsidized">Subsidized Foundation Rate</option>
                        <option value="paid">Standard Commercial Rate</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Fee Amount (NGN)</label>
                    <input type="number" step="0.01" name="fee_amount" value="{{ old('fee_amount', 0) }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Cohort Capacity (Seats)</label>
                    <input type="number" name="capacity" value="{{ old('capacity', 40) }}" placeholder="e.g. 50" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Lead Instructor / Faculty</label>
                    <input type="text" name="instructor_name" value="{{ old('instructor_name') }}" placeholder="e.g. Prof. Samaila Mande &amp; Fellows" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Location / Venue</label>
                    <input type="text" name="venue" value="{{ old('venue') }}" placeholder="e.g. Kaduna Center &amp; Zoom Live" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
            </div>

            <button type="submit" class="w-full py-4 px-6 rounded-xl text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md transition-all">
                Publish Workshop &amp; Activate Application Window
            </button>
        </form>

    </div>
</div>

@endsection
