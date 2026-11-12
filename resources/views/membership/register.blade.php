@extends('layouts.app')

@section('title', 'Join the Foundation - Ongoing Membership Registration')

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
    .card-preview-glow {
        box-shadow: 0 20px 40px -15px rgba(245, 158, 11, 0.25), 0 0 0 1px rgba(245, 158, 11, 0.2);
    }
</style>
@endpush

@section('content')

<!-- Header Banner -->
<section class="bg-slate-900 text-white py-14 sm:py-16 border-b border-slate-800 relative overflow-hidden">
    <!-- Subtle background accent lights -->
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20 mb-3">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Ongoing Registration &bull; Open 24/7 Year-Round
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold font-serif-title mb-4 tracking-tight">
                Join Brands Academy Nigeria Foundation
            </h1>
            <p class="text-slate-300 text-sm sm:text-base leading-relaxed font-light">
                Membership connects you directly to our community of branding practitioners, educators, mentors, and corporate partners across Nigeria.
            </p>
        </div>
    </div>
</section>

<!-- Content Area with Alpine.js Reactive Form -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14"
         x-data="membershipRegistrationForm()">

    <!-- Top Completion Progress Bar -->
    <div class="mb-8 bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500/15 border border-amber-500/30 text-amber-600 flex items-center justify-center font-bold text-sm shrink-0">
                <span x-text="completionPercentage + '%'"></span>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-xs sm:text-sm font-bold text-slate-900">Application Readiness</span>
                    <span x-show="completionPercentage === 100" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                        <svg class="w-3 h-3 anim-check-stroke" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Ready to Submit
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-0.5" x-text="completionPercentage === 100 ? 'All mandatory fields verified. You can now submit your application!' : 'Complete the required fields below to issue your official digital member credential.'"></p>
            </div>
        </div>

        <!-- Visual Bar -->
        <div class="w-full md:w-72 shrink-0">
            <div class="flex items-center justify-between text-[11px] font-semibold text-slate-600 mb-1.5">
                <span>Verification Progress</span>
                <span class="text-amber-600 font-bold" x-text="completedFieldsCount + ' / 8 Required'"></span>
            </div>
            <div class="h-2.5 w-full bg-slate-100 rounded-full overflow-hidden p-0.5 border border-slate-200">
                <div class="h-full bg-gradient-to-r from-amber-500 to-emerald-500 rounded-full transition-all duration-300"
                     :style="'width: ' + completionPercentage + '%'"></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
        
        <!-- Left 7 cols: Interactive Registration Form -->
        <div class="lg:col-span-7 bg-white p-6 sm:p-10 rounded-3xl border border-slate-200 shadow-xl relative overflow-hidden">
            
            <!-- Top Gradient Accent line -->
            <div class="h-1.5 w-full bg-gradient-to-r from-amber-500 via-amber-400 to-emerald-500 absolute top-0 left-0"></div>

            <!-- 3-Step Visual Progress Breadcrumbs -->
            <div class="mb-8 pb-6 border-b border-slate-100">
                <div class="grid grid-cols-3 gap-2 sm:gap-4">
                    <!-- Step 1 -->
                    <div class="flex items-center gap-2 sm:gap-3">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all shrink-0"
                              :class="isStage1Complete ? 'bg-emerald-600 text-white shadow-sm' : 'bg-slate-900 text-white ring-2 ring-amber-500/20'">
                            <template x-if="isStage1Complete">
                                <svg class="w-4 h-4 anim-check-stroke" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </template>
                            <template x-if="!isStage1Complete">
                                <span>1</span>
                            </template>
                        </span>
                        <div class="min-w-0">
                            <span class="text-xs font-bold text-slate-900 block truncate">1. Personal</span>
                            <span class="text-[10px] text-slate-400 hidden sm:block truncate">Name &amp; Contact</span>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex items-center gap-2 sm:gap-3">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all shrink-0"
                              :class="isStage2Complete ? 'bg-emerald-600 text-white shadow-sm' : (isStage1Complete ? 'bg-slate-900 text-white ring-2 ring-amber-500/20' : 'bg-slate-100 text-slate-500 border border-slate-200')">
                            <template x-if="isStage2Complete">
                                <svg class="w-4 h-4 anim-check-stroke" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </template>
                            <template x-if="!isStage2Complete">
                                <span>2</span>
                            </template>
                        </span>
                        <div class="min-w-0">
                            <span class="text-xs font-bold text-slate-900 block truncate">2. Track</span>
                            <span class="text-[10px] text-slate-400 hidden sm:block truncate">Category &amp; State</span>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex items-center gap-2 sm:gap-3">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all shrink-0"
                              :class="isStage3Complete ? 'bg-emerald-600 text-white shadow-sm' : ((isStage1Complete && isStage2Complete) ? 'bg-slate-900 text-white ring-2 ring-amber-500/20' : 'bg-slate-100 text-slate-500 border border-slate-200')">
                            <template x-if="isStage3Complete">
                                <svg class="w-4 h-4 anim-check-stroke" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </template>
                            <template x-if="!isStage3Complete">
                                <span>3</span>
                            </template>
                        </span>
                        <div class="min-w-0">
                            <span class="text-xs font-bold text-slate-900 block truncate">3. Security</span>
                            <span class="text-[10px] text-slate-400 hidden sm:block truncate">Portal Password</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Title -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-slate-900 font-serif-title">Membership Application</h2>
                <p class="text-xs text-slate-500 mt-1">Please provide your details below. An official Member ID and verifiable digital credential will be generated upon submission.</p>
            </div>

            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-700 px-5 py-4 rounded-2xl mb-8 text-xs font-medium">
                    <div class="flex items-center gap-2 mb-1.5">
                        <svg class="w-4 h-4 text-rose-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <strong class="font-bold text-sm">Please correct the following:</strong>
                    </div>
                    <ul class="list-disc pl-6 space-y-1 opacity-90">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('membership.store') }}" method="POST" class="space-y-7">
                @csrf

                <!-- ================= SECTION 1: PERSONAL & CONTACT ================= -->
                <div>
                    <div class="flex items-center justify-between pb-2 mb-4 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <span class="w-6 h-6 rounded-lg bg-amber-500/15 text-amber-700 flex items-center justify-center text-xs font-bold">1</span>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Personal &amp; Contact Information</h3>
                        </div>
                        <span x-show="isStage1Complete" x-cloak class="anim-check-pop inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                            <svg class="w-3.5 h-3.5 text-emerald-600 anim-check-stroke" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span>Section 1 Complete</span>
                        </span>
                    </div>

                    <div class="space-y-4">
                        <!-- Full Name (Merged) -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                    Full Name <span class="text-rose-500">*</span>
                                </label>
                                <span x-show="isFieldVerified('name')" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                                    <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 flex items-center justify-center">
                                        <svg class="w-2.5 h-2.5 anim-check-stroke text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </span>
                                    <span>Verified</span>
                                </span>
                            </div>
                            <input type="text" name="name" x-model="name" @input="touch('name')" @blur="formatName()" required
                                class="w-full px-4 py-3 rounded-xl border text-sm text-slate-900 field-interactive placeholder-slate-400 focus:outline-none"
                                :class="isFieldVerified('name') ? 'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10' : (touched['name'] && !name.trim() ? 'border-rose-400 ring-2 ring-rose-400/15 bg-rose-50/10' : 'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20')"
                                placeholder="e.g. Umar Suleiman">
                        </div>

                        <!-- Email & Phone -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                        Email Address <span class="text-rose-500">*</span>
                                    </label>
                                    
                                    <!-- Valid Email Badge -->
                                    <span x-show="isFieldVerified('email')" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                                        <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 flex items-center justify-center">
                                            <svg class="w-2.5 h-2.5 anim-check-stroke text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        </span>
                                        <span>Valid Email</span>
                                    </span>

                                    <!-- Typo Detected Badge -->
                                    <span x-show="emailTypoSuggestion" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">
                                        Typo in domain?
                                    </span>
                                </div>
                                <input type="email" name="email" x-model="email" @input="onEmailInput()" @blur="onEmailInput()" required
                                    class="w-full px-4 py-3 rounded-xl border text-sm text-slate-900 field-interactive placeholder-slate-400 focus:outline-none"
                                    :class="{
                                        'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10': isFieldVerified('email'),
                                        'border-amber-400 ring-2 ring-amber-400/20 bg-amber-50/15': emailTypoSuggestion,
                                        'border-rose-400 ring-2 ring-rose-400/15 bg-rose-50/10': touched['email'] && (!email.trim() || (!isFieldVerified('email') && !emailTypoSuggestion)),
                                        'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20': !touched['email']
                                    }"
                                    placeholder="name@organization.com">

                                <!-- Typo Suggestion Helper Box with One-Click Fix -->
                                <div x-show="emailTypoSuggestion" x-cloak class="mt-2 p-3 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-900 flex items-center justify-between gap-2.5 anim-check-pop shadow-xs">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-amber-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                        <span>Did you mean <strong class="underline decoration-amber-400 underline-offset-2" x-text="emailTypoSuggestion"></strong>?</span>
                                    </div>
                                    <button type="button" @click="applyEmailSuggestion()" class="px-2.5 py-1 rounded-lg bg-amber-600 hover:bg-amber-700 text-white text-[11px] font-bold shrink-0 transition-colors cursor-pointer">
                                        Fix &rarr;
                                    </button>
                                </div>

                                <!-- Existing Account Recognition Alert -->
                                <div x-show="existingAccountDetected" x-cloak class="mt-2.5 p-3.5 rounded-2xl bg-amber-500/10 border-2 border-amber-500/30 text-slate-900 anim-check-pop shadow-xs">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-center gap-2">
                                            <span class="w-6 h-6 rounded-lg bg-amber-500 text-slate-950 font-bold flex items-center justify-center text-xs shrink-0">✓</span>
                                            <div>
                                                <span class="text-[10px] uppercase font-bold text-amber-800 block tracking-wider">Account Found</span>
                                                <span class="font-bold text-xs text-slate-900">The system already has your details!</span>
                                            </div>
                                        </div>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-200" x-text="existingAccountRole"></span>
                                    </div>
                                    <p class="text-xs text-slate-600 mt-2 mb-3">
                                        You do not need to register again. Simply sign in to complete your dues payment or access your portal.
                                    </p>
                                    <a :href="'{{ route('login') }}?email=' + encodeURIComponent(email)" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-900 text-amber-400 font-bold text-xs hover:bg-slate-800 transition-colors shadow-xs">
                                        <span>Sign In to Pay Dues &rarr;</span>
                                    </a>
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                        Phone Number <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="flex items-center gap-1.5">
                                        <span x-show="phoneCarrier" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[10px] font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span x-text="phoneCarrier"></span>
                                        </span>
                                        <span x-show="isFieldVerified('phone')" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                                            <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 flex items-center justify-center">
                                                <svg class="w-2.5 h-2.5 anim-check-stroke text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <input type="text" name="phone" x-model="phone" @input="touch('phone')" @blur="touch('phone')" required
                                    class="w-full px-4 py-3 rounded-xl border text-sm text-slate-900 field-interactive placeholder-slate-400 focus:outline-none"
                                    :class="isFieldVerified('phone') ? 'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10' : (touched['phone'] && !isFieldVerified('phone') ? 'border-rose-400 ring-2 ring-rose-400/15 bg-rose-50/10' : 'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20')"
                                    placeholder="+234 800 000 0000">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ================= SECTION 2: TRACK & AFFILIATION ================= -->
                <div>
                    <div class="flex items-center justify-between pb-2 mb-4 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <span class="w-6 h-6 rounded-lg bg-amber-500/15 text-amber-700 flex items-center justify-center text-xs font-bold">2</span>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Track &amp; Institutional Affiliation</h3>
                        </div>
                        <span x-show="isStage2Complete" x-cloak class="anim-check-pop inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                            <svg class="w-3.5 h-3.5 text-emerald-600 anim-check-stroke" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span>Section 2 Complete</span>
                        </span>
                    </div>

                    <div class="space-y-4">
                        <!-- Membership Category Selection -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                    Membership Category <span class="text-rose-500">*</span>
                                </label>
                                <span x-show="isFieldVerified('category')" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                                    <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 flex items-center justify-center">
                                        <svg class="w-2.5 h-2.5 anim-check-stroke text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </span>
                                    <span>Track Selected</span>
                                </span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                <!-- Professional -->
                                <label class="relative p-3.5 rounded-2xl border cursor-pointer transition-all flex items-start gap-3"
                                       :class="category === 'professional' ? 'bg-amber-500/10 border-amber-500 ring-2 ring-amber-500/20 shadow-xs' : 'bg-slate-50/50 border-slate-200 hover:bg-slate-50'">
                                    <input type="radio" name="category" value="professional" x-model="category" class="mt-0.5 text-amber-500 focus:ring-amber-500">
                                    <div class="min-w-0">
                                        <div class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                            <span>💼</span>
                                            <span>Professional Member</span>
                                        </div>
                                        <div class="text-[11px] text-slate-500 mt-0.5 leading-snug">Brand strategists, marketers, designers, agency practitioners.</div>
                                    </div>
                                </label>

                                <!-- Student -->
                                <label class="relative p-3.5 rounded-2xl border cursor-pointer transition-all flex items-start gap-3"
                                       :class="category === 'student' ? 'bg-amber-500/10 border-amber-500 ring-2 ring-amber-500/20 shadow-xs' : 'bg-slate-50/50 border-slate-200 hover:bg-slate-50'">
                                    <input type="radio" name="category" value="student" x-model="category" class="mt-0.5 text-amber-500 focus:ring-amber-500">
                                    <div class="min-w-0">
                                        <div class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                            <span>🎓</span>
                                            <span>Student Member</span>
                                        </div>
                                        <div class="text-[11px] text-slate-500 mt-0.5 leading-snug">Undergraduates &amp; college learners building creative careers.</div>
                                    </div>
                                </label>

                                <!-- Corporate -->
                                <label class="relative p-3.5 rounded-2xl border cursor-pointer transition-all flex items-start gap-3"
                                       :class="category === 'corporate' ? 'bg-amber-500/10 border-amber-500 ring-2 ring-amber-500/20 shadow-xs' : 'bg-slate-50/50 border-slate-200 hover:bg-slate-50'">
                                    <input type="radio" name="category" value="corporate" x-model="category" class="mt-0.5 text-amber-500 focus:ring-amber-500">
                                    <div class="min-w-0">
                                        <div class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                            <span>🏢</span>
                                            <span>Corporate Representative</span>
                                        </div>
                                        <div class="text-[11px] text-slate-500 mt-0.5 leading-snug">Enterprise brand managers &amp; institutional delegates.</div>
                                    </div>
                                </label>

                                <!-- Fellow -->
                                <label class="relative p-3.5 rounded-2xl border cursor-pointer transition-all flex items-start gap-3"
                                       :class="category === 'fellow' ? 'bg-amber-500/10 border-amber-500 ring-2 ring-amber-500/20 shadow-xs' : 'bg-slate-50/50 border-slate-200 hover:bg-slate-50'">
                                    <input type="radio" name="category" value="fellow" x-model="category" class="mt-0.5 text-amber-500 focus:ring-amber-500">
                                    <div class="min-w-0">
                                        <div class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                            <span>🏛️</span>
                                            <span>Fellow / Academic Educator</span>
                                        </div>
                                        <div class="text-[11px] text-slate-500 mt-0.5 leading-snug">Professors, researchers &amp; senior fellows in marketing.</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Affiliation & Designation -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Institution or Company</label>
                                    <span x-show="institutionOrCompany.trim().length > 1" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                                        <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        <span>Affiliated</span>
                                    </span>
                                </div>
                                <input type="text" name="institution_or_company" x-model="institutionOrCompany"
                                    placeholder="e.g. Ahmadu Bello University or Brand Studio"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm text-slate-900 field-interactive placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20">
                            </div>

                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Designation / Role</label>
                                </div>
                                <input type="text" name="designation" x-model="designation"
                                    placeholder="e.g. Creative Lead, Student, Strategist"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm text-slate-900 field-interactive placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20">
                            </div>
                        </div>

                        <!-- Country & State of Residence -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Country Selection -->
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                        Country <span class="text-rose-500">*</span>
                                    </label>
                                </div>
                                <select name="country" x-model="country" @change="onCountryChange()" required
                                    class="w-full px-4 py-3 rounded-xl border text-sm text-slate-900 field-interactive bg-white focus:outline-none"
                                    :class="isFieldVerified('country') ? 'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10' : 'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20'">
                                    <optgroup label="Primary Country">
                                        <option value="Nigeria">Nigeria</option>
                                    </optgroup>
                                    <optgroup label="Neighboring &amp; West African Countries">
                                        <option value="Benin">Benin Republic</option>
                                        <option value="Cameroon">Cameroon</option>
                                        <option value="Chad">Chad</option>
                                        <option value="Niger">Niger Republic</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Togo">Togo</option>
                                        <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                                        <option value="Senegal">Senegal</option>
                                        <option value="Sierra Leone">Sierra Leone</option>
                                        <option value="Liberia">Liberia</option>
                                        <option value="The Gambia">The Gambia</option>
                                        <option value="Mali">Mali</option>
                                        <option value="Guinea">Guinea</option>
                                        <option value="Burkina Faso">Burkina Faso</option>
                                    </optgroup>
                                    <optgroup label="Other African Nations">
                                        <option value="Kenya">Kenya</option>
                                        <option value="Rwanda">Rwanda</option>
                                        <option value="South Africa">South Africa</option>
                                        <option value="Egypt">Egypt</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="Tanzania">Tanzania</option>
                                        <option value="Ethiopia">Ethiopia</option>
                                    </optgroup>
                                    <optgroup label="Diaspora &amp; International">
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="United States">United States</option>
                                        <option value="Canada">Canada</option>
                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                        <option value="Other">Other International</option>
                                    </optgroup>
                                </select>
                            </div>

                            <!-- State of Residence (Dropdown for Nigeria, Interactive input for Neighbors/International) -->
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                        <span x-text="country === 'Nigeria' ? 'State of Residence *' : 'State / Province / Region *'"></span>
                                    </label>
                                    <span x-show="isFieldVerified('state')" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                                        <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 flex items-center justify-center">
                                            <svg class="w-2.5 h-2.5 anim-check-stroke text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        </span>
                                        <span x-text="country === 'Nigeria' ? 'State Set' : 'Region Set'"></span>
                                    </span>
                                </div>

                                <!-- If Nigeria: Dropdown with ALL 36 Nigerian States + FCT Abuja -->
                                <template x-if="country === 'Nigeria'">
                                    <select name="state" x-model="state" @change="touch('state')" required
                                        class="w-full px-4 py-3 rounded-xl border text-sm text-slate-900 field-interactive bg-white focus:outline-none"
                                        :class="isFieldVerified('state') ? 'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10' : 'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20'">
                                        <option value="" disabled>-- Select Nigerian State --</option>
                                        <template x-for="st in nigerianStates" :key="st">
                                            <option :value="st" x-text="st" :selected="state === st"></option>
                                        </template>
                                    </select>
                                </template>

                                <!-- If Neighboring / International: Region / Province input with datalist -->
                                <template x-if="country !== 'Nigeria'">
                                    <div>
                                        <input type="text" name="state" x-model="state" list="international-regions" @input="touch('state')" @blur="touch('state')" required
                                            class="w-full px-4 py-3 rounded-xl border text-sm text-slate-900 field-interactive placeholder-slate-400 focus:outline-none"
                                            :class="isFieldVerified('state') ? 'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10' : (touched['state'] && !isFieldVerified('state') ? 'border-rose-400 ring-2 ring-rose-400/15 bg-rose-50/10' : 'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20')"
                                            :placeholder="getRegionPlaceholder()">
                                        <datalist id="international-regions">
                                            <template x-for="rg in currentCountryRegions" :key="rg">
                                                <option :value="rg"></option>
                                            </template>
                                        </datalist>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Bio -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Brief Bio &amp; Professional Interests (Optional)</label>
                            <textarea name="bio" x-model="bio" rows="3"
                                placeholder="Tell us about your brand interests, experience, or community background..."
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm text-slate-900 field-interactive placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20"></textarea>
                        </div>
                    </div>
                </div>

                <!-- ================= SECTION 3: SECURITY & PORTAL ACCESS ================= -->
                <div>
                    <div class="flex items-center justify-between pb-2 mb-4 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <span class="w-6 h-6 rounded-lg bg-amber-500/15 text-amber-700 flex items-center justify-center text-xs font-bold">3</span>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Portal Security Credentials</h3>
                        </div>
                        <span x-show="isStage3Complete" x-cloak class="anim-check-pop inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                            <svg class="w-3.5 h-3.5 text-emerald-600 anim-check-stroke" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span>Security Ready</span>
                        </span>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Password -->
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                        Password <span class="text-rose-500">*</span>
                                    </label>
                                    <span x-show="capsLockOn" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">
                                        <span>⚠️</span> Caps Lock is ON
                                    </span>
                                    <span x-show="isFieldVerified('password') && !capsLockOn" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                                        <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 flex items-center justify-center">
                                            <svg class="w-2.5 h-2.5 anim-check-stroke text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        </span>
                                        <span>8+ chars</span>
                                    </span>
                                </div>
                                <div class="relative">
                                    <input :type="showPass ? 'text' : 'password'" name="password" x-model="password" 
                                        @input="touch('password')" 
                                        @blur="touch('password')" 
                                        @keydown="checkCapsLock($event)"
                                        @keyup="checkCapsLock($event)"
                                        required
                                        class="w-full px-4 py-3 rounded-xl border text-sm text-slate-900 pr-11 field-interactive placeholder-slate-400 focus:outline-none"
                                        :class="isFieldVerified('password') ? 'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10' : (touched['password'] && !isFieldVerified('password') ? 'border-rose-400 ring-2 ring-rose-400/15 bg-rose-50/10' : 'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20')"
                                        placeholder="Minimum 8 characters">
                                    <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                        <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg x-show="showPass" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    </button>
                                </div>

                                <!-- Password Strength Meter -->
                                <div x-show="password.length > 0" x-cloak class="mt-2.5">
                                    <div class="flex items-center justify-between text-[11px] mb-1">
                                        <span class="text-slate-500">Security strength:</span>
                                        <span class="font-bold uppercase tracking-wider"
                                              :class="{
                                                  'text-rose-500': passwordStrength <= 1,
                                                  'text-amber-500': passwordStrength === 2,
                                                  'text-blue-500': passwordStrength === 3,
                                                  'text-emerald-600': passwordStrength >= 4
                                              }"
                                              x-text="['Too Short', 'Weak', 'Good', 'Strong', 'Excellent'][passwordStrength] || 'Weak'"></span>
                                    </div>
                                    <div class="grid grid-cols-4 gap-1.5 h-1.5">
                                        <div class="rounded-full transition-all duration-300" :class="passwordStrength >= 1 ? (passwordStrength === 1 ? 'bg-rose-500' : (passwordStrength === 2 ? 'bg-amber-500' : 'bg-emerald-500')) : 'bg-slate-200'"></div>
                                        <div class="rounded-full transition-all duration-300" :class="passwordStrength >= 2 ? (passwordStrength === 2 ? 'bg-amber-500' : 'bg-emerald-500') : 'bg-slate-200'"></div>
                                        <div class="rounded-full transition-all duration-300" :class="passwordStrength >= 3 ? 'bg-emerald-500' : 'bg-slate-200'"></div>
                                        <div class="rounded-full transition-all duration-300" :class="passwordStrength >= 4 ? 'bg-emerald-500' : 'bg-slate-200'"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                        Confirm Password <span class="text-rose-500">*</span>
                                    </label>
                                    <span x-show="isFieldVerified('password_confirmation')" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                                        <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 flex items-center justify-center">
                                            <svg class="w-2.5 h-2.5 anim-check-stroke text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        </span>
                                        <span>Passwords Match</span>
                                    </span>
                                    <span x-show="password.length > 0 && passwordConfirmation.length > 0 && password !== passwordConfirmation" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-bold text-rose-600">
                                        <span class="w-3.5 h-3.5 rounded-full bg-rose-100 flex items-center justify-center text-[10px]">✕</span>
                                        <span>Mismatch</span>
                                    </span>
                                </div>
                                <div class="relative">
                                    <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" x-model="passwordConfirmation" 
                                        @input="touch('password_confirmation')" 
                                        @blur="touch('password_confirmation')" 
                                        @keydown="checkCapsLock($event)"
                                        @keyup="checkCapsLock($event)"
                                        required
                                        class="w-full px-4 py-3 rounded-xl border text-sm text-slate-900 pr-11 field-interactive placeholder-slate-400 focus:outline-none"
                                        :class="isFieldVerified('password_confirmation') ? 'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10' : (passwordConfirmation && password !== passwordConfirmation ? 'border-rose-400 ring-2 ring-rose-400/15 bg-rose-50/10' : 'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20')"
                                        placeholder="Re-enter password">
                                    <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                        <svg x-show="!showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg x-show="showConfirm" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Feedback hint -->
                        <p class="text-[11px] text-rose-500 flex items-center gap-1.5" x-show="password.length > 0 && password.length < 8" x-cloak>
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            <span>Password must contain at least 8 characters.</span>
                        </p>
                    </div>
                </div>

                <!-- Submit Button with Reactive State -->
                <div class="pt-2">
                    <button type="submit"
                            class="w-full py-4 px-6 rounded-2xl text-base font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-lg shadow-amber-500/25 transition-all duration-200 flex items-center justify-center gap-2 group cursor-pointer hover:scale-[1.01] active:scale-[0.99]">
                        <span>Register for Ongoing Membership</span>
                        <svg class="w-5 h-5 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                    <p class="text-center text-[11px] text-slate-500 mt-3">
                        By registering, you agree to uphold Brands Academy Nigeria Foundation's non-profit code of ethics and professional charter.
                    </p>
                </div>
            </form>
        </div>

        <!-- Right 5 cols: Live Digital Membership ID Card Preview & Institutional Info -->
        <div class="lg:col-span-5 space-y-6 lg:sticky lg:top-8">
            
            <!-- Live Digital Card Preview -->
            <div>
                <div class="flex items-center justify-between mb-3 px-1">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        Live Credential Preview
                    </span>
                    <span class="text-[11px] font-semibold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200">
                        Updates in Real-Time
                    </span>
                </div>

                <!-- The Digital Card Replica -->
                <div class="w-full bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white rounded-3xl p-6 sm:p-7 shadow-2xl border-2 border-amber-500/40 relative overflow-hidden card-preview-glow transition-all">
                    
                    <!-- Decorative Radial Glow Elements -->
                    <div class="absolute -right-16 -top-16 w-48 h-48 bg-amber-500/15 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-blue-500/15 rounded-full blur-2xl pointer-events-none"></div>

                    <!-- Card Header -->
                    <div class="flex items-center justify-between gap-4 mb-6 pb-4 border-b border-white/10 relative z-10">
                        <div class="flex items-center gap-3">
                            <x-brand-logo class="w-10 h-10 drop-shadow-md" />
                            <div>
                                <div class="font-extrabold text-sm uppercase tracking-wider text-white font-serif-title">
                                    Brands Academy
                                </div>
                                <div class="text-[9px] font-bold tracking-widest text-amber-400 uppercase">
                                    Nigeria Foundation
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 uppercase">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                Active Member
                            </span>
                            <span class="block text-[8px] text-slate-400 mt-0.5">CAC/IT/No. 7344471</span>
                        </div>
                    </div>

                    <!-- Member Live Name & Category -->
                    <div class="space-y-3.5 mb-6 relative z-10">
                        <div>
                            <span class="text-[9px] uppercase font-bold text-slate-400 block tracking-wider">Member Name</span>
                            <div class="text-lg sm:text-xl font-extrabold text-white font-serif-title mt-0.5 truncate"
                                 x-text="fullName">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <span class="text-[9px] uppercase font-bold text-slate-400 block tracking-wider">Category</span>
                                <span class="text-xs font-bold text-amber-400 block truncate" x-text="categoryLabel"></span>
                            </div>
                            <div>
                                <span class="text-[9px] uppercase font-bold text-slate-400 block tracking-wider">Registered Since</span>
                                <span class="text-xs font-semibold text-slate-200 block">{{ date('M Y') }}</span>
                            </div>
                        </div>

                        <!-- Affiliation preview -->
                        <div>
                            <span class="text-[9px] uppercase font-bold text-slate-400 block tracking-wider">Affiliation / Track</span>
                            <span class="text-xs text-slate-300 font-medium block truncate"
                                  x-text="(designation.trim() ? designation.trim() + ' • ' : '') + (institutionOrCompany.trim() ? institutionOrCompany.trim() : 'Brands Academy Member Network')">
                            </span>
                        </div>
                    </div>

                    <!-- Footer with Member ID and QR Scan Code -->
                    <div class="pt-4 border-t border-white/10 flex items-center justify-between gap-4 relative z-10">
                        <div>
                            <span class="text-[9px] uppercase font-bold text-slate-400 block tracking-wider">Member ID Number</span>
                            <div class="text-xs sm:text-sm font-extrabold font-mono text-amber-400 tracking-wider"
                                 x-text="previewMemberNumber">
                            </div>
                            <div class="text-[9px] text-slate-400 mt-0.5">
                                <span x-text="country === 'Nigeria' ? 'State: ' : 'Region: '"></span>
                                <span class="font-medium text-slate-200" x-text="state.trim() ? state.trim() : (country === 'Nigeria' ? 'Kaduna' : 'Region')"></span>,
                                <span class="font-medium text-slate-200" x-text="country"></span>
                            </div>
                        </div>

                        <!-- Stylized QR Code Graphic -->
                        <div class="p-2 bg-white rounded-xl shadow-md shrink-0 flex items-center justify-center w-14 h-14">
                            <svg class="w-10 h-10 text-slate-900" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M2 2h8v8H2V2zm2 2v4h4V4H4zm10-2h8v8h-8V2zm2 2v4h4V4h-4zM2 14h8v8H2v-8zm2 2v4h4v-4H4zm14 0h4v4h-4v-4zm-4-2h2v2h-2v-2zm0 4h2v4h-2v-4zm4-2h2v2h-2v-2zm-2-2h2v2h-2v-2zm4 4h2v2h-2v-2zM6 6h2v2H6V6zm12 0h2v2h-2V6zM6 18h2v2H6v-2z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="text-center text-[8px] text-slate-500 mt-4 uppercase tracking-widest relative z-10">
                        Official Digital Credential &bull; Non-Profit Public Benefit
                    </div>
                </div>
            </div>

            <!-- Member Privileges Card -->
            <div class="bg-gradient-to-br from-slate-900 to-blue-950 p-6 sm:p-7 rounded-3xl text-white shadow-xl">
                <x-brand-logo class="w-12 h-12 mb-4 drop-shadow-md" />
                <h3 class="text-lg font-bold font-serif-title mb-1.5">Member Privileges</h3>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed mb-5 font-light">
                    As an official member of Brands Academy Nigeria Foundation, you become part of an established pan-African branding ecosystem.
                </p>

                <ul class="space-y-3 text-xs sm:text-sm">
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span><strong>Unique Member ID &amp; Digital Credential:</strong> Verifiable online via your unique QR token.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span><strong>1-Click Cohort Application:</strong> Apply to open training cohorts without refilling basic information.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span><strong>Priority Mentorship Pairing:</strong> Direct linkage to industry practitioners and fellows.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span><strong>Tuition Subsidies:</strong> Consideration for youth and scholarship cohort opportunities.</span>
                    </li>
                </ul>
            </div>

            <!-- Non-Profit Legal Transparency Note -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 text-xs text-slate-600 leading-relaxed space-y-1.5 shadow-sm">
                <div class="font-bold text-slate-900 text-xs uppercase tracking-wider mb-1 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Non-Profit Commitment
                </div>
                <p>
                    Brands Academy Nigeria Foundation (CAC/IT/No. 7344471) is governed under the Companies and Allied Matters Act 2020 (Part F, Incorporated Trustees). Income and property are held strictly in trust to advance public-benefit educational objects.
                </p>
            </div>

        </div>

    </div>
