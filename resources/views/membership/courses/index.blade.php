@extends('layouts.member')

@section('title', 'My Courses & LMS Classroom - Brands Academy')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200 mb-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                LMS Student Classroom
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold font-serif-title text-slate-900">
                My Courses & Learning Path
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Track your active short courses, video progress, timed quiz evaluations, and verifiable credentials.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-blue-600 text-white text-xs font-bold shadow-xs transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Explore More Courses
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('info'))
        <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 text-xs font-semibold flex items-center gap-2">
            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ session('info') }}</span>
        </div>
    @endif

    <!-- Enrolled Courses Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($enrollments as $enrollment)
            @php
                $course = $enrollment->course;
                $pct = (float) $enrollment->progress_percentage;
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between shadow-xs hover:shadow-md transition-all">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                            {{ $course->track }}
                        </span>
                        @if($enrollment->status === 'completed')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Completed
                            </span>
                        @else
                            <span class="text-[11px] font-bold text-slate-500 capitalize">
                                {{ $enrollment->status }}
                            </span>
                        @endif
                    </div>

                    <h3 class="text-base font-bold text-slate-900 line-clamp-2 mb-2">
                        <a href="{{ route('member.courses.learn', $course->slug) }}" class="hover:text-blue-600 transition-colors">
                            {{ $course->title }}
                        </a>
                    </h3>

                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-4">
                        {{ $course->short_description ?: 'Comprehensive course delivered via the Brands Academy native LMS classroom.' }}
                    </p>

                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="flex items-center justify-between text-xs font-semibold mb-1.5">
                            <span class="text-slate-600">Course Progress</span>
                            <span class="text-slate-900 font-bold font-mono">{{ number_format($pct, 0) }}%</span>
                        </div>
                        <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-600 rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>

                    <!-- Instructor info -->
                    <div class="flex items-center gap-2.5 pt-3 border-t border-slate-100 text-xs text-slate-600">
                        <div class="w-6 h-6 rounded-full bg-slate-900 text-white flex items-center justify-center text-[10px] font-bold shrink-0">
                            {{ substr($course->instructor_name ?: 'BA', 0, 2) }}
                        </div>
                        <span class="truncate">{{ $course->instructor_name ?: 'Brands Academy Faculty' }}</span>
                    </div>
                </div>

                <div class="pt-5 mt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                    @if($enrollment->certificate)
                        <a href="{{ route('verify.certificate', $enrollment->certificate->verification_token) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-200 transition-colors">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            <span>Verify Cert</span>
                        </a>
                    @else
                        <span class="text-[11px] text-slate-400">Cert on 100%</span>
                    @endif

                    <a href="{{ route('member.courses.learn', $course->slug) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shadow-xs transition-all">
                        <span>{{ $pct > 0 ? 'Continue' : 'Start Learning' }}</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-slate-300 p-8">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <h3 class="text-base font-bold text-slate-800 mb-1">No courses enrolled yet</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mb-5">Browse the short courses catalog to enroll with your exclusive 25% member discount or access free micro-courses.</p>
                <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold shadow-md transition-all">
                    Browse Courses Catalog
                </a>
            </div>
        @endforelse
    </div>
</div>

@endsection
