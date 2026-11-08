@extends('layouts.admin')

@section('title', 'Edit Workshop Cohort - ' . $workshop->title)
@section('page_title', 'Edit Workshop Cohort')

@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.workshops') }}" class="text-xs font-bold text-amber-600 hover:underline block mb-1">&larr; Back to Workshops Directory</a>
            <h1 class="text-2xl font-extrabold text-slate-900 font-serif-title">
                Edit Workshop Cohort
            </h1>
            <p class="text-slate-500 text-xs mt-1">
                Update application window dates, fees, syllabus, or landing page publication status.
            </p>
        </div>

        <a href="{{ route('workshops.show', $workshop->slug) }}" target="_blank" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition-colors">
            View Live Public Page &rarr;
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-sm">
        
        <form action="{{ route('admin.workshops.update', $workshop->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Landing Page Visibility & Publication Control -->
            <div class="p-5 rounded-2xl bg-amber-50/70 border border-amber-200 space-y-3">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <h3 class="font-bold text-slate-900 text-xs uppercase tracking-wider">Landing Page Visibility &amp; Status</h3>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Publication Status *</label>
                        <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                            <option value="published" {{ old('status', $workshop->status) == 'published' ? 'selected' : '' }}>Published (Active on Landing Page)</option>
                            <option value="draft" {{ old('status', $workshop->status) == 'draft' ? 'selected' : '' }}>Draft (Hidden from Public)</option>
                            <option value="archived" {{ old('status', $workshop->status) == 'archived' ? 'selected' : '' }}>Archived (Closed)</option>
                        </select>
                    </div>

                    <div class="flex items-center pt-5 sm:pt-6">
                        <label class="inline-flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $workshop->is_featured) ? 'checked' : '' }} class="w-4 h-4 rounded text-amber-500 border-slate-300 focus:ring-amber-500">
                            <span class="text-xs font-bold text-slate-800">Pin as Featured Workshop on Landing Page</span>
                        </label>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Cohort Title *</label>
                <input type="text" name="title" value="{{ old('title', $workshop->title) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Certification Track *</label>
                    <select name="track_type" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                        <option value="cba" {{ old('track_type', $workshop->track_type) == 'cba' ? 'selected' : '' }}>Tier 1: CBA (Associate)</option>
                        <option value="cbs" {{ old('track_type', $workshop->track_type) == 'cbs' ? 'selected' : '' }}>Tier 2: CBS (Strategist)</option>
                        <option value="cbe" {{ old('track_type', $workshop->track_type) == 'cbe' ? 'selected' : '' }}>Tier 3: CBE (Executive)</option>
                        <option value="community" {{ old('track_type', $workshop->track_type) == 'community' ? 'selected' : '' }}>Community Free-Access</option>
                        <option value="executive" {{ old('track_type', $workshop->track_type) == 'executive' ? 'selected' : '' }}>Executive Masterclass</option>
                        <option value="workshop" {{ old('track_type', $workshop->track_type) == 'workshop' ? 'selected' : '' }}>Specialized Workshop</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Delivery Mode *</label>
                    <select name="delivery_mode" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                        <option value="hybrid" {{ old('delivery_mode', $workshop->delivery_mode) == 'hybrid' ? 'selected' : '' }}>Hybrid (Virtual + In-Person)</option>
                        <option value="online" {{ old('delivery_mode', $workshop->delivery_mode) == 'online' ? 'selected' : '' }}>100% Virtual Cohort</option>
                        <option value="in_person" {{ old('delivery_mode', $workshop->delivery_mode) == 'in_person' ? 'selected' : '' }}>In-Person Learning Center</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Short Tagline</label>
                <input type="text" name="tagline" value="{{ old('tagline', $workshop->tagline) }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Comprehensive Description *</label>
                <textarea name="description" rows="4" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('description', $workshop->description) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Curriculum Topics (One module per line)</label>
                @php
                    $topicsString = is_array($workshop->curriculum_topics) ? implode("\n", $workshop->curriculum_topics) : $workshop->curriculum_topics;
                @endphp
                <textarea name="curriculum_topics" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 font-mono text-xs">{{ old('curriculum_topics', $topicsString) }}</textarea>
            </div>

            <!-- Application Window Configuration -->
            <div class="p-6 rounded-2xl bg-amber-50/70 border border-amber-200 space-y-4">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h3 class="font-bold text-slate-900 text-sm">Application Window (Opening &amp; Closing Dates)</h3>
                </div>
                <p class="text-xs text-slate-600">
                    Adjust the deadline here to extend or close the application window for this cohort.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Application Opens At *</label>
                        <input type="datetime-local" name="application_starts_at" value="{{ old('application_starts_at', $workshop->application_starts_at ? $workshop->application_starts_at->format('Y-m-d\TH:i') : '') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Application Deadline *</label>
                        <input type="datetime-local" name="application_deadline" value="{{ old('application_deadline', $workshop->application_deadline ? $workshop->application_deadline->format('Y-m-d\TH:i') : '') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                    </div>
                </div>
            </div>

            <!-- Training Run Dates -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Training Starts At *</label>
                    <input type="datetime-local" name="starts_at" value="{{ old('starts_at', $workshop->starts_at ? $workshop->starts_at->format('Y-m-d\TH:i') : '') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Training Ends At *</label>
                    <input type="datetime-local" name="ends_at" value="{{ old('ends_at', $workshop->ends_at ? $workshop->ends_at->format('Y-m-d\TH:i') : '') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
            </div>

            <!-- Fee & Venue -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tuition Type *</label>
                    <select name="fee_type" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                        <option value="free" {{ old('fee_type', $workshop->fee_type) == 'free' ? 'selected' : '' }}>Tuition-Free Track</option>
                        <option value="subsidized" {{ old('fee_type', $workshop->fee_type) == 'subsidized' ? 'selected' : '' }}>Subsidized Foundation Rate</option>
                        <option value="paid" {{ old('fee_type', $workshop->fee_type) == 'paid' ? 'selected' : '' }}>Standard Professional Fee</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Fee Amount (NGN)</label>
                    <input type="number" step="0.01" name="fee_amount" value="{{ old('fee_amount', $workshop->fee_amount) }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Participant Capacity</label>
                    <input type="number" name="capacity" value="{{ old('capacity', $workshop->capacity) }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Venue / Platform</label>
                    <input type="text" name="venue" value="{{ old('venue', $workshop->venue) }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Lead Instructor / Faculty</label>
                    <input type="text" name="instructor_name" value="{{ old('instructor_name', $workshop->instructor_name) }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
            </div>

            <div class="pt-6 border-t border-slate-200 flex items-center justify-between">
                <a href="{{ route('admin.workshops') }}" class="px-5 py-3 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3.5 rounded-xl text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md transition-all">
                    Save Changes &amp; Update Window
                </button>
            </div>
        </form>

    </div>
</div>

@endsection
