@extends('layouts.app')

@section('title', $workshop->title . ' - Brands Academy')

@push('styles')
<style>
    @keyframes checkmarkPop {
        0% { transform: scale(0) rotate(-15deg); opacity: 0; }
        60% { transform: scale(1.2) rotate(4deg); opacity: 1; }
        100% { transform: scale(1) rotate(0deg); opacity: 1; }
    }
    @keyframes strokeCheck {
        0% { stroke-dashoffset: 32; }
        100% { stroke-dashoffset: 0; }
    }
    .anim-check-pop {
        animation: checkmarkPop 0.36s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        transform-origin: center center;
    }
    .anim-check-stroke {
        stroke-dasharray: 32;
        stroke-dashoffset: 32;
        animation: strokeCheck 0.32s cubic-bezier(0.65, 0, 0.45, 1) 0.08s forwards;
    }
    .field-interactive {
        transition: border-color 0.22s ease, box-shadow 0.22s ease, background-color 0.22s ease, transform 0.15s ease;
    }
</style>
@endpush

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
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{ memberSidebarDrawerOpen: false }">

    @if(auth()->check() && auth()->user()->member)
        <!-- Member Recognition & Sidebar Shortcut Banner -->
        <div class="mb-8 p-4 sm:p-5 rounded-2xl bg-amber-500/10 border-2 border-amber-500/30 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-slate-900 shadow-xs">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-400 via-amber-500 to-amber-600 text-slate-950 font-extrabold text-base flex items-center justify-center font-serif-title shadow-sm ring-2 ring-amber-500/30 shrink-0">
                    {{ substr(auth()->user()->member->first_name, 0, 1) }}{{ substr(auth()->user()->member->last_name, 0, 1) }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-extrabold text-sm text-slate-900">{{ auth()->user()->member->full_name }}</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-white border border-amber-300 text-amber-900">{{ auth()->user()->member->member_number }}</span>
                        <span class="hidden sm:inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full text-[9px] font-bold bg-emerald-100 text-emerald-800">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Active Member
                        </span>
                    </div>
                    <p class="text-xs text-slate-600 mt-0.5">
                        Your <strong>25% Member Tuition Discount</strong> is active on this cohort &bull; You do not need to register again.
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2.5 shrink-0">
                <button type="button" @click="memberSidebarDrawerOpen = true" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-white hover:bg-amber-50 text-slate-800 border border-slate-300 hover:border-amber-400 transition-colors shadow-2xs flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <span>Open Member Sidebar</span>
                </button>
                <a href="{{ route('member.dashboard') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors shadow-xs flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Member Dashboard &rarr;</span>
                </a>
            </div>
        </div>
    @endif

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

                    <!-- Tuition & Member Discount Pricing Pill -->
                    <div class="mt-4 p-3.5 rounded-xl border {{ $workshop->fee_type == 'free' ? 'bg-emerald-50/70 border-emerald-200' : 'bg-amber-50/40 border-amber-200' }}">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Cohort Tuition</span>
                            @if($workshop->fee_type == 'free')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">100% Free Track</span>
                            @else
                                <span class="text-[10px] font-extrabold text-amber-900 bg-amber-200/80 px-2 py-0.5 rounded-full border border-amber-300">
                                    {{ $workshop->member_discount_percentage }}% Member Discount
                                </span>
                            @endif
                        </div>

                        @if($workshop->fee_type !== 'free')
                            <div class="mt-2 flex items-baseline justify-between">
                                @if(auth()->check() && auth()->user()->member)
                                    <div>
                                        <div class="flex items-baseline gap-2">
                                            <span class="text-xl font-extrabold text-slate-900 font-mono">NGN {{ number_format($workshop->member_fee_amount) }}</span>
                                            <span class="text-xs text-slate-400 line-through">NGN {{ number_format($workshop->fee_amount) }}</span>
                                        </div>
                                        <span class="text-[11px] font-semibold text-emerald-700 block mt-0.5">
                                            ✓ 25% Member rate applied (Save NGN {{ number_format($workshop->member_discount_savings) }})
                                        </span>
                                    </div>
                                @else
                                    <div>
                                        <div class="flex items-baseline gap-2">
                                            <span class="text-xl font-extrabold text-slate-900 font-mono">NGN {{ number_format($workshop->fee_amount) }}</span>
                                        </div>
                                        <div class="text-[11px] text-amber-800 mt-0.5 font-medium">
                                            Registered members pay <strong>NGN {{ number_format($workshop->member_fee_amount) }}</strong> (25% discount)
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
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
                    @if(session('error'))
                        <div class="mb-4 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs anim-check-pop flex items-start gap-2">
                            <svg class="w-4 h-4 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div>
                                <span class="font-bold block">Application Notice</span>
                                <span>{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs anim-check-pop">
                            <div class="font-bold flex items-center gap-1.5 mb-1 text-rose-900">
                                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <span>Please correct the following:</span>
                            </div>
                            <ul class="list-disc list-inside space-y-0.5 text-[11px] text-rose-700">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @php 
                        $isAuthMember = auth()->check() && auth()->user()->member;
                        $currentMember = $isAuthMember ? auth()->user()->member : null;
                    @endphp

                    @if($isAuthMember)
                        <!-- STREAMLINED 1-CLICK MEMBER APPLICATION FORM (NO RE-REGISTRATION NEEDED) -->
                        <div x-data="{ isSubmitting: false, statement: @js(old('statement_of_purpose', '')) }">
                            <h3 class="text-lg font-bold text-slate-900 mb-1 font-serif-title">Submit Member Application</h3>
                            <p class="text-xs text-slate-500 mb-4">Fast-track admission for registered Foundation members.</p>

                            <!-- Profile Recognition Card -->
                            <div class="p-4 rounded-2xl bg-amber-500/10 border-2 border-amber-500/30 text-slate-900 mb-5">
                                <div class="flex items-start justify-between gap-3 mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="w-7 h-7 rounded-lg bg-amber-500 text-slate-950 flex items-center justify-center font-bold text-xs shrink-0">
                                            ✓
                                        </span>
                                        <div>
                                            <span class="text-[10px] uppercase font-bold text-amber-800 block tracking-wider">Account Recognized &bull; Registered Member</span>
                                            <span class="font-bold text-sm text-slate-900">{{ $currentMember->full_name }}</span>
                                        </div>
                                    </div>
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold font-mono bg-white border border-amber-300 text-amber-900 shrink-0">
                                        {{ $currentMember->member_number ?? 'Member' }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-600 leading-relaxed mb-3">
                                    The system already has your details on file (<strong>{{ $currentMember->email }}</strong> &bull; <strong>{{ $currentMember->phone }}</strong>). You do not need to register again!
                                </p>
                                @if($workshop->fee_type !== 'free')
                                    <div class="p-3 rounded-xl bg-white border border-amber-200 text-xs text-slate-800 flex items-center justify-between">
                                        <span class="font-medium text-slate-600">Your Discounted Dues:</span>
                                        <div class="text-right">
                                            <span class="font-extrabold font-mono text-emerald-700 text-sm">NGN {{ number_format($workshop->member_fee_amount) }}</span>
                                            <span class="text-[10px] text-slate-400 line-through ml-1.5">NGN {{ number_format($workshop->fee_amount) }}</span>
                                            <span class="text-[10px] font-bold text-emerald-800 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200 ml-1">25% OFF</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <form action="{{ route('workshops.apply', $workshop->slug) }}" method="POST" @submit="isSubmitting = true" class="space-y-4">
                                @csrf
                                <input type="hidden" name="applicant_name" value="{{ $currentMember->full_name }}">
                                <input type="hidden" name="applicant_email" value="{{ $currentMember->email }}">
                                <input type="hidden" name="applicant_phone" value="{{ $currentMember->phone }}">
                                <input type="hidden" name="applicant_organization" value="{{ $currentMember->institution_or_company }}">

                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="block text-xs font-bold text-slate-700 uppercase">Statement of Purpose / Learning Goals *</label>
                                        <span class="text-[10px] text-slate-400" x-text="(statement || '').length + ' characters'"></span>
                                    </div>
                                    <textarea name="statement_of_purpose" x-model="statement" rows="3" required placeholder="Why do you wish to join this cohort and what are your learning goals?" class="w-full px-3.5 py-2.5 rounded-xl border @error('statement_of_purpose') border-rose-400 ring-2 ring-rose-400/20 bg-rose-50/10 @else border-slate-300 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('statement_of_purpose') }}</textarea>
                                    @error('statement_of_purpose')
                                        <p class="text-xs text-rose-600 font-semibold mt-1 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                            <span>{{ $message }}</span>
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Portfolio or Profile URL (Optional)</label>
                                    <input type="url" name="portfolio_link" value="{{ old('portfolio_link') }}" placeholder="https://behance.net/yourprofile or LinkedIn" class="w-full px-3.5 py-2.5 rounded-xl border @error('portfolio_link') border-rose-400 @else border-slate-300 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                                    @error('portfolio_link')
                                        <p class="text-xs text-rose-600 font-semibold mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                @if($workshop->fee_type !== 'free')
                                    <div class="pt-2 border-t border-slate-100">
                                        <label class="flex items-start gap-2 cursor-pointer text-xs text-slate-700">
                                            <input type="checkbox" name="scholarship_requested" value="1" {{ old('scholarship_requested') ? 'checked' : '' }} class="mt-0.5 rounded text-amber-600 focus:ring-amber-500">
                                            <span>Request Additional Educational Subsidy / Scholarship Consideration</span>
                                        </label>
                                    </div>
                                @endif

                                <button type="submit" :disabled="isSubmitting" class="w-full py-3.5 px-4 rounded-xl text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-75">
                                    <svg x-show="isSubmitting" class="w-4 h-4 animate-spin text-slate-950" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <span>Submit Application (25% Discount Applied) &rarr;</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <!-- STANDARD FORM FOR GUEST / PUBLIC APPLICANTS -->
                        <div x-data="workshopApplicationForm({
                            initialName: @js(old('applicant_name', '')),
                            initialEmail: @js(old('applicant_email', '')),
                            initialPhone: @js(old('applicant_phone', '')),
                            initialStatement: @js(old('statement_of_purpose', ''))
                        })">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-bold text-slate-900 font-serif-title">Submit Application</h3>
                            </div>

                            <!-- Member Sign-In Callout -->
                            <div class="mb-4 p-3 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-900 flex items-center justify-between gap-2">
                                <span>Are you a Foundation Member?</span>
                                <a href="{{ route('login') }}" class="font-bold underline hover:text-amber-700 whitespace-nowrap">
                                    Sign In for 25% Discount &rarr;
                                </a>
                            </div>

                            <p class="text-xs text-slate-500 mb-4">Complete this short form to apply for cohort admissions.</p>

                            <form action="{{ route('workshops.apply', $workshop->slug) }}" method="POST" @submit="isSubmitting = true" class="space-y-4">
                                @csrf
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="block text-xs font-bold text-slate-700 uppercase">Full Name *</label>
                                        <span x-show="isNameValid" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                                            <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 flex items-center justify-center">
                                                <svg class="w-2.5 h-2.5 anim-check-stroke text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                            </span>
                                            <span>Valid</span>
                                        </span>
                                    </div>
                                    <input type="text" name="applicant_name" x-model="name" required
                                           class="w-full px-3.5 py-2.5 rounded-xl border text-sm field-interactive focus:outline-none"
                                           :class="isNameValid ? 'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10' : 'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20'">
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <div class="flex items-center justify-between mb-1">
                                            <label class="block text-xs font-bold text-slate-700 uppercase">Email *</label>
                                            <span x-show="isEmailValid" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                                                <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 flex items-center justify-center">
                                                    <svg class="w-2.5 h-2.5 anim-check-stroke text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                </span>
                                                <span>Valid</span>
                                            </span>
                                        </div>
                                        <input type="email" name="applicant_email" x-model="email" required
                                               class="w-full px-3.5 py-2.5 rounded-xl border text-sm field-interactive focus:outline-none"
                                               :class="isEmailValid ? 'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10' : 'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20'">
                                    </div>
                                    <div>
                                        <div class="flex items-center justify-between mb-1">
                                            <label class="block text-xs font-bold text-slate-700 uppercase">Phone *</label>
                                            <div class="flex items-center gap-1.5">
                                                <span x-show="phoneCarrier" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[9px] font-bold text-amber-800 bg-amber-50 px-1.5 py-0.5 rounded border border-amber-200">
                                                    <span class="w-1 h-1 rounded-full bg-emerald-500"></span>
                                                    <span x-text="phoneCarrier"></span>
                                                </span>
                                                <span x-show="isPhoneValid" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                                                    <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 flex items-center justify-center">
                                                        <svg class="w-2.5 h-2.5 anim-check-stroke text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                    </span>
                                                    <span>Valid</span>
                                                </span>
                                            </div>
                                        </div>
                                        <input type="text" name="applicant_phone" x-model="phone" @blur="formatPhone()" required placeholder="+234..."
                                               class="w-full px-3.5 py-2.5 rounded-xl border text-sm field-interactive focus:outline-none"
                                               :class="isPhoneValid ? 'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10' : 'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20'">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Organization / University</label>
                                    <input type="text" name="applicant_organization" value="{{ old('applicant_organization') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                                </div>

                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="block text-xs font-bold text-slate-700 uppercase">Statement of Purpose / Goals *</label>
                                        <span class="text-[10px] text-slate-400" x-text="(statement || '').length + ' characters'"></span>
                                    </div>
                                    <textarea name="statement_of_purpose" x-model="statement" rows="3" required placeholder="Why do you wish to join this cohort and what are your learning goals?" class="w-full px-3.5 py-2.5 rounded-xl border @error('statement_of_purpose') border-rose-400 ring-2 ring-rose-400/20 bg-rose-50/10 @else border-slate-300 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('statement_of_purpose') }}</textarea>
                                    @error('statement_of_purpose')
                                        <p class="text-xs text-rose-600 font-semibold mt-1 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                            <span>{{ $message }}</span>
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Portfolio or Profile URL (Optional)</label>
                                    <input type="url" name="portfolio_link" value="{{ old('portfolio_link') }}" placeholder="https://behance.net/yourprofile or LinkedIn" class="w-full px-3.5 py-2.5 rounded-xl border @error('portfolio_link') border-rose-400 @else border-slate-300 @enderror text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                                    @error('portfolio_link')
                                        <p class="text-xs text-rose-600 font-semibold mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                @if($workshop->fee_type !== 'free')
                                    <div class="pt-2 border-t border-slate-100">
                                        <label class="flex items-start gap-2 cursor-pointer text-xs text-slate-700">
                                            <input type="checkbox" name="scholarship_requested" value="1" {{ old('scholarship_requested') ? 'checked' : '' }} class="mt-0.5 rounded text-amber-600 focus:ring-amber-500">
                                            <span>Request Foundation Educational Subsidy / Scholarship Consideration</span>
                                        </label>
                                    </div>
                                @endif

                                <button type="submit" :disabled="isSubmitting" class="w-full py-3.5 px-4 rounded-xl text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-75">
                                    <svg x-show="isSubmitting" class="w-4 h-4 animate-spin text-slate-950" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <span>Submit Cohort Application</span>
                                </button>
                            </form>
                        </div>
                    @endif


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

    @if(auth()->check() && auth()->user()->member)
        <!-- Slide-Out Member Sidebar Drawer for Workshop Page -->
        <div x-show="memberSidebarDrawerOpen" x-cloak
             class="fixed inset-0 z-50 overflow-hidden"
             role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm transition-opacity"
                 x-show="memberSidebarDrawerOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="memberSidebarDrawerOpen = false"></div>

            <!-- Sliding Panel -->
            <div class="fixed inset-y-0 left-0 max-w-sm w-full bg-slate-50 shadow-2xl flex flex-col z-10 overflow-y-auto p-5"
                 x-show="memberSidebarDrawerOpen"
                 x-transition:enter="ease-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="ease-in duration-200 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full">

                <div class="flex items-center justify-between pb-4 mb-3 border-b border-slate-200">
                    <span class="font-serif-title font-bold text-slate-900 text-sm">Member Portal Navigation</span>
                    <button type="button" @click="memberSidebarDrawerOpen = false" class="p-1.5 rounded-lg text-slate-500 hover:text-slate-900 hover:bg-slate-200 transition-colors cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <x-member-sidebar />
            </div>
        </div>
    @endif
</section>

@endsection

@push('scripts')
<script>
    function workshopApplicationForm(config) {
        return {
            name: config.initialName || '',
            email: config.initialEmail || '',
            phone: config.initialPhone || '',
            statement: config.initialStatement || '',
            isSubmitting: false,

            get isNameValid() {
                return (this.name || '').trim().length >= 3;
            },

            get isEmailValid() {
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test((this.email || '').trim());
            },

            get isPhoneValid() {
                const digits = (this.phone || '').replace(/[^0-9]/g, '');
                return digits.length >= 10 && digits.length <= 15;
            },

            get phoneCarrier() {
                const raw = (this.phone || '').replace(/[^0-9]/g, '');
                let prefix = '';
                if (raw.startsWith('234') && raw.length >= 6) {
                    prefix = '0' + raw.substring(3, 6);
                } else if (raw.startsWith('0') && raw.length >= 4) {
                    prefix = raw.substring(0, 4);
                }
                const mtn = ['0803', '0806', '0703', '0706', '0813', '0816', '0810', '0814', '0903', '0906', '0913', '0916'];
                const airtel = ['0802', '0808', '0708', '0812', '0701', '0902', '0901', '0904', '0907', '0912'];
                const glo = ['0805', '0807', '0705', '0815', '0811', '0905', '0915'];
                const nineMobile = ['0809', '0817', '0818', '0909', '0908'];

                if (mtn.includes(prefix)) return 'MTN';
                if (airtel.includes(prefix)) return 'Airtel';
                if (glo.includes(prefix)) return 'Glo';
                if (nineMobile.includes(prefix)) return '9mobile';
                return '';
            },

            formatPhone() {
                let cleaned = (this.phone || '').trim().replace(/[^\d+]/g, '');
                if (cleaned.startsWith('0') && cleaned.length === 11) {
                    cleaned = '+234 ' + cleaned.substring(1, 4) + ' ' + cleaned.substring(4, 7) + ' ' + cleaned.substring(7);
                }
                this.phone = cleaned;
            }
        };
    }
</script>
@endpush
