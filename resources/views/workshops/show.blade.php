@extends('layouts.app')

@section('title', $workshop->title . ' - Brands Academy')

@section('content')

@php $window = $workshop->application_window_status; @endphp

<!-- Workshop Header Banner -->
<section class="bg-slate-900 text-white py-16 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <div class="flex flex-wrap items-center gap-3 mb-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $window['badge_class'] }}">
                    {{ $window['label'] }} &bull; {{ $window['detail'] }}
                </span>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                    Mode: {{ ucfirst($workshop->delivery_mode) }}
                </span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold font-serif-title mb-4 leading-tight">
                {{ $workshop->title }}
            </h1>

            <p class="text-amber-400 font-semibold text-sm sm:text-base mb-6">
                {{ $workshop->track_label }}
            </p>

            @if($workshop->tagline)
                <p class="text-slate-300 text-base leading-relaxed font-light">
                    {{ $workshop->tagline }}
                </p>
            @endif
        </div>
    </div>
</section>

<!-- Content Grid: Details & Application Widget -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        
        <!-- Left 7 cols: Syllabus, Overview & Details -->
        <div class="lg:col-span-7 space-y-8">
            
            <!-- Description -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-xs">
                <h2 class="text-xl font-bold text-slate-900 mb-4 font-serif-title">Programme Overview</h2>
                <div class="text-slate-600 text-sm sm:text-base leading-relaxed space-y-4">
                    <p>{{ $workshop->description }}</p>
                </div>
            </div>

            <!-- Curriculum Topics -->
            @if(!empty($workshop->curriculum_topics) && is_array($workshop->curriculum_topics))
                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-xs">
                    <h2 class="text-xl font-bold text-slate-900 mb-4 font-serif-title">Curriculum & Core Modules</h2>
                    <ul class="space-y-3">
                        @foreach($workshop->curriculum_topics as $index => $topic)
                            <li class="flex items-start gap-3 text-sm text-slate-700">
                                <span class="w-6 h-6 rounded-full bg-amber-100 text-amber-800 text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">
                                    {{ $index + 1 }}
                                </span>
                                <span class="font-medium">{{ $topic }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Delivery & Faculty Details -->
            <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-xs">
                <h2 class="text-xl font-bold text-slate-900 mb-4 font-serif-title">Faculty & Venue</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-xs text-slate-400 block uppercase font-bold mb-1">Lead Instructor / Mentor</span>
                        <span class="font-bold text-slate-800">{{ $workshop->instructor_name ?? 'Brands Academy Faculty & Industry Fellows' }}</span>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-xs text-slate-400 block uppercase font-bold mb-1">Location / Training Studio</span>
                        <span class="font-bold text-slate-800">{{ $workshop->venue ?? 'Virtual Cohort Studio & Kaduna Learning Hub' }}</span>
                    </div>
                </div>
            </div>

            <!-- Verifiable Certificate Notice -->
            <div class="bg-amber-50/70 p-6 rounded-2xl border border-amber-200 flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-amber-500 text-slate-950 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm mb-1">Official Digital Credential Included</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Upon successful evaluation by faculty and mentors, graduates receive an official <strong>Certificate of Achievement</strong> with a verifiable QR code delivered directly to their email.
                    </p>
                </div>
            </div>

        </div>

        <!-- Right 5 cols: Window Status & Application Form Box -->
        <div class="lg:col-span-5">
            <div class="bg-white rounded-2xl border-2 border-slate-200 p-6 sm:p-8 shadow-lg sticky top-24">
                
                <!-- Cohort Meta Summary -->
                <div class="mb-6 pb-6 border-b border-slate-100">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Admissions Status</span>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $window['badge_class'] }}">
                            {{ $window['label'] }}
                        </span>
                        <span class="text-xs text-slate-600 font-semibold">{{ $window['detail'] }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mt-4 text-xs">
                        <div class="p-3 rounded-lg bg-slate-50">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Application Deadline</span>
                            <span class="font-bold text-slate-900">{{ $workshop->application_deadline->format('M d, Y') }}</span>
                        </div>
                        <div class="p-3 rounded-lg bg-slate-50">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Commencement</span>
                            <span class="font-bold text-slate-900">{{ $workshop->starts_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Window Case 1: Application Already Submitted -->
                @if($alreadyApplied)
                    <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-5 text-emerald-900 text-center">
                        <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h4 class="font-bold text-base mb-1">Application Submitted!</h4>
                        <p class="text-xs text-emerald-700 mb-3">
                            You have submitted an application for this cohort.
                        </p>
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase bg-white border border-emerald-300 text-emerald-800">
                            Status: {{ ucfirst($existingApplication->status) }}
                        </span>
                    </div>

                <!-- Window Case 2: Window IS OPEN FOR APPLICATIONS -->
                @elseif($workshop->isOpenForApplications())
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 mb-1">Submit Your Application</h3>
                        <p class="text-xs text-slate-500 mb-4">Complete this short form to apply for cohort admissions.</p>

                        @auth
                            @if(auth()->user()->member)
                                <div class="p-3 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-900 mb-4 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-amber-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>Applying as Registered Member: <strong>{{ auth()->user()->member->member_number }}</strong></span>
                                </div>
                            @endif
                        @endauth

                        <form action="{{ route('workshops.apply', $workshop->slug) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Full Name *</label>
                                <input type="text" name="applicant_name" value="{{ old('applicant_name', auth()->user()?->name ?? '') }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email *</label>
                                    <input type="email" name="applicant_email" value="{{ old('applicant_email', auth()->user()?->email ?? '') }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Phone Number *</label>
                                    <input type="text" name="applicant_phone" value="{{ old('applicant_phone', auth()->user()?->member?->phone ?? '') }}" required placeholder="+234..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Organization / University</label>
                                <input type="text" name="applicant_organization" value="{{ old('applicant_organization', auth()->user()?->member?->institution_or_company ?? '') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Statement of Purpose / Goals *</label>
                                <textarea name="statement_of_purpose" rows="3" required placeholder="Why do you wish to join this cohort and what are your learning goals?" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('statement_of_purpose') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Portfolio or Profile URL (Optional)</label>
                                <input type="url" name="portfolio_link" value="{{ old('portfolio_link') }}" placeholder="https://behance.net/yourprofile or LinkedIn" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>

                            @if($workshop->fee_type !== 'free')
                                <div class="pt-2 border-t border-slate-100">
                                    <label class="flex items-start gap-2 cursor-pointer text-xs text-slate-700">
                                        <input type="checkbox" name="scholarship_requested" value="1" {{ old('scholarship_requested') ? 'checked' : '' }} class="mt-0.5 rounded text-amber-600 focus:ring-amber-500">
                                        <span>Request Foundation Educational Subsidy / Scholarship Consideration</span>
                                    </label>
                                </div>
                            @endif

                            <button type="submit" class="w-full py-3.5 px-4 rounded-xl text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md transition-all">
                                Submit Cohort Application
                            </button>
                        </form>
                    </div>

                <!-- Window Case 3: UPCOMING (NOT YET OPEN) -->
                @elseif($workshop->isUpcoming())
                    <div class="text-center py-6">
                        <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="font-bold text-base text-slate-900 mb-1">Applications Open Soon</h4>
                        <p class="text-xs text-slate-600 leading-relaxed mb-6">
                            The application window for this cohort opens on <strong>{{ $workshop->application_starts_at->format('F d, Y') }}</strong> ({{ $workshop->application_starts_at->diffForHumans() }}).
                        </p>
                        <a href="{{ route('membership.register') }}" class="w-full inline-flex justify-center py-3 px-4 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white transition-colors">
                            Register as Member for Priority Access
                        </a>
                    </div>

                <!-- Window Case 4: CLOSED (DEADLINE PASSED) -->
                @else
                    <div class="text-center py-6">
                        <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <h4 class="font-bold text-base text-slate-900 mb-1">Applications Closed</h4>
                        <p class="text-xs text-slate-600 leading-relaxed mb-4">
                            The application deadline for this cohort closed on <strong>{{ $workshop->application_deadline->format('F d, Y') }}</strong>. Admissions assessment is currently underway.
                        </p>
                        <a href="{{ route('workshops.index') }}" class="text-xs font-bold text-amber-600 hover:underline">
                            Browse currently open cohorts &rarr;
                        </a>
                    </div>
                @endif

            </div>
        </div>

    </div>
</section>

@endsection
