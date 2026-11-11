@extends('layouts.admin')

@section('title', 'Create New Course - LMS Studio')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-2 text-xs text-slate-500">
        <a href="{{ route('admin.lms.courses') }}" class="hover:text-slate-800">LMS Courses</a>
        <span>/</span>
        <span class="text-slate-800 font-semibold">New Course</span>
    </div>

    <div>
        <h1 class="text-2xl font-bold font-serif-title text-slate-900">Create New Course</h1>
        <p class="text-xs text-slate-500 mt-0.5">Define course parameters and video delivery mode. You can build the modules, lessons, and quizzes in the next step.</p>
    </div>

    <form method="POST" action="{{ route('admin.lms.courses.store') }}" class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 space-y-6 shadow-xs">
        @csrf

        <div class="space-y-4">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 pb-2 border-b border-slate-100">Course Fundamentals</h3>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Course Title *</label>
                <input type="text" name="title" required value="{{ old('title') }}" placeholder="e.g. Strategic Brand Architecture & Governance" class="w-full text-xs border border-slate-300 rounded-xl p-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Course Code (Optional)</label>
                    <input type="text" name="code" value="{{ old('code') }}" placeholder="e.g. BC-STRAT-101" class="w-full text-xs border border-slate-300 rounded-xl p-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Track / Category *</label>
                    <select name="track" required class="w-full text-xs border border-slate-300 rounded-xl p-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <option value="Brand Strategy">Brand Strategy</option>
                        <option value="Visual Identity & Design">Visual Identity & Design</option>
                        <option value="Brand Law & Intellectual Property">Brand Law & Intellectual Property</option>
                        <option value="Corporate Reputation & PR">Corporate Reputation & PR</option>
                        <option value="SME Brand Growth">SME Brand Growth</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Delivery Mode *</label>
                    <select name="delivery_mode" required class="w-full text-xs border border-slate-300 rounded-xl p-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <option value="self_paced">Self-Paced (On-Demand Video)</option>
                        <option value="live_cohort">Live Cohort (Google Meet)</option>
                        <option value="hybrid">Hybrid (Stream + Live Sessions)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Target Experience Level *</label>
                    <select name="level" required class="w-full text-xs border border-slate-300 rounded-xl p-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <option value="All Levels">All Levels</option>
                        <option value="Foundational">Foundational</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Executive / Advanced">Executive / Advanced</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Duration (Weeks)</label>
                    <input type="number" name="duration_weeks" min="1" value="{{ old('duration_weeks', 4) }}" class="w-full text-xs border border-slate-300 rounded-xl p-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Estimated Study Hours</label>
                    <input type="number" name="estimated_hours" min="1" value="{{ old('estimated_hours', 12) }}" class="w-full text-xs border border-slate-300 rounded-xl p-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 font-mono">
                </div>
            </div>
        </div>

        <div class="space-y-4 pt-4 border-t border-slate-100">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 pb-2 border-b border-slate-100">Tuition & Video Provider</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tuition Type *</label>
                    <select name="fee_type" required class="w-full text-xs border border-slate-300 rounded-xl p-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <option value="paid">Paid Course</option>
                        <option value="free">Free Micro-Course</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Standard Tuition (₦)</label>
                    <input type="number" name="regular_price" step="0.01" value="{{ old('regular_price', 25000) }}" class="w-full text-xs border border-slate-300 rounded-xl p-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 font-mono">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Member Tuition (25% Off Default)</label>
                    <input type="number" name="member_price" step="0.01" value="{{ old('member_price', 18750) }}" class="w-full text-xs border border-slate-300 rounded-xl p-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500 font-mono">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Video Conferencing Platform *</label>
                    <select name="meeting_provider" required class="w-full text-xs border border-slate-300 rounded-xl p-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <option value="google_meet">Google Meet (Free &amp; Zero Install)</option>
                        <option value="zoom">Zoom Video</option>
                        <option value="youtube_live">YouTube Live Stream</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Live Meeting Room URL (Optional)</label>
                    <input type="url" name="meeting_link" placeholder="Leave blank to auto-generate Google Meet room" value="{{ old('meeting_link') }}" class="w-full text-xs border border-slate-300 rounded-xl p-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <p class="text-[10px] text-slate-400 mt-1">If left blank, an official Google Meet room link will be automatically generated for you.</p>
                </div>
            </div>
        </div>

        <div class="space-y-4 pt-4 border-t border-slate-100">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 pb-2 border-b border-slate-100">Instructor & Descriptions</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Lead Instructor Name</label>
                    <input type="text" name="instructor_name" value="{{ old('instructor_name', auth()->user()->name) }}" class="w-full text-xs border border-slate-300 rounded-xl p-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Instructor Professional Designation</label>
                    <input type="text" name="instructor_title" placeholder="e.g. Senior Brand Fellow, IP Attorney" value="{{ old('instructor_title') }}" class="w-full text-xs border border-slate-300 rounded-xl p-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Short Summary (Displayed on Cards)</label>
                <textarea name="short_description" rows="2" class="w-full text-xs border border-slate-300 rounded-xl p-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('short_description') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Full Course Syllabus & Description</label>
                <textarea name="description" rows="4" class="w-full text-xs border border-slate-300 rounded-xl p-3 text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('description') }}</textarea>
            </div>

            <div class="flex items-center gap-6 pt-2">
                <label class="flex items-center gap-2 text-xs font-semibold text-slate-800 cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" checked class="rounded border-slate-300 text-amber-500 focus:ring-amber-400">
                    <span>Publish Course to Public Catalog</span>
                </label>

                <label class="flex items-center gap-2 text-xs font-semibold text-slate-800 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" class="rounded border-slate-300 text-amber-500 focus:ring-amber-400">
                    <span>Highlight as Featured on Homepage</span>
                </label>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
            <a href="{{ route('admin.lms.courses') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold transition-all">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold shadow-md transition-all">
                Save &amp; Build Curriculum
            </button>
        </div>
    </form>
</div>

@endsection
