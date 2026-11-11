@extends('layouts.admin')

@section('title', 'LMS Courses Studio - Admin Control Center')

@section('content')

<div class="space-y-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold font-serif-title text-slate-900">
                LMS Courses & Micro-Credentials
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Manage curriculum modules, video streaming lessons, multiple-choice quizzes, course materials, and office hours.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.lms.courses.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold shadow-md transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>Create New Course</span>
            </a>
        </div>
    </div>

    <!-- Courses Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto touch-scroll">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4 font-bold">Course Details</th>
                        <th class="py-3 px-4 font-bold">Track & Mode</th>
                        <th class="py-3 px-4 font-bold">Curriculum</th>
                        <th class="py-3 px-4 font-bold">Tuition</th>
                        <th class="py-3 px-4 font-bold">Students</th>
                        <th class="py-3 px-4 font-bold">Status</th>
                        <th class="py-3 px-4 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($courses as $course)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $course->title }}</div>
                                <div class="text-[11px] text-slate-400 flex items-center gap-2 mt-0.5">
                                    @if($course->code)
                                        <span class="font-mono text-slate-600 font-semibold">{{ $course->code }}</span>
                                        <span>•</span>
                                    @endif
                                    <span>{{ $course->instructor_name ?: 'Faculty' }}</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ $course->track }}
                                </span>
                                <div class="text-[10px] text-slate-500 capitalize mt-1">{{ str_replace('_', ' ', $course->delivery_mode) }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-slate-800">{{ $course->modules_count }} Modules</div>
                                <div class="text-[11px] text-slate-400">{{ $course->lessons_count }} Lessons</div>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($course->fee_type === 'free' || $course->regular_price <= 0)
                                    <span class="font-bold text-emerald-600">Free</span>
                                @else
                                    <div class="font-bold text-slate-900">₦{{ number_format($course->regular_price, 2) }}</div>
                                    <div class="text-[10px] text-blue-600 font-semibold">₦{{ number_format($course->member_price > 0 ? $course->member_price : $course->regular_price * 0.75, 2) }} (Member)</div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-800 font-mono">
                                    {{ $course->enrollments_count }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($course->is_published)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('courses.show', $course->slug) }}" target="_blank" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-800 hover:bg-slate-100 transition-colors" title="View Public Page">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('admin.lms.courses.edit', $course->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold text-xs transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>Curriculum</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                No courses created yet. Click "+ Create New Course" to build your first curriculum.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $courses->links() }}
        </div>
    </div>
</div>

@endsection
