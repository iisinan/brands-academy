@extends('layouts.member')

@section('title', ($currentLesson ? $currentLesson->title . ' - ' : '') . $course->title . ' (LMS Classroom)')

@section('content')

<div class="bg-slate-900 text-white border-b border-slate-800 py-4 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-400 mb-1">
                <a href="{{ route('member.courses.index') }}" class="hover:text-blue-400 flex items-center gap-1 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Courses
                </a>
                <span>/</span>
                <span class="text-slate-300 truncate max-w-xs sm:max-w-md">{{ $course->title }}</span>
            </div>
            <h1 class="text-lg sm:text-xl font-bold font-serif-title truncate text-white">
                {{ $currentLesson ? $currentLesson->title : $course->title }}
            </h1>
        </div>

        <!-- Progress Indicator & Action -->
        <div class="flex items-center gap-4 shrink-0">
            <div class="text-right">
                <div class="text-[11px] text-slate-400 font-medium">Course Progress</div>
                <div class="text-sm font-extrabold text-blue-400 font-mono">{{ number_format($enrollment->progress_percentage, 0) }}% Completed</div>
            </div>
            <div class="w-24 sm:w-32 h-2.5 bg-slate-800 rounded-full overflow-hidden">
                <div class="h-full bg-blue-500 rounded-full transition-all duration-500" style="width: {{ $enrollment->progress_percentage }}%"></div>
            </div>
            @if($enrollment->certificate)
                <a href="{{ route('verify.certificate', $enrollment->certificate->verification_token) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-500/20 text-emerald-300 text-xs font-bold border border-emerald-500/30 hover:bg-emerald-500/30 transition-all">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span>View Certificate</span>
                </a>
            @endif
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('warning'))
        <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-semibold flex items-center gap-2">
            <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <span>{{ session('warning') }}</span>
        </div>
    @endif

    <!-- Certificate Awarded Callout if complete -->
    @if($enrollment->certificate)
        <div class="mb-8 p-6 rounded-2xl bg-gradient-to-r from-emerald-900 to-slate-900 text-white border border-emerald-700/50 shadow-lg flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0 border border-emerald-500/30">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-400">Credential Awarded</span>
                    <h2 class="text-base sm:text-lg font-bold">You have earned your Certificate of Completion!</h2>
                    <p class="text-xs text-slate-300 mt-0.5">Your official verifiable digital certificate with cryptographic QR code is active.</p>
                </div>
            </div>
            <a href="{{ route('verify.certificate', $enrollment->certificate->verification_token) }}" target="_blank" class="shrink-0 px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-md transition-all">
                Download & Verify Certificate
            </a>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <!-- Main Video & Lesson Content Column -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Video Player / Live Session Stage -->
            <div class="bg-slate-950 rounded-2xl overflow-hidden border border-slate-800 shadow-xl">
                @if($currentLesson && $currentLesson->content_type === 'live_session')
                    <!-- Live Virtual Classroom Session Banner -->
                    <div class="p-8 sm:p-12 text-center text-white bg-radial from-slate-900 to-slate-950">
                        <div class="w-16 h-16 rounded-2xl bg-purple-500/20 text-purple-400 flex items-center justify-center mx-auto mb-4 border border-purple-500/30">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-purple-400 uppercase tracking-wider">Live Video Session</span>
                        <h2 class="text-xl sm:text-2xl font-bold font-serif-title mt-1 mb-3">{{ $currentLesson->title }}</h2>
                        <p class="text-xs sm:text-sm text-slate-300 max-w-lg mx-auto mb-6 font-light">
                            This module is conducted live via Google Meet with interactive Q&A and breakout exercises.
                        </p>
                        @php
                            $meetLink = $currentLesson->meeting_link ?: $course->meeting_link ?: 'https://meet.google.com';
                        @endphp
                        <a href="{{ $meetLink }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-bold text-sm shadow-lg hover:shadow-purple-500/25 transition-all">
                            <span>Join Google Meet Room</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </div>
                @elseif($currentLesson && !empty($currentLesson->getYoutubeEmbedUrl()))
                    <!-- Responsive 16:9 Video Player -->
                    <div class="relative w-full aspect-video bg-black">
                        <iframe 
                            src="{{ $currentLesson->getYoutubeEmbedUrl() }}" 
                            title="{{ $currentLesson->title }}" 
                            class="absolute inset-0 w-full h-full border-0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen>
                        </iframe>
                    </div>
                @else
                    <!-- Text / Reading Placeholder -->
                    <div class="p-8 sm:p-12 text-center text-white bg-slate-900">
                        <div class="w-16 h-16 rounded-2xl bg-blue-500/20 text-blue-400 flex items-center justify-center mx-auto mb-4 border border-blue-500/30">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h2 class="text-xl font-bold font-serif-title mb-2">{{ $currentLesson ? $currentLesson->title : $course->title }}</h2>
                        <p class="text-xs text-slate-400 max-w-md mx-auto">Please read through the comprehensive lesson guide and references provided below.</p>
                    </div>
                @endif

                <!-- Player Action Bar -->
                @if($currentLesson)
                    <div class="p-4 bg-slate-900 border-t border-slate-800 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-2">
                            @if($prevLesson)
                                <a href="{{ route('member.courses.learn', ['slug' => $course->slug, 'lesson' => $prevLesson->slug]) }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                    <span>Previous</span>
                                </a>
                            @endif
                            @if($nextLesson)
                                <a href="{{ route('member.courses.learn', ['slug' => $course->slug, 'lesson' => $nextLesson->slug]) }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold transition-all">
                                    <span>Next Lesson</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            @endif
                        </div>

                        <!-- Complete Toggle Form -->
                        @php
                            $isCompleted = in_array($currentLesson->id, $completedLessonIds, true);
                        @endphp
                        <form method="POST" action="{{ route('member.courses.lessons.toggle', ['slug' => $course->slug, 'lessonId' => $currentLesson->id]) }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $isCompleted ? 'bg-emerald-600 hover:bg-emerald-500 text-white' : 'bg-blue-600 hover:bg-blue-500 text-white shadow-xs' }}">
                                @if($isCompleted)
                                    <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>Completed (Click to Reopen)</span>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>Mark as Complete & Continue</span>
                                @endif
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Tab Navigation (Overview, Materials, Office Hours, Quizzes) -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
                <div class="flex items-center border-b border-slate-200 overflow-x-auto touch-scroll no-scrollbar bg-slate-50 px-4 pt-2">
                    <a href="{{ route('member.courses.learn', ['slug' => $course->slug, 'lesson' => $currentLesson?->slug, 'tab' => 'overview']) }}" class="px-4 py-3 text-xs font-bold border-b-2 whitespace-nowrap transition-all {{ $activeTab === 'overview' ? 'border-blue-600 text-blue-600 bg-white rounded-t-lg' : 'border-transparent text-slate-600 hover:text-slate-900' }}">
                        Lesson Notes & Overview
                    </a>
                    <a href="{{ route('member.courses.learn', ['slug' => $course->slug, 'lesson' => $currentLesson?->slug, 'tab' => 'notes']) }}" class="px-4 py-3 text-xs font-bold border-b-2 whitespace-nowrap transition-all flex items-center gap-1.5 {{ $activeTab === 'notes' ? 'border-blue-600 text-blue-600 bg-white rounded-t-lg' : 'border-transparent text-slate-600 hover:text-slate-900' }}">
                        <span>My Study Notepad</span>
                        @if($currentLessonNote)
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        @endif
                    </a>
                    <a href="{{ route('member.courses.learn', ['slug' => $course->slug, 'lesson' => $currentLesson?->slug, 'tab' => 'resources']) }}" class="px-4 py-3 text-xs font-bold border-b-2 whitespace-nowrap transition-all flex items-center gap-1.5 {{ $activeTab === 'resources' ? 'border-blue-600 text-blue-600 bg-white rounded-t-lg' : 'border-transparent text-slate-600 hover:text-slate-900' }}">
                        <span>Course Materials</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-slate-200 text-slate-700 font-mono">{{ $course->resources->count() }}</span>
                    </a>
                    <a href="{{ route('member.courses.learn', ['slug' => $course->slug, 'lesson' => $currentLesson?->slug, 'tab' => 'office_hours']) }}" class="px-4 py-3 text-xs font-bold border-b-2 whitespace-nowrap transition-all flex items-center gap-1.5 {{ $activeTab === 'office_hours' ? 'border-blue-600 text-blue-600 bg-white rounded-t-lg' : 'border-transparent text-slate-600 hover:text-slate-900' }}">
                        <span>Instructor Office Hours</span>
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    </a>
                    <a href="{{ route('member.courses.learn', ['slug' => $course->slug, 'lesson' => $currentLesson?->slug, 'tab' => 'quizzes']) }}" class="px-4 py-3 text-xs font-bold border-b-2 whitespace-nowrap transition-all flex items-center gap-1.5 {{ $activeTab === 'quizzes' ? 'border-blue-600 text-blue-600 bg-white rounded-t-lg' : 'border-transparent text-slate-600 hover:text-slate-900' }}">
                        <span>Timed Quizzes</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-blue-100 text-blue-700 font-mono">{{ $course->quizzes->count() }}</span>
                    </a>
                </div>

                <div class="p-6">
                    <!-- Tab 1: Overview & Notes -->
                    @if($activeTab === 'overview')
                        <div>
                            <h3 class="text-base font-bold text-slate-900 mb-3">{{ $currentLesson ? $currentLesson->title : $course->title }}</h3>
                            @if($currentLesson && $currentLesson->body_text)
                                <div class="prose prose-slate max-w-none text-xs sm:text-sm leading-relaxed space-y-3">
                                    {!! nl2br(e($currentLesson->body_text)) !!}
                                </div>
                            @else
                                <div class="prose prose-slate max-w-none text-xs sm:text-sm leading-relaxed space-y-3">
                                    {!! nl2br(e($course->description)) !!}
                                </div>
                            @endif

                            @if($currentLesson)
                                <!-- Quick Lesson Notes Drawer -->
                                <div class="mt-8 pt-6 border-t border-slate-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">My Private Lesson Notes</h4>
                                        </div>
                                        @if($currentLessonNote)
                                            <span class="text-[11px] text-slate-400">Saved {{ $currentLessonNote->updated_at->diffForHumans() }}</span>
                                        @endif
                                    </div>

                                    <form method="POST" action="{{ route('member.courses.lessons.notes', ['slug' => $course->slug, 'lessonId' => $currentLesson->id]) }}">
                                        @csrf
                                        <textarea name="notes" rows="4" placeholder="Jot down personal observations, formulas, legal citations, or questions for instructor office hours..." class="w-full text-xs rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500 p-3 bg-amber-50/20 font-sans leading-relaxed">{{ old('notes', $currentLessonNote?->notes) }}</textarea>
                                        <div class="mt-2 flex items-center justify-between">
                                            <span class="text-[11px] text-slate-400">Notes are private and autosaved to your account.</span>
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-lg transition-colors shadow-xs">
                                                <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                                <span>Save Notes</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Tab: Dedicated Study Notepad -->
                    @if($activeTab === 'notes')
                        <div>
                            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                                <div>
                                    <h3 class="text-base font-bold text-slate-900">Personal Study Notepad</h3>
                                    <p class="text-xs text-slate-500">Record your thoughts, executive summaries, and legal citations for <span class="font-bold text-slate-800">{{ $currentLesson ? $currentLesson->title : $course->title }}</span>.</p>
                                </div>
                                @if($currentLessonNote)
                                    <span class="text-xs text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200 font-medium">Last saved: {{ $currentLessonNote->updated_at->diffForHumans() }}</span>
                                @endif
                            </div>

                            @if($currentLesson)
                                <form method="POST" action="{{ route('member.courses.lessons.notes', ['slug' => $course->slug, 'lessonId' => $currentLesson->id]) }}" class="space-y-4">
                                    @csrf
                                    <div>
                                        <textarea name="notes" rows="10" placeholder="Type your personal lesson notes here. Use this space to outline brand frameworks, case study observations, and talking points for mentor office hours..." class="w-full text-xs sm:text-sm rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500 p-4 font-mono leading-relaxed bg-amber-50/20 shadow-inner">{{ old('notes', $currentLessonNote?->notes) }}</textarea>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="text-xs text-slate-500 flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                            <span>Notes are securely linked to your profile and persist across devices.</span>
                                        </div>
                                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs rounded-xl shadow-md transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                            <span>Save Study Notes</span>
                                        </button>
                                    </div>
                                </form>
                            @else
                                <div class="p-8 text-center text-xs text-slate-500">
                                    Please select a lesson from the syllabus on the right to open your study notepad.
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Tab 2: Course Materials (Requirement 2) -->
                    @if($activeTab === 'resources')
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-base font-bold text-slate-900">Downloadable Learning Materials</h3>
                                    <p class="text-xs text-slate-500">Access slide decks, workbooks, brand strategy canvas templates, and PDF guides.</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                @forelse($course->resources as $res)
                                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-between gap-4 hover:bg-white hover:border-blue-300 transition-all">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs uppercase shrink-0">
                                                {{ $res->file_type }}
                                            </div>
                                            <div>
                                                <div class="text-xs sm:text-sm font-bold text-slate-900">{{ $res->title }}</div>
                                                <div class="text-[11px] text-slate-500 flex items-center gap-2">
                                                    <span>{{ $res->formattedSize() }}</span>
                                                    <span>•</span>
                                                    <span>{{ $res->download_count }} Downloads</span>
                                                </div>
                                            </div>
                                        </div>

                                        <a href="{{ route('member.courses.resources.download', ['slug' => $course->slug, 'resourceId' => $res->id]) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-blue-600 text-white text-xs font-bold transition-all shrink-0">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            <span>Download</span>
                                        </a>
                                    </div>
                                @empty
                                    <div class="text-center py-8 text-xs text-slate-400 bg-white rounded-xl border border-dashed border-slate-200 p-6">
                                        No downloadable materials uploaded for this course yet.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endif

                    <!-- Tab 3: Office Hours Booking (Requirement 3) -->
                    @if($activeTab === 'office_hours')
                        <div>
                            <div class="mb-6">
                                <h3 class="text-base font-bold text-slate-900">Instructor 1-on-1 Office Hours</h3>
                                <p class="text-xs text-slate-500">Book a direct Google Meet video consultation with the instructor to review your coursework, assignments, or brand strategy questions.</p>
                            </div>

                            @if($course->instructorSchedules->isNotEmpty())
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                                    <!-- Schedule Booking Form -->
                                    <div class="bg-slate-50 p-5 rounded-xl border border-slate-200">
                                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">Book New Consultation</h4>
                                        <form method="POST" action="{{ route('member.courses.office-hours.book', $course->slug) }}" class="space-y-4">
                                            @csrf
                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">Available Schedule Slot</label>
                                                <select name="instructor_schedule_id" required class="w-full text-xs bg-white border border-slate-300 rounded-lg p-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                    @foreach($course->instructorSchedules as $sched)
                                                        <option value="{{ $sched->id }}">{{ $sched->formattedLabel() }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">Session Date</label>
                                                <input type="date" name="booking_date" required min="{{ date('Y-m-d') }}" class="w-full text-xs bg-white border border-slate-300 rounded-lg p-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>

                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">Start Time (24h format)</label>
                                                <input type="text" name="start_time" required placeholder="e.g. 14:00" class="w-full text-xs bg-white border border-slate-300 rounded-lg p-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>

                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">Consultation Topic / Query</label>
                                                <textarea name="topic" rows="2" placeholder="Briefly describe what you would like to discuss..." class="w-full text-xs bg-white border border-slate-300 rounded-lg p-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                            </div>

                                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold shadow-md transition-all">
                                                <span>Confirm Google Meet Booking</span>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Existing Bookings List -->
                                    <div>
                                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">Your Scheduled Consultations</h4>
                                        <div class="space-y-3">
                                            @forelse($enrollment->officeHourBookings as $booking)
                                                <div class="p-4 rounded-xl border border-slate-200 bg-white shadow-xs">
                                                    <div class="flex items-center justify-between gap-2 mb-1">
                                                        <span class="text-xs font-bold text-slate-900">{{ $booking->booking_date->format('M d, Y') }} • {{ $booking->start_time }} - {{ $booking->end_time }}</span>
                                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 capitalize">{{ $booking->status }}</span>
                                                    </div>
                                                    @if($booking->topic)
                                                        <p class="text-xs text-slate-600 mb-3">{{ $booking->topic }}</p>
                                                    @endif
                                                    @if($booking->meeting_link)
                                                        <a href="{{ $booking->meeting_link }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-purple-50 text-purple-700 text-xs font-bold border border-purple-200 hover:bg-purple-100 transition-colors">
                                                            <span>Join Google Meet</span>
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                        </a>
                                                    @endif
                                                </div>
                                            @empty
                                                <div class="text-center py-6 text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200 p-4">
                                                    You have no active office hours booked yet.
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-8 text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200 p-6">
                                    The instructor has not published active office hour slots for this course yet.
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Tab 4: Timed Quizzes (Requirement 1) -->
                    @if($activeTab === 'quizzes')
                        <div>
                            <div class="mb-6">
                                <h3 class="text-base font-bold text-slate-900">Module & Certification Quizzes</h3>
                                <p class="text-xs text-slate-500">Test your mastery with timed multiple-choice assessments. Pass all required quizzes (80%+) to unlock your official Certificate of Completion.</p>
                            </div>

                            <div class="space-y-6">
                                @forelse($course->quizzes as $quiz)
                                    @php
                                        $userAttempts = $enrollment->quizAttempts->where('quiz_id', $quiz->id);
                                        $latestAttempt = $userAttempts->sortByDesc('id')->first();
                                        $hasPassed = $userAttempts->where('passed', true)->isNotEmpty();
                                        $remaining = $quiz->remainingAttemptsFor(auth()->user(), $enrollment);
                                    @endphp
                                    <div class="p-6 rounded-2xl border {{ $hasPassed ? 'border-emerald-300 bg-emerald-50/20' : 'border-slate-200 bg-white' }} shadow-xs">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                                            <div>
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="text-xs font-bold text-blue-600 uppercase">Assessment</span>
                                                    @if($hasPassed)
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                                            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                            Passed ({{ $latestAttempt->percentage }}%)
                                                        </span>
                                                    @elseif($latestAttempt)
                                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                                            Attempted ({{ $latestAttempt->percentage }}% - Passing: {{ $quiz->pass_percentage }}%)
                                                        </span>
                                                    @else
                                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700">Not Attempted</span>
                                                    @endif
                                                </div>
                                                <h4 class="text-base font-bold text-slate-900">{{ $quiz->title }}</h4>
                                                @if($quiz->description)
                                                    <p class="text-xs text-slate-500 mt-0.5">{{ $quiz->description }}</p>
                                                @endif
                                            </div>

                                            <div class="text-xs text-slate-500 sm:text-right shrink-0">
                                                <div><span class="font-bold text-slate-800">{{ $quiz->time_limit_minutes }} Minutes</span> Time Limit</div>
                                                <div>Pass threshold: <span class="font-bold text-slate-800">{{ $quiz->pass_percentage }}%</span></div>
                                                <div>Attempts left: <span class="font-bold text-slate-800">{{ $remaining }}</span></div>
                                            </div>
                                        </div>

                                        <!-- Quiz Questions Form -->
                                        @if(!$hasPassed && $remaining > 0)
                                            <div class="mt-4 pt-4 border-t border-slate-100">
                                                <form method="POST" action="{{ route('member.courses.quizzes.submit', ['slug' => $course->slug, 'quizId' => $quiz->id]) }}">
                                                    @csrf
                                                    <div class="space-y-4 mb-6">
                                                        @foreach($quiz->questions as $qIndex => $q)
                                                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                                                                <div class="font-semibold text-xs sm:text-sm text-slate-900 mb-3">
                                                                    <span class="font-bold text-blue-600">Q{{ $qIndex + 1 }}.</span> {{ $q->question_text }}
                                                                </div>
                                                                <div class="space-y-2">
                                                                    @foreach($q->options as $opt)
                                                                        <label class="flex items-center gap-3 p-2.5 rounded-lg bg-white border border-slate-200 hover:border-blue-300 cursor-pointer text-xs transition-colors">
                                                                            <input type="radio" name="answers[{{ $q->id }}]" value="{{ $opt->id }}" required class="text-blue-600 focus:ring-blue-500">
                                                                            <span class="text-slate-800">{{ $opt->option_text }}</span>
                                                                        </label>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs shadow-md transition-all">
                                                        <span>Submit Quiz for Instant Scoring</span>
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($hasPassed)
                                            <div class="p-3 bg-emerald-50 rounded-xl text-xs text-emerald-800 font-medium">
                                                You have successfully passed this assessment requirement! Your score is recorded in your transcript.
                                            </div>
                                        @else
                                            <div class="p-3 bg-rose-50 rounded-xl text-xs text-rose-800 font-medium">
                                                You have utilized all {{ $quiz->max_attempts }} allowed attempts. Please reach out to your instructor during Office Hours for an evaluation reset.
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="text-center py-8 text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200 p-6">
                                        No quizzes attached to this course.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Course Syllabus & Navigation Tree -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs sticky top-20">
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Course Syllabus</h3>
                    <span class="text-xs text-blue-600 font-bold font-mono">{{ number_format($enrollment->progress_percentage, 0) }}%</span>
                </div>

                <!-- Module & Lessons List -->
                <div class="space-y-4 max-h-[70vh] overflow-y-auto touch-scroll pr-1">
                    @foreach($course->modules as $mIndex => $mod)
                        <div>
                            <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">
                                Module {{ $mIndex + 1 }}: {{ $mod->title }}
                            </div>
                            <div class="space-y-1">
                                @foreach($mod->lessons as $les)
                                    @php
                                        $isActive = $currentLesson && $currentLesson->id === $les->id;
                                        $isDone = in_array($les->id, $completedLessonIds, true);
                                    @endphp
                                    <a href="{{ route('member.courses.learn', ['slug' => $course->slug, 'lesson' => $les->slug]) }}" class="flex items-center justify-between p-2.5 rounded-xl text-xs transition-all {{ $isActive ? 'bg-blue-50 text-blue-800 font-bold border border-blue-200' : 'hover:bg-slate-50 text-slate-700' }}">
                                        <div class="flex items-center gap-2.5 truncate">
                                            @if($isDone)
                                                <div class="w-4 h-4 rounded-full bg-emerald-500 text-white flex items-center justify-center shrink-0">
                                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                </div>
                                            @else
                                                <div class="w-4 h-4 rounded-full border border-slate-300 shrink-0"></div>
                                            @endif
                                            <span class="truncate">{{ $les->title }}</span>
                                        </div>
                                        <span class="text-[10px] text-slate-400 shrink-0 ml-2 font-mono">{{ $les->duration_minutes }}m</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