</section>

@push('scripts')
<script>
    function membershipRegistrationForm() {
        return {
            name: {!! json_encode(old('name', old('first_name') ? trim(old('first_name').' '.old('last_name')) : '')) !!},
            email: {!! json_encode(old('email', '')) !!},
            phone: {!! json_encode(old('phone', '')) !!},
            category: {!! json_encode(old('category', 'professional')) !!},
            institutionOrCompany: {!! json_encode(old('institution_or_company', '')) !!},
            designation: {!! json_encode(old('designation', '')) !!},
            state: {!! json_encode(old('state', 'Kaduna')) !!},
            country: {!! json_encode(old('country', 'Nigeria')) !!},
            bio: {!! json_encode(old('bio', '')) !!},
            password: '',
            passwordConfirmation: '',
            showPass: false,
            showConfirm: false,
            capsLockOn: false,
            touched: {},

            emailTypoSuggestion: '',
            suggestedDomain: '',
            existingAccountDetected: false,
            existingAccountRole: '',
            checkAccountDebounce: null,

            nigerianStates: [
                'Abia', 'Adamawa', 'Akwa Ibom', 'Anambra', 'Bauchi', 'Bayelsa', 'Benue', 'Borno',
                'Cross River', 'Delta', 'Ebonyi', 'Edo', 'Ekiti', 'Enugu', 'FCT Abuja', 'Gombe',
                'Imo', 'Jigawa', 'Kaduna', 'Kano', 'Katsina', 'Kebbi', 'Kogi', 'Kwara',
                'Lagos', 'Nasarawa', 'Niger', 'Ogun', 'Ondo', 'Osun', 'Oyo', 'Plateau',
                'Rivers', 'Sokoto', 'Taraba', 'Yobe', 'Zamfara'
            ],

            countryRegions: {
                'Ghana': ['Greater Accra', 'Ashanti', 'Northern', 'Western', 'Central', 'Eastern', 'Volta', 'Upper East', 'Upper West', 'Bono', 'Bono East', 'Ahafo', 'Oti', 'Savannah', 'North East', 'Western North'],
                'Cameroon': ['Centre (Yaoundé)', 'Littoral (Douala)', 'Adamawa', 'Far North', 'North', 'Northwest', 'South', 'Southwest', 'West', 'East'],
                'Niger': ['Niamey', 'Agadez', 'Diffa', 'Dosso', 'Maradi', 'Tahoua', 'Tillabéri', 'Zinder'],
                'Benin': ['Littoral (Cotonou)', 'Atlantique', 'Ouémé (Porto-Novo)', 'Borgou', 'Zou', 'Collines', 'Atakora', 'Alibori', 'Mono', 'Couffo', 'Plateau', 'Donga'],
                'Chad': ["N'Djamena", 'Chari-Baguirmi', 'Mayo-Kebbi', 'Logone', 'Ouaddaï', 'Batha', 'Kanem', 'Guéra', 'Wadi Fira', 'Salamat'],
                'Togo': ['Maritime (Lomé)', 'Plateaux', 'Centrale', 'Kara', 'Savanes'],
                "Côte d'Ivoire": ['Abidjan', 'Yamoussoukro', 'Bas-Sassandra', 'Comoé', 'Gôh-Djiboua', 'Lacs', 'Lagunes', 'Montagnes', 'Sassandra-Marahoué', 'Savanes', 'Vallée du Bandama', 'Woroba', 'Zanzan'],
                'Kenya': ['Nairobi', 'Mombasa', 'Kisumu', 'Nakuru', 'Eldoret', 'Kiambu', 'Machakos', 'Kilifi'],
                'Rwanda': ['Kigali', 'Eastern Province', 'Northern Province', 'Southern Province', 'Western Province'],
                'South Africa': ['Gauteng (Johannesburg/Pretoria)', 'Western Cape (Cape Town)', 'KwaZulu-Natal (Durban)', 'Eastern Cape', 'Free State', 'Limpopo', 'Mpumalanga', 'North West', 'Northern Cape'],
                'United Kingdom': ['England - London', 'England - Greater Manchester', 'England - West Midlands', 'Scotland - Edinburgh/Glasgow', 'Wales - Cardiff', 'Northern Ireland - Belfast'],
                'United States': ['California', 'New York', 'Texas', 'Florida', 'Georgia', 'Illinois', 'Maryland', 'Washington D.C.']
            },

            get currentCountryRegions() {
                return this.countryRegions[this.country] || [];
            },

            getRegionPlaceholder() {
                switch(this.country) {
                    case 'Ghana': return 'e.g. Greater Accra, Ashanti, Northern';
                    case 'Cameroon': return 'e.g. Littoral (Douala), Centre (Yaoundé)';
                    case 'Niger': return 'e.g. Niamey, Maradi, Zinder';
                    case 'Benin': return 'e.g. Littoral (Cotonou), Atlantique, Ouémé';
                    case 'Chad': return "e.g. N'Djamena, Chari-Baguirmi";
                    case 'Togo': return 'e.g. Maritime (Lomé), Plateaux';
                    case "Côte d'Ivoire": return 'e.g. Abidjan, Yamoussoukro';
                    case 'Kenya': return 'e.g. Nairobi, Mombasa';
                    case 'United Kingdom': return 'e.g. England - London, Scotland';
                    case 'United States': return 'e.g. Texas, New York, California';
                    default: return 'Enter state, province, or region...';
                }
            },

            onCountryChange() {
                this.touch('country');
                if (this.country === 'Nigeria') {
                    if (!this.nigerianStates.includes(this.state)) {
                        this.state = 'Kaduna';
                    }
                } else {
                    const regions = this.countryRegions[this.country];
                    if (regions && regions.length > 0) {
                        this.state = regions[0];
                    } else {
                        this.state = '';
                    }
                }
                this.touch('state');
            },

            touch(field) {
                this.touched[field] = true;
            },

            checkCapsLock(e) {
                if (e.getModifierState) {
                    this.capsLockOn = e.getModifierState('CapsLock');
                }
            },

            formatName() {
                this.touch('name');
                if (this.name) {
                    this.name = this.name
                        .trim()
                        .split(/\s+/)
                        .filter(Boolean)
                        .map(w => w.charAt(0).toUpperCase() + w.slice(1).toLowerCase())
                        .join(' ');
                }
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
                if (mtn.includes(prefix)) return 'MTN Nigeria';
                if (airtel.includes(prefix)) return 'Airtel Nigeria';
                if (glo.includes(prefix)) return 'Glo Mobile';
                if (nineMobile.includes(prefix)) return '9mobile';

                // Neighboring & International network detection
                if (raw.startsWith('233')) return 'Ghana (+233)';
                if (raw.startsWith('237')) return 'Cameroon (+237)';
                if (raw.startsWith('227')) return 'Niger (+227)';
                if (raw.startsWith('229')) return 'Benin (+229)';
                if (raw.startsWith('235')) return 'Chad (+235)';
                if (raw.startsWith('228')) return 'Togo (+228)';
                if (raw.startsWith('225')) return "Côte d'Ivoire (+225)";
                if (raw.startsWith('254')) return 'Kenya (+254)';
                if (raw.startsWith('44')) return 'UK (+44)';
                if (raw.startsWith('1') && raw.length >= 11) return 'US/Canada (+1)';
                return null;
            },

            onEmailInput() {
                this.touch('email');
                this.emailTypoSuggestion = '';
                this.suggestedDomain = '';
                this.existingAccountDetected = false;
                clearTimeout(this.checkAccountDebounce);

                const trimmed = (this.email || '').trim();
                const parts = trimmed.split('@');
                if (parts.length === 2) {
                    const user = parts[0];
                    const domain = parts[1].toLowerCase();
                    const typoMap = {
                        'gmial.com': 'gmail.com',
                        'gamil.com': 'gmail.com',
                        'gmaill.com': 'gmail.com',
                        'gmai.com': 'gmail.com',
                        'yaho.com': 'yahoo.com',
                        'yahooo.com': 'yahoo.com',
                        'hotmial.com': 'hotmail.com',
                        'hotmaill.com': 'hotmail.com',
                        'outlok.com': 'outlook.com',
                        'outllok.com': 'outlook.com'
                    };
                    if (typoMap[domain]) {
                        this.suggestedDomain = typoMap[domain];
                        this.emailTypoSuggestion = user + '@' + typoMap[domain];
                    }
                }

                if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(trimmed) && !this.emailTypoSuggestion) {
                    this.checkAccountDebounce = setTimeout(() => {
                        fetch('{{ route('login.detect-role') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ email: trimmed })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.detected) {
                                this.existingAccountDetected = true;
                                this.existingAccountRole = data.role_label || 'Registered Member';
                            } else {
                                this.existingAccountDetected = false;
                            }
                        })
                        .catch(() => {
                            this.existingAccountDetected = false;
                        });
                    }, 350);
                }
            },

            applyEmailSuggestion() {
                if (this.emailTypoSuggestion) {
                    this.email = this.emailTypoSuggestion;
                    this.emailTypoSuggestion = '';
                    this.suggestedDomain = '';
                }
            },

            isFieldVerified(field) {
                switch(field) {
                    case 'name':
                        return (this.name || '').trim().length >= 2;
                    case 'email':
                        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test((this.email || '').trim()) && !this.emailTypoSuggestion;
                    case 'phone':
                        return (this.phone || '').replace(/[^0-9]/g, '').length >= 10;
                    case 'category':
                        return ['student', 'professional', 'corporate', 'fellow'].includes(this.category);
                    case 'country':
                        return (this.country || '').trim().length >= 2;
                    case 'state':
                        if (this.country === 'Nigeria') {
                            return this.nigerianStates.includes((this.state || '').trim());
                        }
                        return (this.state || '').trim().length >= 2;
                    case 'password':
                        return (this.password || '').length >= 8;
                    case 'password_confirmation':
                        return (this.passwordConfirmation || '').length >= 8 && this.password === this.passwordConfirmation;
                    default:
                        return false;
                }
            },

            get isStage1Complete() {
                return this.isFieldVerified('name') &&
                       this.isFieldVerified('email') &&
                       this.isFieldVerified('phone');
            },

            get isStage2Complete() {
                return this.isFieldVerified('category') &&
                       this.isFieldVerified('country') &&
                       this.isFieldVerified('state');
            },

            get isStage3Complete() {
                return this.isFieldVerified('password') && this.isFieldVerified('password_confirmation');
            },

            get completedFieldsCount() {
                const checks = [
                    this.isFieldVerified('name'),
                    this.isFieldVerified('email'),
                    this.isFieldVerified('phone'),
                    this.isFieldVerified('category'),
                    this.isFieldVerified('country'),
                    this.isFieldVerified('state'),
                    this.isFieldVerified('password'),
                    this.isFieldVerified('password_confirmation')
                ];
                return checks.filter(Boolean).length;
            },

            get completionPercentage() {
                return Math.round((this.completedFieldsCount / 8) * 100);
            },

            get passwordStrength() {
                if (!this.password) return 0;
                let score = 0;
                if (this.password.length >= 8) score++;
                if (/[A-Z]/.test(this.password) && /[a-z]/.test(this.password)) score++;
                if (/[0-9]/.test(this.password)) score++;
                if (/[^A-Za-z0-9]/.test(this.password) || this.password.length >= 12) score++;
                return score;
            },

            get fullName() {
                const trimmed = (this.name || '').trim();
                return trimmed.length > 0 ? trimmed : 'MEMBER FULL NAME';
            },

            get categoryLabel() {
                switch(this.category) {
                    case 'student': return 'Student Member';
                    case 'professional': return 'Professional Member';
                    case 'corporate': return 'Corporate Representative';
                    case 'fellow': return 'Fellow / Educator';
                    default: return 'Professional Member';
                }
            },

            get previewMemberNumber() {
                const words = (this.name || '').trim().split(/\s+/).filter(Boolean);
                const f = words[0]?.charAt(0).toUpperCase() || 'B';
                const l = (words[1] || words[0])?.charAt(0).toUpperCase() || 'A';
                return 'BANF-MBR-{{ date('Y') }}-' + f + l + '88';
            }
        };
    }
</script>
@endpush

@endsection
