@extends('layouts.app')

@section('title', 'Administration Dashboard - Brands Academy')

@section('content')

<!-- Admin Header -->
<section class="bg-slate-900 text-white py-10 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-400 border border-amber-500/30 mb-2">
                    Foundation Administration Portal
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold font-serif-title">
                    Operational Control Center
                </h1>
            </div>

            <!-- Quick Action Links -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.workshops.create') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors flex items-center gap-1.5 shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    New Workshop Cohort
                </a>
                <a href="{{ route('admin.applications') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white transition-colors">
                    Admissions Queue
                </a>
                <a href="{{ route('admin.submissions') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white transition-colors flex items-center gap-1">
                    Portfolios
                    @if($stats['pending_submissions'] > 0)
                        <span class="px-1.5 py-0.2 rounded-full text-[9px] bg-amber-500 text-slate-950 font-bold">
                            {{ $stats['pending_submissions'] }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('admin.certificates') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white transition-colors">
                    Certificates Issued
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Grid -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 relative z-20">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-md">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Ongoing Members</span>
            <div class="text-3xl font-extrabold text-slate-900 font-serif-title">{{ $stats['total_members'] }}</div>
            <a href="{{ route('admin.members') }}" class="text-xs font-bold text-amber-600 hover:underline mt-2 inline-block">
                Manage Directory &rarr;
            </a>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-md">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Active Workshops</span>
            <div class="text-3xl font-extrabold text-slate-900 font-serif-title">{{ $stats['active_workshops'] }}</div>
            <a href="{{ route('admin.workshops') }}" class="text-xs font-bold text-amber-600 hover:underline mt-2 inline-block">
                View Cohorts &rarr;
            </a>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-md">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Pending Admissions</span>
            <div class="text-3xl font-extrabold text-amber-600 font-serif-title">{{ $stats['pending_applications'] }}</div>
            <a href="{{ route('admin.applications', ['status' => 'pending']) }}" class="text-xs font-bold text-amber-600 hover:underline mt-2 inline-block">
                Review Applicants &rarr;
            </a>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-md">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Issued Certificates</span>
            <div class="text-3xl font-extrabold text-emerald-600 font-serif-title">{{ $stats['total_certificates'] }}</div>
            <a href="{{ route('admin.certificates') }}" class="text-xs font-bold text-amber-600 hover:underline mt-2 inline-block">
                View Credentials &rarr;
            </a>
        </div>

    </div>
</section>

<!-- Main Admin Tables -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
    
    <!-- Cohort Application Windows -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-bold text-slate-900 font-serif-title">Cohort Application Windows</h2>
                <p class="text-xs text-slate-500">Scheduled windows that open and close application forms automatically.</p>
            </div>
            <a href="{{ route('admin.workshops') }}" class="text-xs font-bold text-amber-600 hover:underline">
                All Workshops &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold text-[10px]">
                    <tr>
                        <th class="px-4 py-3">Cohort Title</th>
                        <th class="px-4 py-3">Application Window</th>
                        <th class="px-4 py-3">Current Window Status</th>
                        <th class="px-4 py-3">Training Duration</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($workshops as $workshop)
                        @php $wStatus = $workshop->application_window_status; @endphp
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-4 py-3.5">
                                <span class="font-bold text-slate-900 block">{{ $workshop->title }}</span>
                                <span class="text-[10px] text-amber-700 font-semibold">{{ $workshop->track_label }}</span>
                            </td>
                            <td class="px-4 py-3.5 text-slate-600">
                                {{ $workshop->application_starts_at->format('M d') }} – {{ $workshop->application_deadline->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $wStatus['badge_class'] }}">
                                    {{ $wStatus['label'] }} ({{ $wStatus['detail'] }})
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-slate-600">
                                {{ $workshop->starts_at->format('M d') }} – {{ $workshop->ends_at->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <a href="{{ route('workshops.show', $workshop->slug) }}" target="_blank" class="font-bold text-amber-600 hover:underline">
                                    Public Page &rarr;
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Applications Queue -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-bold text-slate-900 font-serif-title">Recent Cohort Applications</h2>
                <p class="text-xs text-slate-500">Review candidates, approve admission, or generate post-workshop certificates.</p>
            </div>
            <a href="{{ route('admin.applications') }}" class="text-xs font-bold text-amber-600 hover:underline">
                View All Admissions &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold text-[10px]">
                    <tr>
                        <th class="px-4 py-3">Applicant Name</th>
                        <th class="px-4 py-3">Cohort</th>
                        <th class="px-4 py-3">Submission Date</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Admissions & Certificate Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentApplications as $app)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-4 py-3.5">
                                <div class="font-bold text-slate-900">{{ $app->applicant_name }}</div>
                                <div class="text-[11px] text-slate-500">{{ $app->applicant_email }}</div>
                                @if($app->member)
                                    <span class="inline-block px-1.5 py-0.2 rounded text-[9px] font-bold bg-amber-50 text-amber-800 border border-amber-200 mt-1">
                                        {{ $app->member->member_number }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="font-semibold text-slate-800">{{ $app->workshop->title }}</div>
                                <div class="text-[10px] text-slate-400">{{ $app->workshop->track_label }}</div>
                            </td>
                            <td class="px-4 py-3.5 text-slate-600">
                                {{ $app->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $app->status_badge['class'] }}">
                                    {{ $app->status_badge['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-right space-x-2">
                                @if($app->status == 'pending')
                                    <form action="{{ route('admin.applications.status', $app->id) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="accepted">
                                        <button type="submit" class="px-2.5 py-1 rounded bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px]">
                                            Accept
                                        </button>
                                    </form>
                                @endif

                                @if($app->status == 'accepted')
                                    <form action="{{ route('admin.applications.issue-certificate', $app->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Generate and email certificate to {{ $app->applicant_email }}?')" class="px-2.5 py-1 rounded bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-[10px] shadow-xs">
                                            Issue & Email Certificate
                                        </button>
                                    </form>
                                @endif

                                @if($app->status == 'completed')
                                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                        Certificate Dispatched &check;
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-slate-500">No applications received yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</section>

@endsection
