@extends(auth()->check() && auth()->user()->member ? 'layouts.member' : 'layouts.app')

@section('title', $webinar->title . ' - Webinar')
@section('page_title', $webinar->title)
@section('meta_description', Str::limit(strip_tags($webinar->summary ?: $webinar->description), 160))
@section('og_type', 'article')

@section('content')

<!-- Header -->
<section class="bg-slate-900 text-white py-12 lg:py-16 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
            <div class="lg:col-span-2">
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $webinar->isLive() ? 'bg-rose-500/20 text-rose-300 border border-rose-500/30' : 'bg-purple-500/20 text-purple-300 border border-purple-500/30' }}">
                        {{ $webinar->isLive() ? 'Live Now' : 'Virtual Masterclass' }}
                    </span>
                    <span class="text-xs text-slate-400 font-mono">Google Meet Video</span>
                </div>

                <h1 class="text-3xl sm:text-4xl font-extrabold font-serif-title text-white mb-4 leading-tight">
                    {{ $webinar->title }}
                </h1>

                <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-6 font-light">
                    {{ $webinar->summary ?: 'Join this interactive session with Brands Academy faculty and brand practitioners.' }}
                </p>

                <!-- Date & Time Row -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 py-4 border-y border-slate-800 text-xs">
                    <div>
                        <div class="text-slate-400">Date & Time</div>
                        <div class="font-bold text-white text-sm mt-0.5">{{ $webinar->starts_at->format('M d, Y • h:i A') }}</div>
                    </div>
                    <div>
                        <div class="text-slate-400">Duration</div>
                        <div class="font-bold text-white text-sm mt-0.5">{{ $webinar->duration_minutes }} Minutes</div>
                    </div>
                    <div>
                        <div class="text-slate-400">Platform</div>
                        <div class="font-bold text-purple-400 text-sm mt-0.5">Google Meet Room</div>
                    </div>
                </div>

                <!-- Speaker Bio -->
                <div class="flex items-start gap-4 mt-8 bg-slate-800/50 p-6 rounded-2xl border border-slate-800">
                    <div class="w-14 h-14 rounded-full bg-purple-600 text-white font-bold text-base flex items-center justify-center uppercase shrink-0 ring-2 ring-purple-400/40">
                        {{ substr($webinar->speaker_name, 0, 2) }}
                    </div>
                    <div>
                        <span class="text-[11px] font-bold text-purple-400 uppercase tracking-wider">Featured Keynote Speaker</span>
                        <h3 class="text-base font-bold text-white">{{ $webinar->speaker_name }}</h3>
                        <p class="text-xs text-slate-400 mb-2">{{ $webinar->speaker_title ?: 'Brand Specialist' }}</p>
                        <p class="text-xs text-slate-300 leading-relaxed font-light">
                            {{ $webinar->speaker_bio ?: 'Recognized leader and mentor with proven track record in high-impact brand transformation and marketing strategy.' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- RSVP / Access Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl p-6 sm:p-8 text-slate-900 border border-slate-200 shadow-xl sticky top-24">
                    @if(session('success'))
                        <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($isRegistered)
                        <!-- Confirmed Registration Details -->
                        <div class="text-center py-4">
                            <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">Your RSVP is Confirmed!</h3>
                            <p class="text-xs text-slate-500 mt-1 mb-6">Your registration token is <span class="font-mono font-bold text-slate-800">{{ $registration->token }}</span></p>

                            <div class="space-y-3">
                                @if($webinar->meeting_link)
                                    <a href="{{ $webinar->meeting_link }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-bold text-sm shadow-md transition-all">
                                        <span>Join Google Meet</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                @endif

                                <a href="{{ route('webinars.calendar', $webinar->slug) }}" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs border border-slate-200 transition-all">
                                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>Download .ICS Calendar Invite</span>
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- Registration Form -->
                        <div class="mb-4">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Registration</span>
                            <div class="text-2xl font-extrabold text-slate-900 mt-0.5">
                                {{ $webinar->formattedPrice() }}
                            </div>
                            @if($isDiscounted)
                                <div class="text-xs font-bold text-emerald-700 mt-1">25% Member discount applied</div>
                            @endif
                        </div>

                        <form method="POST" action="{{ route('webinars.register', $webinar->slug) }}" class="space-y-3.5">
                            @csrf
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">First Name *</label>
                                    <input type="text" name="first_name" required value="{{ auth()->check() ? explode(' ', auth()->user()->name)[0] : old('first_name') }}" class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Last Name *</label>
                                    <input type="text" name="last_name" required value="{{ auth()->check() ? (explode(' ', auth()->user()->name)[1] ?? '') : old('last_name') }}" class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Work / Personal Email *</label>
                                <input type="email" name="email" required value="{{ auth()->check() ? auth()->user()->email : old('email') }}" class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Phone Number (Optional)</label>
                                <input type="text" name="phone" placeholder="+234..." value="{{ old('phone') }}" class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Organization / Brand</label>
                                <input type="text" name="organization" placeholder="e.g. Acme Corp / Freelance" value="{{ old('organization') }}" class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg p-2.5 text-slate-900 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            </div>

                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-bold text-xs shadow-md transition-all mt-2">
                                <span>Complete RSVP & Get Link</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Overview Content -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2 space-y-8">
            <div>
                <h2 class="text-xl font-bold font-serif-title text-slate-900 mb-4">About this Masterclass</h2>
                <div class="prose prose-slate max-w-none text-xs sm:text-sm text-slate-700 leading-relaxed space-y-3">
                    {!! nl2br(e($webinar->description ?: $webinar->summary)) !!}
                </div>

                @if($webinar->recording_url)
                    <div class="mt-8 p-6 bg-slate-900 text-white rounded-2xl">
                        <h3 class="text-base font-bold mb-2">Session Recording / Replay</h3>
                        <p class="text-xs text-slate-400 mb-4">The recording for this session is available for on-demand streaming.</p>
                        <a href="{{ $webinar->recording_url }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs transition-all">
                            <span>Watch Recording</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Audience Questions & Speaker AMA Queue -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
                <div class="flex items-center justify-between pb-4 border-b border-slate-200">
                    <div>
                        <h3 class="text-lg font-bold font-serif-title text-slate-900">Speaker Q&A & Audience Queue</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Submit strategic questions in advance or upvote questions you want addressed during the live session.</p>
                    </div>
                    <span class="text-xs font-mono font-bold px-2.5 py-1 bg-purple-100 text-purple-800 rounded-full shrink-0">
                        {{ $questions->count() }} {{ \Illuminate\Support\Str::plural('Question', $questions->count()) }}
                    </span>
                </div>

                <!-- Submit Question Form -->
                <div class="mt-6 p-4 sm:p-5 bg-slate-50 rounded-xl border border-slate-200">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-2">Ask a Question for this Session</h4>
                    <form method="POST" action="{{ route('webinars.questions.store', $webinar->slug) }}" class="space-y-3">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Your Name *</label>
                                <input type="text" name="attendee_name" required value="{{ auth()->check() ? auth()->user()->name : old('attendee_name') }}" placeholder="Full Name" class="w-full text-xs rounded-lg border-slate-300 focus:ring-purple-500 focus:border-purple-500 bg-white">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Organization / Brand (Optional)</label>
                                <input type="text" name="attendee_organization" value="{{ old('attendee_organization') }}" placeholder="e.g. Acme Media / Brand Strategist" class="w-full text-xs rounded-lg border-slate-300 focus:ring-purple-500 focus:border-purple-500 bg-white">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Your Question *</label>
                            <textarea name="question" rows="3" required placeholder="What specific strategic challenge or query would you like the speaker to answer?" class="w-full text-xs rounded-lg border-slate-300 focus:ring-purple-500 focus:border-purple-500 bg-white leading-relaxed">{{ old('question') }}</textarea>
                        </div>
                        <div class="flex items-center justify-end">
                            <button type="submit" class="px-5 py-2 bg-purple-600 hover:bg-purple-500 text-white font-bold text-xs rounded-lg shadow-xs transition-colors">
                                Submit Question to Speaker
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Questions List -->
                <div class="mt-6 space-y-3">
                    @forelse($questions as $q)
                        <div class="p-4 rounded-xl border border-slate-100 bg-slate-50/60 flex items-start justify-between gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-slate-900">{{ $q->attendee_name }}</span>
                                    @if($q->attendee_organization)
                                        <span class="text-[11px] text-slate-500 font-normal">({{ $q->attendee_organization }})</span>
                                    @endif
                                    @if($q->is_answered)
                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">Answered Live</span>
                                    @endif
                                    <span class="text-[10px] text-slate-400">• {{ $q->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-xs text-slate-800 leading-relaxed font-light">{!! nl2br(e($q->question)) !!}</p>
                            </div>

                            <form method="POST" action="{{ route('webinars.questions.upvote', [$webinar->slug, $q->id]) }}" class="shrink-0">
                                @csrf
                                <button type="submit" class="flex flex-col items-center justify-center w-12 py-1.5 rounded-lg border border-slate-200 bg-white hover:border-purple-300 hover:bg-purple-50 text-slate-700 hover:text-purple-700 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                    <span class="text-[11px] font-bold font-mono">{{ $q->upvotes_count }}</span>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="p-6 text-center text-xs text-slate-400">
                            No audience questions submitted yet. Be the first to ask the speaker a question!
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
                <h3 class="text-sm font-bold text-slate-900 mb-3 flex items-center gap-2 text-purple-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Webinar Protocols</span>
                </h3>
                <ul class="text-xs text-slate-600 space-y-2.5 font-light">
                    <li class="flex items-start gap-2">
                        <span class="text-purple-600 font-bold">•</span>
                        <span>Sessions are hosted securely on <strong>Google Meet</strong> with high-definition audio and screen sharing.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-purple-600 font-bold">•</span>
                        <span>Audience members can ask questions live via audio or the advance text queue.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-purple-600 font-bold">•</span>
                        <span>Registered attendees receive calendar invites and reminder notifications prior to commencement.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

@endsection
