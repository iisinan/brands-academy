@extends('layouts.app')

@section('title', 'Institutional Partnerships & Corporate Licensing - Brands Academy')

@section('content')

<!-- Header -->
<section class="bg-slate-900 text-white py-16 lg:py-20 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20 mb-3">
                B2B & Institutional Framework
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold font-serif-title mb-4">
                Institutional Partnerships & Corporate Solutions
            </h1>
            <p class="text-slate-300 text-base sm:text-lg leading-relaxed font-light">
                Brands Academy Nigeria Foundation partners with universities, government agencies, and corporate organizations to deliver accredited branding curricula, staff capacity building, and strategic advisory.
            </p>
        </div>
    </div>
</section>

<!-- Content & Form Grid -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
        
        <!-- Left 7 cols: Solutions Catalog -->
        <div class="lg:col-span-7 space-y-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 font-serif-title mb-2">Our Institutional Offerings</h2>
                <p class="text-sm text-slate-600">Tailored programmatic frameworks designed for organizations seeking demonstrable brand and communications excellence.</p>
            </div>

            <!-- 4 Core Offerings from Section 13 of PDF -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- 1. Curriculum Licensing -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 font-bold flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-2">Curriculum Licensing</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Curriculum licences for universities, polytechnics, and colleges to deliver Academy-accredited branding certifications under institutional supervision.
                    </p>
                </div>

                <!-- 2. Corporate Staff Training -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-800 font-bold flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-2">Staff Capacity-Building</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Cohort-based in-house training for enterprise marketing, brand, PR, and digital strategy teams with custom progress reporting and credential awards.
                    </p>
                </div>

                <!-- 3. Strategic Brand Advisory -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-2">Brand Strategy Advisory</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        High-level consulting on organizational brand architecture, reputation risk management, and communications strategy for public and private institutions.
                    </p>
                </div>

                <!-- 4. Community & CSR Sponsorship -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-800 font-bold flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-2">Community Outreach</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Co-sponsored tuition-free vocational bootcamps targeting youth, refugees, and economically disadvantaged groups across Northern Nigeria and beyond.
                    </p>
                </div>
            </div>

            <!-- Accreditation Notice -->
            <div class="bg-slate-100 p-6 rounded-2xl border border-slate-200 text-xs text-slate-600 leading-relaxed">
                <span class="font-bold text-slate-900 block mb-1">Non-Profit Public Benefit Status</span>
                As an Incorporated Trustee under CAMA CAP C20 LFN 2004 (RC / IT No. 7344471), all institutional partnership proceeds are committed strictly to the expansion of educational access and community empowerment.
            </div>
        </div>

        <!-- Right 5 cols: Partnership Request Form -->
        <div class="lg:col-span-5 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xl">
            <h2 class="text-xl font-bold text-slate-900 font-serif-title mb-1">Partnership Inquiry</h2>
            <p class="text-xs text-slate-500 mb-6">Connect with our institutional directorate to discuss your organization's goals.</p>

            <form action="{{ route('partnerships.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Organization Name *</label>
                    <input type="text" name="organization_name" value="{{ old('organization_name') }}" required placeholder="e.g. Kaduna State Ministry of Education" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Contact Person *</label>
                        <input type="text" name="contact_person" value="{{ old('contact_person') }}" required placeholder="Your full name" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Official Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@org.ng" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Phone Number *</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="+234..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Organization Type *</label>
                        <select name="organization_type" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                            <option value="corporate">Corporate Enterprise / Agency</option>
                            <option value="higher_education">University / Polytechnic / College</option>
                            <option value="government">Government / Public Agency</option>
                            <option value="ngo">NGO / Development Agency</option>
                            <option value="other">Other Entity</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Solution of Interest *</label>
                    <select name="solution_interest" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                        <option value="staff_training">Staff Capacity-Building & Team Licensing</option>
                        <option value="curriculum_licensing">Academic Curriculum Licensing & Accreditation</option>
                        <option value="strategic_advisory">Brand Strategy & Executive Advisory</option>
                        <option value="community_sponsorship">Community Outreach & CSR Free-Training Sponsorship</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Expected Cohort Size</label>
                        <input type="number" name="estimated_cohort_size" value="{{ old('estimated_cohort_size') }}" placeholder="e.g. 25" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Target Timeline</label>
                        <input type="text" name="target_timeline" value="{{ old('target_timeline') }}" placeholder="e.g. Q1 2025" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Requirements & Objectives *</label>
                    <textarea name="message" rows="3" required placeholder="Describe your team's learning objectives or partnership scope..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="w-full py-3.5 px-4 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md transition-all">
                    Submit Institutional Inquiry
                </button>
            </form>
        </div>

    </div>
</section>

@endsection
