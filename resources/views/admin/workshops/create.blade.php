@extends('layouts.app')

@section('title', 'Create Workshop Cohort - Admin')

@section('content')

<!-- Header -->
<section class="bg-slate-900 text-white py-10 border-b border-slate-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('admin.workshops') }}" class="text-xs text-amber-400 hover:underline block mb-1">&larr; Back to Workshops</a>
        <h1 class="text-2xl sm:text-3xl font-extrabold font-serif-title">
            Configure New Workshop Cohort
        </h1>
        <p class="text-slate-300 text-xs mt-1">Set curriculum, delivery mode, and time-bound application opening & closing windows.</p>
    </div>
</section>

<!-- Form -->
<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-lg">
        
        <form action="{{ route('admin.workshops.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Cohort Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="e.g. Certified Brand Associate (CBA) — Cohort 2025-A" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Certification Track *</label>
                    <select name="track_type" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                        <option value="cba">Tier 1: Certified Brand Associate (CBA)</option>
                        <option value="cbs">Tier 2: Certified Brand Strategist (CBS)</option>
                        <option value="cbe">Tier 3: Certified Brand Executive (CBE)</option>
                        <option value="community">Community & Youth Vocational (Free-Access Track)</option>
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
                <textarea name="curriculum_topics" rows="4" placeholder="Module 1: Principles of Brand Architecture&#10;Module 2: Customer Personas & Positioning&#10;Module 3: Portfolio Assessment & Mentorship" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 font-mono text-xs">{{ old('curriculum_topics') }}</textarea>
            </div>

            <!-- Application Window Configuration -->
            <div class="p-6 rounded-2xl bg-amber-50/70 border border-amber-200 space-y-4">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h3 class="font-bold text-slate-900 text-sm">Application Window (Opening & Closing Dates)</h3>
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
                    <input type="text" name="instructor_name" value="{{ old('instructor_name') }}" placeholder="e.g. Prof. Samaila Mande & Fellows" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Location / Venue</label>
                    <input type="text" name="venue" value="{{ old('venue') }}" placeholder="e.g. Kaduna Center & Zoom Live" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
            </div>

            <button type="submit" class="w-full py-4 px-6 rounded-xl text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md transition-all">
                Publish Workshop & Activate Application Window
            </button>
        </form>

    </div>
</section>

@endsection
