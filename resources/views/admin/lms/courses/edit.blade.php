@extends('layouts.admin')

@section('title', 'Curriculum Studio - ' . $course->title)

@section('content')

<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('admin.lms.courses') }}" class="hover:text-slate-800">LMS Courses</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold">{{ $course->title }}</span>
            </div>
            <h1 class="text-2xl font-bold font-serif-title text-slate-900">
                Curriculum &amp; Course Studio
            </h1>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('courses.show', $course->slug) }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <span>View Public Page</span>
            </a>
            <form method="POST" action="{{ route('admin.lms.courses.destroy', $course->id) }}" onsubmit="return confirm('Are you sure you want to delete this entire course and all its curriculum data?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3.5 py-2 rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100 text-xs font-bold transition-all">
                    Delete Course
                </button>
            </form>
        </div>
    </div>

    <!-- Quick Stats Bar -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="p-4 bg-white rounded-xl border border-slate-200 shadow-xs">
            <div class="text-[11px] text-slate-400 font-bold uppercase">Modules</div>
            <div class="text-xl font-bold text-slate-900 mt-0.5">{{ $course->modules->count() }}</div>
        </div>
        <div class="p-4 bg-white rounded-xl border border-slate-200 shadow-xs">
            <div class="text-[11px] text-slate-400 font-bold uppercase">Total Lessons</div>
            <div class="text-xl font-bold text-slate-900 mt-0.5">{{ $course->lessons->count() }}</div>
        </div>
        <div class="p-4 bg-white rounded-xl border border-slate-200 shadow-xs">
            <div class="text-[11px] text-slate-400 font-bold uppercase">Quizzes</div>
            <div class="text-xl font-bold text-slate-900 mt-0.5">{{ $course->quizzes->count() }}</div>
        </div>
        <div class="p-4 bg-white rounded-xl border border-slate-200 shadow-xs">
            <div class="text-[11px] text-slate-400 font-bold uppercase">Enrolled Students</div>
            <div class="text-xl font-bold text-blue-600 mt-0.5">{{ $course->enrollments->count() }}</div>
        </div>
    </div>

    <!-- 1. Curriculum Modules & Lessons Builder -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-4">
            <div>
                <h2 class="text-lg font-bold font-serif-title text-slate-900">Curriculum Modules &amp; Video Lessons</h2>
                <p class="text-xs text-slate-500">Add instructional modules, streaming video lectures (YouTube unlisted/embed), live Google Meet classes, and reading material.</p>
            </div>

            <!-- Add Module Trigger -->
            <button type="button" onclick="document.getElementById('add-module-modal').classList.remove('hidden')" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold shadow-xs transition-all shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>Add Module</span>
            </button>
        </div>

        <!-- Modules List -->
        <div class="space-y-6">
            @forelse($course->modules as $mIndex => $module)
                <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50">
                    <div class="p-4 bg-slate-100/70 border-b border-slate-200 flex items-center justify-between gap-4">
                        <div>
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Module {{ $mIndex + 1 }}</span>
                            <h3 class="text-sm font-bold text-slate-900">{{ $module->title }}</h3>
                            @if($module->description)
                                <p class="text-xs text-slate-500 mt-0.5">{{ $module->description }}</p>
                            @endif
                        </div>

                        <div class="flex items-center gap-2">
                            <!-- Add Lesson Button -->
                            <button type="button" onclick="document.getElementById('add-lesson-modal-{{ $module->id }}').classList.remove('hidden')" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>Add Lesson</span>
                            </button>

                            <form method="POST" action="{{ route('admin.lms.modules.destroy', ['courseId' => $course->id, 'moduleId' => $module->id]) }}" onsubmit="return confirm('Delete this module and all its lessons?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Delete Module">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Lessons list in module -->
                    <div class="divide-y divide-slate-200/60 bg-white">
                        @forelse($module->lessons as $lesson)
                            <div class="p-3.5 px-4 flex items-center justify-between gap-4 text-xs">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 rounded-md bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-[10px]">
                                        {{ $lesson->sort_order }}
                                    </span>
                                    <div>
                                        <div class="font-bold text-slate-900">{{ $lesson->title }}</div>
                                        <div class="text-[11px] text-slate-400 flex items-center gap-2">
                                            <span class="capitalize">{{ str_replace('_', ' ', $lesson->content_type) }}</span>
                                            <span>•</span>
                                            <span>{{ $lesson->duration_minutes }}m</span>
                                            @if($lesson->is_free_preview)
                                                <span>•</span>
                                                <span class="text-emerald-600 font-semibold">Free Preview</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('admin.lms.lessons.destroy', ['courseId' => $course->id, 'lessonId' => $lesson->id]) }}" onsubmit="return confirm('Delete this lesson?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-slate-400 hover:text-rose-600 transition-colors" title="Delete Lesson">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="p-4 text-center text-xs text-slate-400">
                                No lessons added to this module yet.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Modal: Add Lesson to this module -->
                <div id="add-lesson-modal-{{ $module->id }}" class="hidden fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4">
                    <div class="bg-white rounded-2xl max-w-lg w-full p-6 text-slate-900 shadow-xl">
                        <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                            <h3 class="text-sm font-bold text-slate-900">Add Lesson to {{ $module->title }}</h3>
                            <button type="button" onclick="document.getElementById('add-lesson-modal-{{ $module->id }}').classList.add('hidden')" class="text-slate-400 hover:text-slate-700">✕</button>
                        </div>
                        <form method="POST" action="{{ route('admin.lms.lessons.store', ['courseId' => $course->id, 'moduleId' => $module->id]) }}" class="space-y-3.5">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Lesson Title *</label>
                                <input type="text" name="title" required placeholder="e.g. Introduction to Visual Hierarchy" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Content Type *</label>
                                    <select name="content_type" required class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                                        <option value="video">Streamed Video</option>
                                        <option value="live_session">Live Google Meet Session</option>
                                        <option value="reading">Reading / Notes</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Video Provider</label>
                                    <select name="video_provider" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                                        <option value="youtube_unlisted">YouTube (Unlisted/Public)</option>
                                        <option value="vimeo">Vimeo</option>
                                        <option value="direct_url">Direct MP4 URL</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Video URL or Embed Code</label>
                                <input type="text" name="video_id_or_url" placeholder="https://www.youtube.com/watch?v=... or unlisted link" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Duration (Minutes)</label>
                                    <input type="number" name="duration_minutes" value="15" min="1" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Live Room Link (Optional)</label>
                                    <input type="text" name="meeting_link" placeholder="Google Meet link if live" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Lesson Notes &amp; References</label>
                                <textarea name="body_text" rows="3" placeholder="Accompanying summary and reading material..." class="w-full text-xs border border-slate-300 rounded-lg p-2.5"></textarea>
                            </div>
                            <label class="flex items-center gap-2 text-xs font-semibold cursor-pointer">
                                <input type="checkbox" name="is_free_preview" value="1" class="rounded border-slate-300 text-blue-600">
                                <span>Allow as Free Preview (Accessible without enrolling)</span>
                            </label>
                            <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                                <button type="button" onclick="document.getElementById('add-lesson-modal-{{ $module->id }}').classList.add('hidden')" class="px-4 py-2 rounded-lg border border-slate-200 text-xs font-semibold">Cancel</button>
                                <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold">Save Lesson</button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200 p-6">
                    No curriculum modules added yet. Click "+ Add Module" to begin structuring the course.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal: Add Module -->
    <div id="add-module-modal" class="hidden fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 text-slate-900 shadow-xl">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-900">Add New Module</h3>
                <button type="button" onclick="document.getElementById('add-module-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-700">✕</button>
            </div>
            <form method="POST" action="{{ route('admin.lms.modules.store', $course->id) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Module Title *</label>
                    <input type="text" name="title" required placeholder="e.g. Module 1: Foundational Frameworks" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Module Description (Optional)</label>
                    <textarea name="description" rows="2" placeholder="Brief outline of module outcomes..." class="w-full text-xs border border-slate-300 rounded-lg p-2.5"></textarea>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('add-module-modal').classList.add('hidden')" class="px-4 py-2 rounded-lg border border-slate-200 text-xs font-semibold">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold">Save Module</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. Quizzes & Timed Assessments (Requirement 1) -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-4">
            <div>
                <h2 class="text-lg font-bold font-serif-title text-slate-900">Timed Quizzes &amp; Certification Gate</h2>
                <p class="text-xs text-slate-500">Create timed multiple-choice assessments with automated grading. A passing score (e.g. 80%) is required before the student certificate is automatically minted.</p>
            </div>

            <!-- Add Quiz Trigger -->
            <button type="button" onclick="document.getElementById('add-quiz-modal').classList.remove('hidden')" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shadow-xs transition-all shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>Add Quiz</span>
            </button>
        </div>

        <div class="space-y-4">
            @forelse($course->quizzes as $quiz)
                <div class="p-5 rounded-xl border border-slate-200 bg-slate-50 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Assessment</span>
                            <h3 class="text-sm font-bold text-slate-900">{{ $quiz->title }}</h3>
                            <div class="text-[11px] text-slate-500 flex items-center gap-3 mt-0.5">
                                <span>{{ $quiz->questions->count() }} Questions</span>
                                <span>•</span>
                                <span>{{ $quiz->time_limit_minutes }}m Time Limit</span>
                                <span>•</span>
                                <span>{{ $quiz->pass_percentage }}% Pass Mark</span>
                                <span>•</span>
                                <span>{{ $quiz->max_attempts }} Max Attempts</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <!-- Add Question Trigger -->
                            <button type="button" onclick="document.getElementById('add-q-modal-{{ $quiz->id }}').classList.remove('hidden')" class="px-3 py-1.5 rounded-lg bg-white border border-slate-300 text-slate-800 text-xs font-bold hover:bg-slate-50 transition-colors">
                                + Add Question
                            </button>

                            <form method="POST" action="{{ route('admin.lms.quizzes.destroy', $quiz->id) }}" onsubmit="return confirm('Delete this quiz and all its questions?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Questions list -->
                    <div class="space-y-2 pt-2">
                        @foreach($quiz->questions as $qIdx => $question)
                            <div class="p-3 bg-white rounded-lg border border-slate-200 text-xs">
                                <div class="font-bold text-slate-900 mb-1">
                                    {{ $qIdx + 1 }}. {{ $question->question_text }}
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-[11px] text-slate-600">
                                    @foreach($question->options as $opt)
                                        <div class="flex items-center gap-1.5 {{ $opt->is_correct ? 'font-bold text-emerald-700' : '' }}">
                                            <span>{{ $opt->is_correct ? '✓' : '○' }}</span>
                                            <span>{{ $opt->option_text }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Modal: Add Question to Quiz -->
                <div id="add-q-modal-{{ $quiz->id }}" class="hidden fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4">
                    <div class="bg-white rounded-2xl max-w-lg w-full p-6 text-slate-900 shadow-xl">
                        <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                            <h3 class="text-sm font-bold text-slate-900">Add Question to {{ $quiz->title }}</h3>
                            <button type="button" onclick="document.getElementById('add-q-modal-{{ $quiz->id }}').classList.add('hidden')" class="text-slate-400 hover:text-slate-700">✕</button>
                        </div>
                        <form method="POST" action="{{ route('admin.lms.quizzes.questions.store', $quiz->id) }}" class="space-y-3.5">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Question Text *</label>
                                <textarea name="question_text" required rows="2" class="w-full text-xs border border-slate-300 rounded-lg p-2.5"></textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Points</label>
                                <input type="number" name="points" value="1" min="1" class="w-24 text-xs border border-slate-300 rounded-lg p-2.5">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-slate-700">Answer Options (Select which one is correct) *</label>
                                @for($i = 0; $i < 4; $i++)
                                    <div class="flex items-center gap-2">
                                        <input type="radio" name="correct_option_index" value="{{ $i }}" {{ $i === 0 ? 'checked' : '' }} class="text-emerald-600 focus:ring-emerald-500">
                                        <input type="text" name="options[{{ $i }}][text]" required placeholder="Option {{ chr(65 + $i) }}" class="flex-1 text-xs border border-slate-300 rounded-lg p-2">
                                    </div>
                                @endfor
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Review Explanation (Shown after quiz submit)</label>
                                <textarea name="explanation" rows="2" placeholder="Why the correct answer is right..." class="w-full text-xs border border-slate-300 rounded-lg p-2.5"></textarea>
                            </div>

                            <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                                <button type="button" onclick="document.getElementById('add-q-modal-{{ $quiz->id }}').classList.add('hidden')" class="px-4 py-2 rounded-lg border border-slate-200 text-xs font-semibold">Cancel</button>
                                <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold">Save Question</button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200 p-6">
                    No quizzes created yet. Add a quiz to enforce completion assessments.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal: Add Quiz -->
    <div id="add-quiz-modal" class="hidden fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 text-slate-900 shadow-xl">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-900">Add New Quiz</h3>
                <button type="button" onclick="document.getElementById('add-quiz-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-700">✕</button>
            </div>
            <form method="POST" action="{{ route('admin.lms.quizzes.store', $course->id) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Quiz Title *</label>
                    <input type="text" name="title" required placeholder="e.g. Strategic Brand Architecture Final Exam" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Time (Mins)</label>
                        <input type="number" name="time_limit_minutes" value="15" min="1" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Pass %</label>
                        <input type="number" name="pass_percentage" value="80" min="1" max="100" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Max Attempts</label>
                        <input type="number" name="max_attempts" value="3" min="1" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Description (Optional)</label>
                    <textarea name="description" rows="2" class="w-full text-xs border border-slate-300 rounded-lg p-2.5"></textarea>
                </div>
                <label class="flex items-center gap-2 text-xs font-semibold cursor-pointer">
                    <input type="checkbox" name="is_required_for_certificate" value="1" checked class="rounded border-slate-300 text-blue-600">
                    <span>Required to Unlock Certificate</span>
                </label>
                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('add-quiz-modal').classList.add('hidden')" class="px-4 py-2 rounded-lg border border-slate-200 text-xs font-semibold">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold">Create Quiz</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 3. Course Materials & Slide Decks (Requirement 2) -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-4">
            <div>
                <h2 class="text-lg font-bold font-serif-title text-slate-900">Downloadable Course Materials</h2>
                <p class="text-xs text-slate-500">Attach slide decks, PDF brand workbooks, templates, and downloadable assets.</p>
            </div>

            <!-- Upload Resource Trigger -->
            <button type="button" onclick="document.getElementById('upload-res-modal').classList.remove('hidden')" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold shadow-xs transition-all shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>Upload Material</span>
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($course->resources as $res)
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-between gap-3 text-xs">
                    <div class="truncate">
                        <div class="font-bold text-slate-900 truncate">{{ $res->title }}</div>
                        <div class="text-[11px] text-slate-500">{{ $res->formattedSize() }} • {{ $res->download_count }} downloads</div>
                    </div>

                    <form method="POST" action="{{ route('admin.lms.resources.destroy', $res->id) }}" onsubmit="return confirm('Remove this material?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1 text-slate-400 hover:text-rose-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full py-8 text-center text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200 p-6">
                    No downloadable materials uploaded yet.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal: Upload Resource -->
    <div id="upload-res-modal" class="hidden fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 text-slate-900 shadow-xl">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-900">Upload Course Material</h3>
                <button type="button" onclick="document.getElementById('upload-res-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-700">✕</button>
            </div>
            <form method="POST" action="{{ route('admin.lms.resources.store', $course->id) }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Material Title *</label>
                    <input type="text" name="title" required placeholder="e.g. Brand Positioning Workbook (PDF)" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Asset Type *</label>
                    <select name="file_type" required class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                        <option value="pdf">PDF Workbook</option>
                        <option value="slides">Presentation Slides</option>
                        <option value="template">Template / Framework</option>
                        <option value="sheet">Spreadsheet (Excel/Sheets)</option>
                        <option value="zip">ZIP Bundle</option>
                        <option value="link">External Resource Link</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Upload File (Max 20MB)</label>
                    <input type="file" name="attachment" class="w-full text-xs border border-slate-300 rounded-lg p-2">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Or External Web URL</label>
                    <input type="url" name="external_url" placeholder="https://..." class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('upload-res-modal').classList.add('hidden')" class="px-4 py-2 rounded-lg border border-slate-200 text-xs font-semibold">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold">Upload Resource</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 4. Instructor Office Hours Schedules (Requirement 3) -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-4">
            <div>
                <h2 class="text-lg font-bold font-serif-title text-slate-900">Instructor Office Hours Setup</h2>
                <p class="text-xs text-slate-500">Configure weekly Google Meet consultation schedules where enrolled students can book 1-on-1 video advisory slots.</p>
            </div>

            <!-- Add Schedule Trigger -->
            <button type="button" onclick="document.getElementById('add-sched-modal').classList.remove('hidden')" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold shadow-xs transition-all shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>Add Schedule Slot</span>
            </button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @forelse($course->instructorSchedules as $sched)
                <div class="p-4 rounded-xl border border-slate-200 bg-purple-50/30 flex items-center justify-between gap-4 text-xs">
                    <div>
                        <div class="font-bold text-slate-900">{{ $sched->formattedLabel() }}</div>
                        <div class="text-[11px] text-slate-500 mt-0.5">Instructor: {{ $sched->instructor->name }} • Google Meet Room</div>
                    </div>

                    <form method="POST" action="{{ route('admin.lms.schedules.destroy', $sched->id) }}" onsubmit="return confirm('Remove this schedule?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1 text-slate-400 hover:text-rose-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full py-8 text-center text-xs text-slate-400 bg-slate-50 rounded-xl border border-dashed border-slate-200 p-6">
                    No office hours configured yet. Click "+ Add Schedule Slot" to activate 1-on-1 consultations.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal: Add Schedule -->
    <div id="add-sched-modal" class="hidden fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 text-slate-900 shadow-xl">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-900">Add Office Hours Schedule</h3>
                <button type="button" onclick="document.getElementById('add-sched-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-700">✕</button>
            </div>
            <form method="POST" action="{{ route('admin.lms.schedules.store', $course->id) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Instructor *</label>
                    <select name="instructor_user_id" required class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                        @foreach($instructors as $inst)
                            <option value="{{ $inst->id }}">{{ $inst->name }} ({{ $inst->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Day of Week *</label>
                        <select name="day_of_week" required class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                            <option value="monday">Monday</option>
                            <option value="tuesday">Tuesday</option>
                            <option value="wednesday" selected>Wednesday</option>
                            <option value="thursday">Thursday</option>
                            <option value="friday">Friday</option>
                            <option value="saturday">Saturday</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Slot Duration</label>
                        <select name="slot_duration_minutes" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                            <option value="15">15 Minutes</option>
                            <option value="20" selected>20 Minutes</option>
                            <option value="30">30 Minutes</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Start Time (24h) *</label>
                        <input type="text" name="start_time" value="14:00" required placeholder="14:00" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">End Time (24h) *</label>
                        <input type="text" name="end_time" value="16:00" required placeholder="16:00" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Platform</label>
                    <select name="meeting_provider" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                        <option value="google_meet">Google Meet (Auto-generated)</option>
                        <option value="zoom">Zoom</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('add-sched-modal').classList.add('hidden')" class="px-4 py-2 rounded-lg border border-slate-200 text-xs font-semibold">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold">Save Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
