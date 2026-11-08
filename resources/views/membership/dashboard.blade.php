@extends('layouts.app')

@section('title', 'Member Dashboard - ' . $member->full_name)

@section('content')

<!-- Member Top Profile Banner -->
<section class="bg-slate-900 text-white py-12 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-500 to-amber-600 text-slate-950 font-bold text-2xl flex items-center justify-center shadow-lg font-serif-title">
                    {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-500/20 text-amber-400 border border-amber-500/30">
                            {{ $member->category_label }}
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">
                            Active Status
                        </span>
                        @if(auth()->user()->isAdmin())
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-400 text-slate-950">
                                Administrator View
                            </span>
                        @endif
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold font-serif-title">
                        {{ $member->full_name }}
                    </h1>
                    <p class="text-xs text-slate-400 mt-1">
                        {{ $member->designation ?? 'Member' }} &bull; {{ $member->institution_or_company ?? 'Brands Academy Network' }}
                    </p>
                </div>
            </div>

            <!-- Member ID Pill & Quick Actions -->
            <div class="flex flex-wrap items-center gap-3">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2.5 rounded-2xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-amber-400 border border-slate-700 transition-colors flex items-center gap-1.5 whitespace-nowrap">
                        &larr; Admin Control Panel
                    </a>
                @endif
                <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/15 flex items-center justify-between sm:justify-start gap-4">
                    <div>
                        <span class="block text-[10px] uppercase font-bold text-slate-400">Official Member ID</span>
                        <span class="text-base font-extrabold font-mono text-amber-400">{{ $member->member_number }}</span>
                    </div>
                    <a href="{{ route('membership.card', $member->qr_code_token) }}" target="_blank" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors flex items-center gap-1.5 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                        Digital ID Card
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Dashboard Main Content -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="space-y-10">

        <!-- 1. Currently Open Cohorts Fast-Apply Section -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 font-serif-title">Cohorts Open for Applications</h2>
                    <p class="text-xs text-slate-500">Apply during the active window with your registered Member ID.</p>
                </div>
                <a href="{{ route('workshops.index') }}" class="text-xs font-bold text-amber-600 hover:underline">
                    View all cohorts &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($openWorkshops as $workshop)
                    @php $window = $workshop->application_window_status; @endphp
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs flex flex-col justify-between">
                        <div>
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $window['badge_class'] }} mb-2">
                                {{ $window['label'] }} &bull; {{ $window['detail'] }}
                            </span>
                            <h3 class="font-bold text-slate-900 text-base mb-1">
                                {{ $workshop->title }}
                            </h3>
                            <div class="text-xs text-amber-700 font-semibold mb-2">
                                {{ $workshop->track_label }}
                            </div>
                            <p class="text-xs text-slate-600 line-clamp-2 mb-4">
                                {{ $workshop->tagline ?? $workshop->description }}
                            </p>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-xs font-bold {{ $workshop->fee_type == 'free' ? 'text-emerald-700' : 'text-slate-900' }}">
                                {{ $workshop->fee_type == 'free' ? 'Free Track' : 'NGN ' . number_format($workshop->fee_amount) }}
                            </span>
                            <a href="{{ route('workshops.show', $workshop->slug) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors">
                                Apply Now &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white p-6 rounded-2xl border border-dashed border-slate-200 text-center text-xs text-slate-500">
                        No cohorts are currently in an active application window. Check back soon for the next enrollment cycle.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 2. My Earned Certificates & Digital Badges -->
        <div>
            <div class="mb-4">
                <h2 class="text-xl font-bold text-slate-900 font-serif-title">My Earned Certificates</h2>
                <p class="text-xs text-slate-500">Official, verifiable credentials awarded upon completing Academy cohorts.</p>
            </div>

            @if($certificates->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($certificates as $cert)
                        <div class="bg-white rounded-2xl border-2 border-amber-500/30 p-6 shadow-md relative overflow-hidden flex flex-col justify-between">
                            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-amber-500/10 rounded-full blur-xl pointer-events-none"></div>
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Verified Credential
                                    </span>
                                    <span class="text-xs font-mono font-bold text-slate-500">{{ $cert->certificate_number }}</span>
                                </div>

                                <h3 class="text-lg font-bold text-slate-900 mb-1 font-serif-title">
                                    {{ $cert->course_title }}
                                </h3>
                                <div class="text-xs font-semibold text-amber-700 mb-2">
                                    {{ $cert->track_tier }}
                                </div>
                                <p class="text-xs text-slate-500 mb-4">
                                    Issued on {{ $cert->issued_at->format('F d, Y') }} &bull; Brands Academy Nigeria Foundation
                                </p>
                            </div>

                            <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center gap-3">
                                <a href="{{ route('certificates.download', $cert->verification_token) }}" class="inline-flex items-center gap-1 px-4 py-2 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white transition-colors">
                                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    Download PDF
                                </a>
                                <a href="{{ route('verify.certificate', $cert->verification_token) }}" target="_blank" class="inline-flex items-center gap-1 px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    Verify Online
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white p-8 rounded-2xl border border-dashed border-slate-200 text-center">
                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <h4 class="font-bold text-slate-800 text-sm mb-1">No Certificates Issued Yet</h4>
                    <p class="text-xs text-slate-500 max-w-md mx-auto">
                        Once you apply for and successfully complete an academy cohort or workshop, your verifiable Certificate of Achievement will appear here and be dispatched to your email.
                    </p>
                </div>
            @endif
        </div>

        <!-- 3. My Submitted Applications History -->
        <div>
            <div class="mb-4">
                <h2 class="text-xl font-bold text-slate-900 font-serif-title">My Application History</h2>
                <p class="text-xs text-slate-500">Track admission decisions and cohort progression.</p>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
                @if($applications->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold text-[10px]">
                                <tr>
                                    <th class="px-6 py-3.5">Programme / Workshop</th>
                                    <th class="px-6 py-3.5">Submission Date</th>
                                    <th class="px-6 py-3.5">Tuition Type</th>
                                    <th class="px-6 py-3.5">Admissions Status</th>
                                    <th class="px-6 py-3.5 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($applications as $app)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-slate-900 text-sm">{{ $app->workshop->title }}</div>
                                            <div class="text-[11px] text-amber-700 font-semibold">{{ $app->workshop->track_label }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-slate-600">
                                            {{ $app->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($app->scholarship_requested)
                                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">
                                                    Subsidy Requested
                                                </span>
                                            @else
                                                <span class="text-slate-700 font-semibold uppercase text-[10px]">
                                                    {{ $app->workshop->fee_type }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold {{ $app->status_badge['class'] }}">
                                                {{ $app->status_badge['label'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right space-x-2">
                                            @if(in_array($app->status, ['accepted', 'completed']))
                                                <a href="{{ route('member.portfolio.create', $app->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors shadow-xs">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                    {{ $app->portfolioSubmissions->count() > 0 ? 'Portfolio (' . $app->portfolioSubmissions->count() . ')' : 'Submit Portfolio' }}
                                                </a>
                                            @endif
                                            <a href="{{ route('workshops.show', $app->workshop->slug) }}" class="font-bold text-slate-600 hover:text-amber-600 text-xs">
                                                View Cohort &rarr;
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-8 text-center text-xs text-slate-500">
                        You have not applied for any training cohorts yet. Check the open cohorts section above to apply!
                    </div>
                @endif
            </div>
        </div>

        <!-- 4. Member Profile & Contact Information -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-slate-900 font-serif-title">Member Profile & Registry Information</h2>
                <p class="text-xs text-slate-500">Keep your professional affiliations and contact records up to date.</p>
            </div>

            <form action="{{ route('member.profile.update') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Phone Number *</label>
                        <input type="text" name="phone" value="{{ old('phone', $member->phone) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">State of Residence *</label>
                        <input type="text" name="state" value="{{ old('state', $member->state) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Organization or Institution</label>
                        <input type="text" name="institution_or_company" value="{{ old('institution_or_company', $member->institution_or_company) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Designation / Role</label>
                        <input type="text" name="designation" value="{{ old('designation', $member->designation) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Professional Bio / Focus</label>
                    <textarea name="bio" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('bio', $member->bio) }}</textarea>
                </div>

                <button type="submit" class="px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors">
                    Save Profile Changes
                </button>
            </form>
        </div>

    </div>
</section>

@endsection
