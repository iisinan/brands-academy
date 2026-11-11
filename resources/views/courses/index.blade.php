@extends('layouts.app')

@section('title', 'Executive Short Courses & LMS - Brands Academy')

@section('content')

<!-- Header -->
<section class="bg-slate-900 text-white py-14 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20 mb-3">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Native LMS & Interactive Classroom
                </span>
                <h1 class="text-3xl sm:text-4xl font-extrabold font-serif-title mb-3">
                    Executive Short Courses & Micro-Credentials
                </h1>
                <p class="text-slate-300 text-sm sm:text-base max-w-3xl leading-relaxed font-light">
                    Accelerate your mastery with specialized brand strategy, design identity, and legal IP courses. Learn through live video interactive sessions, downloadable workbooks, timed quizzes, and auto-minted verifiable certificates.
                </p>
            </div>
            @auth
                <div class="shrink-0">
                    <a href="{{ route('member.courses.index') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold shadow-md hover:shadow-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        My LMS Classroom
                    </a>
                </div>
            @endauth
        </div>
    </div>
</section>

<!-- Filter Tabs & Listing -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Search & Filter Bar -->
    <form method="GET" action="{{ route('courses.index') }}" class="mb-8 flex flex-col md:flex-row gap-4 justify-between items-stretch md:items-center bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
        <div class="flex items-center gap-2 overflow-x-auto touch-scroll no-scrollbar py-1">
            <a href="{{ route('courses.index', ['track' => 'all', 'mode' => $mode]) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition-all {{ empty($track) || $track === 'all' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                All Tracks
            </a>
            @foreach($tracks as $t)
                <a href="{{ route('courses.index', ['track' => $t, 'mode' => $mode]) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition-all {{ $track === $t ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    {{ $t }}
                </a>
            @endforeach
        </div>

        <div class="flex items-center gap-2">
            <select name="mode" onchange="this.form.submit()" class="text-xs bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="all" {{ empty($mode) || $mode === 'all' ? 'selected' : '' }}>All Modes</option>
                <option value="self_paced" {{ $mode === 'self_paced' ? 'selected' : '' }}>Self-Paced Stream</option>
                <option value="live_cohort" {{ $mode === 'live_cohort' ? 'selected' : '' }}>Live Virtual Cohort</option>
                <option value="hybrid" {{ $mode === 'hybrid' ? 'selected' : '' }}>Hybrid Learning</option>
            </select>

            <div class="relative w-full sm:w-64">
                <input type="text" name="q" value="{{ $search }}" placeholder="Search courses..." class="w-full text-xs bg-slate-50 border border-slate-200 rounded-lg pl-8 pr-3 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </form>

    <!-- Courses Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($courses as $course)
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden flex flex-col justify-between shadow-xs hover:shadow-md transition-all group">
                <div>
                    <!-- Top Ribbon -->
                    <div class="p-6 pb-4">
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                {{ $course->track }}
                            </span>
                            <span class="text-[11px] font-medium text-slate-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $course->duration_weeks }} Weeks ({{ $course->estimated_hours }}h)
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-2 mb-2">
                            <a href="{{ route('courses.show', $course->slug) }}">
                                {{ $course->title }}
                            </a>
                        </h3>

                        <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed mb-4 font-light">
                            {{ $course->short_description ?: 'Comprehensive course designed by Brands Academy faculty covering real-world execution, frameworks, and strategy.' }}
                        </p>

                        <!-- Delivery Mode & Level Badge -->
                        <div class="flex items-center gap-2 mb-4 text-[11px] text-slate-500">
                            <span class="px-2 py-0.5 rounded-md bg-slate-100 font-semibold text-slate-700 capitalize">
                                {{ str_replace('_', ' ', $course->delivery_mode) }}
                            </span>
                            <span>•</span>
                            <span>{{ $course->level }}</span>
                            <span>•</span>
                            <span>{{ $course->lessons_count }} Lessons</span>
                        </div>

                        <!-- Instructor Snippet -->
                        <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                            <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-xs uppercase shrink-0">
                                {{ substr($course->instructor_name ?: 'BANF', 0, 2) }}
                            </div>
                            <div class="truncate">
                                <div class="text-xs font-bold text-slate-800 truncate">{{ $course->instructor_name ?: 'Brands Academy Faculty' }}</div>
                                <div class="text-[11px] text-slate-500 truncate">{{ $course->instructor_title ?: 'Brand Fellow & Advisor' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer with Tuition & Action -->
                <div class="p-6 pt-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-4">
                    <div>
                        <div class="text-[11px] text-slate-500 uppercase tracking-wider font-semibold">Tuition</div>
                        @if($course->fee_type === 'free' || $course->regular_price <= 0)
                            <div class="text-base font-extrabold text-emerald-600">Free</div>
                        @else
                            <div class="flex items-baseline gap-1.5">
                                <span class="text-base font-extrabold text-slate-900">₦{{ number_format($course->regular_price, 2) }}</span>
                            </div>
                            <div class="text-[10px] text-blue-700 font-bold flex items-center gap-0.5">
                                <span class="px-1.5 py-0.2 rounded bg-blue-100">₦{{ number_format($course->member_price > 0 ? $course->member_price : $course->regular_price * 0.75, 2) }}</span>
                                <span>(25% off for members)</span>
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('courses.show', $course->slug) }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-blue-600 text-white text-xs font-bold shadow-xs transition-all">
                        <span>Details</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-slate-300 p-8">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <h3 class="text-base font-bold text-slate-800 mb-1">No courses found</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mb-4">Try adjusting your track filter or search terms to find available courses.</p>
                <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all">
                    Reset Filters
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $courses->links() }}
    </div>

</section>

@endsection
