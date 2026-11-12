@extends('layouts.app')

@section('title', $course->title . ' - Brands Academy Short Course')
@section('meta_description', Str::limit(strip_tags($course->short_description ?: $course->description), 160))
@section('og_type', 'article')

@section('content')

<!-- Hero -->
<section class="bg-slate-900 text-white py-12 lg:py-16 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
            <div class="lg:col-span-2">
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-500/20 text-blue-300 border border-blue-400/30">
                        {{ $course->track }}
                    </span>
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-800 text-slate-300 border border-slate-700 capitalize">
                        {{ str_replace('_', ' ', $course->delivery_mode) }}
                    </span>
                    @if($course->code)
                        <span class="text-xs font-mono text-slate-400">{{ $course->code }}</span>
                    @endif
                </div>

                <h1 class="text-3xl sm:text-4xl font-extrabold font-serif-title text-white mb-4 leading-tight">
                    {{ $course->title }}
                </h1>

                <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-6 font-light">
                    {{ $course->short_description ?: 'An executive, practical short course designed to elevate your strategic brand capabilities with real-world case studies and frameworks.' }}
                </p>

                <!-- Course Meta Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 py-4 border-y border-slate-800 text-xs">
                    <div>
                        <div class="text-slate-400">Duration</div>
                        <div class="font-bold text-white text-sm mt-0.5">{{ $course->duration_weeks }} Weeks</div>
                    </div>
                    <div>
                        <div class="text-slate-400">Commitment</div>
                        <div class="font-bold text-white text-sm mt-0.5">~{{ $course->estimated_hours }} Hours</div>
                    </div>
                    <div>
                        <div class="text-slate-400">Level</div>
                        <div class="font-bold text-white text-sm mt-0.5">{{ $course->level }}</div>
                    </div>
                    <div>
                        <div class="text-slate-400">Rating</div>
                        <div class="font-bold text-amber-400 text-sm mt-0.5 flex items-center gap-1">
                            <span>★ {{ $course->averageRating() }}</span>
                            <span class="text-slate-400 text-[11px] font-normal">({{ $course->reviews->count() }})</span>
                        </div>
                    </div>
                    <div>
                        <div class="text-slate-400">Credential</div>
                        <div class="font-bold text-emerald-400 text-sm mt-0.5">Verifiable QR</div>
                    </div>
                </div>

                <!-- Instructor Info -->
                <div class="flex items-center gap-4 mt-6">
                    <div class="w-12 h-12 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-sm uppercase shrink-0 ring-2 ring-blue-400/40">
                        {{ substr($course->instructor_name ?: 'BA', 0, 2) }}
                    </div>
                    <div>
                        <div class="text-sm font-bold text-white">{{ $course->instructor_name ?: 'Brands Academy Senior Faculty' }}</div>
                        <div class="text-xs text-slate-400">{{ $course->instructor_title ?: 'Executive Council & Practice Lead' }}</div>
                    </div>
                </div>
            </div>

            <!-- Tuition Card / Action Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl p-6 sm:p-8 text-slate-900 border border-slate-200 shadow-xl sticky top-24">
                    <div class="mb-6">
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Course Tuition</div>
                        @if($course->fee_type === 'free' || $course->regular_price <= 0)
                            <div class="text-3xl font-extrabold text-emerald-600">Free</div>
                            <div class="text-xs text-slate-500 mt-1">Open public access with certificate verification.</div>
                        @else
                            <div class="flex items-baseline gap-2">
                                <span class="text-3xl font-extrabold text-slate-900">₦{{ number_format($tuition, 2) }}</span>
                                @if($isDiscounted)
                                    <span class="text-base text-slate-400 line-through">₦{{ number_format($course->regular_price, 2) }}</span>
                                @endif
                            </div>

                            @if($isDiscounted)
                                <div class="mt-2 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-800 text-xs font-bold border border-emerald-200">
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    25% Member Discount Applied!
                                </div>
                            @elseif(!auth()->check() || (!auth()->user()->isMember() && !auth()->user()->isAdmin()))
                                <div class="mt-2 text-xs text-blue-700 bg-blue-50 p-2.5 rounded-lg border border-blue-200">
                                    <span class="font-bold">BANF Members pay ₦{{ number_format($course->member_price > 0 ? $course->member_price : $course->regular_price * 0.75, 2) }}</span> (25% off).
                                    <a href="{{ route('membership.register') }}" class="underline font-bold text-blue-800">Join BANF</a> to unlock discount.
                                </div>
                            @endif
                        @endif
                    </div>

                    <!-- Action Button -->
                    @if($isEnrolled)
                        <a href="{{ route('member.courses.learn', $course->slug) }}" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm shadow-md transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Enter Classroom
                        </a>
                        <p class="text-center text-[11px] text-slate-500 mt-2">You are actively enrolled in this course.</p>
                    @else
                        <form method="POST" action="{{ route('courses.enroll', $course->slug) }}">
                            @csrf
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-sm shadow-md hover:shadow-lg transition-all">
                                <span>{{ $course->fee_type === 'free' || $tuition <= 0 ? 'Enroll for Free' : 'Proceed to Checkout' }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </form>
                        <p class="text-center text-[11px] text-slate-500 mt-2 flex items-center justify-center gap-1">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Instant classroom access upon confirmation
                        </p>
                    @endif

                    <!-- What's included checklist -->
                    <div class="mt-6 pt-6 border-t border-slate-100 space-y-2.5 text-xs text-slate-700">
                        <div class="font-bold text-slate-900 mb-2">What is included:</div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>{{ $course->modules->count() }} Modules & {{ $course->totalLessonsCount() }} Detailed Lessons</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Downloadable Workbooks & Slide Decks</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Timed Quizzes with Immediate Scoring</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Google Meet 1-on-1 Office Hours Access</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Official QR Certificate of Completion</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Curriculum Syllabus & Details -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 space-y-10">
            <!-- Course Description -->
            <div>
                <h2 class="text-xl sm:text-2xl font-bold font-serif-title text-slate-900 mb-4">Course Overview</h2>
                <div class="prose prose-slate max-w-none text-slate-700 text-sm leading-relaxed space-y-3">
                    {!! nl2br(e($course->description ?: 'This course offers an intensive practical curriculum engineered for practitioners, business owners, and brand managers seeking demonstrable competence in brand building, trademark governance, and strategic market positioning.')) !!}
                </div>
            </div>

            <!-- Syllabus Accordion -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl sm:text-2xl font-bold font-serif-title text-slate-900">Curriculum Syllabus</h2>
                    <span class="text-xs text-slate-500 font-medium">{{ $course->modules->count() }} Modules • {{ $course->totalLessonsCount() }} Lessons</span>
                </div>

                <div class="space-y-4">
                    @forelse($course->modules as $modIndex => $module)
                        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-xs">
                            <div class="p-4 sm:p-5 bg-slate-50 flex items-center justify-between border-b border-slate-200">
                                <div>
                                    <span class="text-[11px] font-bold text-blue-600 uppercase tracking-wider">Module {{ $modIndex + 1 }}</span>
                                    <h3 class="text-sm sm:text-base font-bold text-slate-900">{{ $module->title }}</h3>
                                    @if($module->description)
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $module->description }}</p>
                                    @endif
                                </div>
                                <span class="text-xs font-semibold text-slate-500 shrink-0 ml-4">{{ $module->lessons->count() }} Lessons</span>
                            </div>

                            <div class="divide-y divide-slate-100">
                                @forelse($module->lessons as $lesson)
                                    <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                                @if($lesson->content_type === 'live_session')
                                                    <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                                @elseif($lesson->content_type === 'reading')
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                @else
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="text-xs sm:text-sm font-semibold text-slate-800">{{ $lesson->title }}</div>
                                                <div class="text-[11px] text-slate-400 capitalize">{{ str_replace('_', ' ', $lesson->content_type) }}</div>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            @if($lesson->is_free_preview)
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">Free Preview</span>
                                            @endif
                                            <span class="text-xs text-slate-400 font-mono">{{ $lesson->duration_minutes }}m</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-xs text-slate-400">Lessons being finalized by instructor.</div>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center bg-white rounded-xl border border-slate-200 text-xs text-slate-500">
                            Curriculum outline is currently in active development.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Instructor Profile Box -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8">
                <h2 class="text-xl font-bold font-serif-title text-slate-900 mb-4">About the Instructor</h2>
                <div class="flex flex-col sm:flex-row items-start gap-4">
                    <div class="w-16 h-16 rounded-full bg-slate-900 text-white font-bold text-lg flex items-center justify-center shrink-0">
                        {{ substr($course->instructor_name ?: 'BA', 0, 2) }}
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900">{{ $course->instructor_name ?: 'Brands Academy Senior Faculty' }}</h3>
                        <p class="text-xs font-semibold text-blue-600 mb-2">{{ $course->instructor_title ?: 'Faculty Lead' }}</p>
                        <p class="text-xs text-slate-600 leading-relaxed font-light">
                            {{ $course->instructor_bio ?: 'Leading specialist with extensive consulting and academic credentials across brand architecture, corporate identity, and intellectual property.' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Student Reviews & Ratings -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-200">
                    <div>
                        <h2 class="text-xl font-bold font-serif-title text-slate-900">Student Reviews & Ratings</h2>
                        <p class="text-xs text-slate-500 mt-1">Verified evaluations from enrolled professionals and brand practitioners.</p>
                    </div>
                    <div class="flex items-center gap-3 bg-amber-50 px-4 py-2.5 rounded-xl border border-amber-200 shrink-0">
                        <div class="text-2xl font-black text-amber-600">{{ $course->averageRating() }}</div>
                        <div>
                            <div class="flex text-amber-400 text-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    <span>{{ $i <= round($course->averageRating()) ? '★' : '☆' }}</span>
                                @endfor
                            </div>
                            <div class="text-[11px] text-amber-900 font-medium">{{ $course->reviews->count() }} {{ \Illuminate\Support\Str::plural('review', $course->reviews->count()) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Submit / Edit Review for Enrolled Learners -->
                @if($isEnrolled)
                    <div class="mt-6 p-5 bg-slate-50 rounded-xl border border-slate-200">
                        <h3 class="text-sm font-bold text-slate-900 mb-2">
                            {{ $userReview ? 'Update Your Course Evaluation' : 'Leave Your Course Evaluation' }}
                        </h3>
                        <p class="text-xs text-slate-600 mb-4">Share feedback on course curriculum, instructor delivery, and practical applicability.</p>

                        <form method="POST" action="{{ route('courses.reviews.store', $course->slug) }}" class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Your Rating *</label>
                                    <select name="rating" required class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="5" @selected(old('rating', $userReview?->rating ?? 5) == 5)>★★★★★ (5 - Excellent)</option>
                                        <option value="4" @selected(old('rating', $userReview?->rating) == 4)>★★★★☆ (4 - Very Good)</option>
                                        <option value="3" @selected(old('rating', $userReview?->rating) == 3)>★★★☆☆ (3 - Good)</option>
                                        <option value="2" @selected(old('rating', $userReview?->rating) == 2)>★★☆☆☆ (2 - Fair)</option>
                                        <option value="1" @selected(old('rating', $userReview?->rating) == 1)>★☆☆☆☆ (1 - Needs Improvement)</option>
                                    </select>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Headline / Summary (Optional)</label>
                                    <input type="text" name="title" value="{{ old('title', $userReview?->title) }}" placeholder="e.g. Masterful synthesis of IP law & corporate branding" class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Detailed Review *</label>
                                <textarea name="comment" rows="3" required placeholder="What were the biggest takeaways? How did this course impact your strategic thinking or day-to-day workflow?" class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">{{ old('comment', $userReview?->comment) }}</textarea>
                            </div>
                            <div class="flex items-center justify-end">
                                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs rounded-lg shadow-xs transition-colors">
                                    {{ $userReview ? 'Update Evaluation' : 'Submit Evaluation' }}
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="mt-6 p-4 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between text-xs text-slate-600">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Enrolled learners can submit verified ratings and course evaluations.</span>
                        </div>
                        @if(!auth()->check())
                            <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:underline">Sign In</a>
                        @endif
                    </div>
                @endif

                <!-- Reviews Feed -->
                <div class="mt-6 space-y-4">
                    @forelse($course->reviews as $review)
                        <div class="p-4 rounded-xl border border-slate-100 bg-slate-50/50 space-y-2">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-800 text-white text-xs font-bold flex items-center justify-center uppercase">
                                        {{ substr($review->user->name ?? 'Student', 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-slate-900 flex items-center gap-2">
                                            <span>{{ $review->user->name ?? 'Verified Learner' }}</span>
                                            @if($review->is_verified_learner)
                                                <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                                    <svg class="w-2.5 h-2.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Verified Enrolled
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-[11px] text-slate-400">{{ $review->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div class="flex text-amber-400 text-xs shrink-0">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                    @endfor
                                </div>
                            </div>
                            @if($review->title)
                                <div class="text-xs font-bold text-slate-900">{{ $review->title }}</div>
                            @endif
                            <p class="text-xs text-slate-700 leading-relaxed font-light">{!! nl2br(e($review->comment)) !!}</p>
                        </div>
                    @empty
                        <div class="p-6 text-center text-xs text-slate-400">
                            No student evaluations published yet. Enrolled learners can submit reviews upon completing modules.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <!-- Office Hours Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
                <div class="flex items-center gap-2.5 mb-3 text-purple-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    <h3 class="text-sm font-bold text-slate-900">Instructor Office Hours</h3>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed mb-4">
                    Enrolled students can book direct 1-on-1 Google Meet video consultations with the course instructor to review portfolios and strategic queries.
                </p>
                <div class="p-3 bg-purple-50 rounded-xl border border-purple-200 text-xs text-purple-900">
                    <span class="font-bold">Google Meet Video Sessions:</span> Included with enrollment at no extra cost.
                </div>
            </div>

            <!-- Certification Card -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
                <div class="flex items-center gap-2.5 mb-3 text-emerald-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                    <h3 class="text-sm font-bold text-slate-900">Certificate of Completion</h3>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed mb-4">
                    Upon completing all video modules, study readings, and scoring 80%+ on the end-of-course timed quiz, you receive a verifiable digital credential with an official verification QR code.
                </p>
                <div class="text-[11px] text-slate-400">Verifiable by employers and institutions worldwide via <span class="font-mono text-slate-600">brandsacademy.org.ng/verify</span></div>
            </div>
        </div>
    </div>
</section>

@endsection
