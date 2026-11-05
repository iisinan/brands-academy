@extends('layouts.app')

@section('title', 'Join the Foundation - Ongoing Membership Registration')

@section('content')

<!-- Header -->
<section class="bg-slate-900 text-white py-16 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20 mb-3">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Ongoing Registration &bull; Open 24/7 Year-Round
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold font-serif-title mb-4">
                Join Brands Academy Nigeria Foundation
            </h1>
            <p class="text-slate-300 text-sm sm:text-base leading-relaxed font-light">
                Membership connects you directly to our community of branding practitioners, educators, mentors, and corporate partners across Nigeria.
            </p>
        </div>
    </div>
</section>

<!-- Content -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
        
        <!-- Left 7 cols: Registration Form -->
        <div class="lg:col-span-7 bg-white p-6 sm:p-10 rounded-3xl border border-slate-200 shadow-xl">
            <h2 class="text-2xl font-bold text-slate-900 mb-1 font-serif-title">Membership Application</h2>
            <p class="text-xs text-slate-500 mb-8">Please provide your details below. An official Member ID will be generated upon submission.</p>

            <form action="{{ route('membership.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">First Name *</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Last Name *</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email Address *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Phone Number *</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="+234..." class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <!-- Membership Category -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Membership Category *</label>
                    <select name="category" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                        <option value="student" {{ old('category') == 'student' ? 'selected' : '' }}>Student Member (Undergraduate / College Learner)</option>
                        <option value="professional" {{ old('category', 'professional') == 'professional' ? 'selected' : '' }}>Professional Member (Brand Strategist, Marketer, Designer)</option>
                        <option value="corporate" {{ old('category') == 'corporate' ? 'selected' : '' }}>Corporate / Institutional Representative</option>
                        <option value="fellow" {{ old('category') == 'fellow' ? 'selected' : '' }}>Fellow / Academic Educator</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Institution or Company</label>
                        <input type="text" name="institution_or_company" value="{{ old('institution_or_company') }}" placeholder="e.g. University or Agency name" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Designation / Role</label>
                        <input type="text" name="designation" value="{{ old('designation') }}" placeholder="e.g. Student, Brand Manager" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">State of Residence *</label>
                        <input type="text" name="state" value="{{ old('state', 'Kaduna') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Country</label>
                        <input type="text" name="country" value="{{ old('country', 'Nigeria') }}" readonly class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-500 text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Brief Bio & Professional Interests (Optional)</label>
                    <textarea name="bio" rows="3" placeholder="Tell us about your brand interests, experience, or community background..." class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('bio') }}</textarea>
                </div>

                <!-- Password Setup for Member Dashboard -->
                <div class="pt-4 border-t border-slate-100">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-3">Portal Account Password</span>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Password *</label>
                            <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Confirm Password *</label>
                            <input type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 px-6 rounded-xl text-base font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-lg shadow-amber-500/20 transition-all hover:scale-[1.01]">
                    Register for Ongoing Membership
                </button>
            </form>
        </div>

        <!-- Right 5 cols: Member Benefits & Credential Info -->
        <div class="lg:col-span-5 space-y-6">
            
            <div class="bg-gradient-to-br from-slate-900 to-blue-950 p-6 sm:p-8 rounded-3xl text-white shadow-xl">
                <div class="w-12 h-12 rounded-xl bg-amber-500 text-slate-950 flex items-center justify-center font-bold text-xl mb-6">
                    B
                </div>
                <h3 class="text-xl font-bold font-serif-title mb-2">Member Privileges</h3>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed mb-6 font-light">
                    As an official member of Brands Academy Nigeria Foundation, you become part of an accredited pan-African branding ecosystem.
                </p>

                <ul class="space-y-3.5 text-xs sm:text-sm">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span><strong>Unique Member ID & Digital Credential:</strong> Verifiable online via your unique QR code.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span><strong>1-Click Cohort Application:</strong> Apply to any newly opened training cohort without refilling basic information.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span><strong>Priority Mentorship Pairing:</strong> Direct linkage to industry practitioners and fellows.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span><strong>Tuition Subsidies:</strong> Consideration for youth and marginalized community scholarship tracks.</span>
                    </li>
                </ul>
            </div>

            <!-- Legal Transparency Note -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 text-xs text-slate-600 leading-relaxed space-y-2">
                <div class="font-bold text-slate-900 text-sm mb-1">Non-Profit Commitment</div>
                <p>
                    Brands Academy Nigeria Foundation (CAC IT No. 7344471) is governed under CAMA CAP C20 LFN 2004. Income and property are held strictly in trust to advance public-benefit educational objects.
                </p>
            </div>

        </div>

    </div>
</section>

@endsection
