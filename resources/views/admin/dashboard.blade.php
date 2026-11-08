@extends('layouts.admin')

@section('title', 'Administration Dashboard - Brands Academy')
@section('page_title', 'Operational Control Center')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    
    <!-- Welcome Executive Header Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white p-6 sm:p-8 border border-slate-800 shadow-xl">
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-amber-500/20 text-amber-400 border border-amber-500/30">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Executive Operations & Governance</span>
                    <span class="text-slate-400">&bull;</span>
                    <span class="text-slate-300 font-mono">CAC IT No. 7344471</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold font-serif-title tracking-tight text-white">
                    Brands Academy Nigeria Control Center
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 max-w-2xl leading-relaxed">
                    Centrally govern professional certification cohorts, review membership dossiers, evaluate university/agency partnership proposals, and monitor institutional treasury transactions.
                </p>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('admin.workshops.create') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-all flex items-center gap-2 shadow-lg shadow-amber-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>+ New Workshop Cohort</span>
                </a>
                <a href="{{ route('admin.finance') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white transition-colors flex items-center gap-1.5 border border-white/10">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Finance Hub</span>
                </a>
                <a href="{{ route('admin.members') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white transition-colors flex items-center gap-1.5 border border-white/10">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>Members Directory</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 4 Core Pillars KPI Metric Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Pillar 1: Workshops & Training -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="flex items-center justify-between mb-3">
                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-amber-600">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    1. Workshops &amp; Training
                </span>
                <span class="p-2 rounded-xl bg-amber-50 text-amber-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </span>
            </div>
            <div class="text-3xl font-black text-slate-900 font-serif-title mb-1">
                {{ $stats['active_workshops'] }}
            </div>
            <div class="text-xs text-slate-500 mb-3">
                Live on Landing Page &bull; {{ $stats['total_workshops'] ?? $stats['active_workshops'] }} Total Cohorts
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500">{{ $stats['total_certificates'] }} Certs Issued</span>
                <a href="{{ route('admin.workshops') }}" class="font-bold text-amber-600 hover:text-amber-700 flex items-center gap-1">
                    Manage &rarr;
                </a>
            </div>
        </div>

        <!-- Pillar 2: Members Directory -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="flex items-center justify-between mb-3">
                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-blue-600">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    2. Members Directory
                </span>
                <span class="p-2 rounded-xl bg-blue-50 text-blue-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </span>
            </div>
            <div class="text-3xl font-black text-slate-900 font-serif-title mb-1">
                {{ $stats['total_members'] }}
            </div>
            <div class="text-xs text-slate-500 mb-3">
                {{ $stats['active_members'] ?? $stats['total_members'] }} Active Members in Good Standing
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                <span class="text-slate-500">Global Registry</span>
                <a href="{{ route('admin.members') }}" class="font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    Manage &rarr;
                </a>
            </div>
        </div>

        <!-- Pillar 3: Institutional Requests -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="flex items-center justify-between mb-3">
                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-purple-600">
                    <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                    3. Institutional Requests
                </span>
                <span class="p-2 rounded-xl bg-purple-50 text-purple-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </span>
            </div>
            <div class="text-3xl font-black text-slate-900 font-serif-title mb-1">
                {{ $stats['total_inquiries'] }}
            </div>
            <div class="text-xs text-slate-500 mb-3">
                Universities, MDAs &amp; Corporate Partnerships
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                @if($stats['pending_inquiries'] > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-purple-100 text-purple-800">
                        {{ $stats['pending_inquiries'] }} New Proposals
                    </span>
                @else
                    <span class="text-slate-400">All Reviewed</span>
                @endif
                <a href="{{ route('admin.inquiries') }}" class="font-bold text-purple-600 hover:text-purple-700 flex items-center gap-1">
                    Manage &rarr;
                </a>
            </div>
        </div>

        <!-- Pillar 4: Finance & Payment Monitoring -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-xs hover:shadow-md transition-shadow relative overflow-hidden group">
            <div class="flex items-center justify-between mb-3">
                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-emerald-600">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    4. Finance &amp; Payments
                </span>
                <span class="p-2 rounded-xl bg-emerald-50 text-emerald-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <div class="text-2xl font-black text-slate-900 font-serif-title mb-1 truncate">
                &#8358;{{ number_format($stats['total_revenue'] ?? 0, 0) }}
            </div>
            <div class="text-xs text-slate-500 mb-3">
                Gross Verified Inflows (NGN)
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                @if(($stats['pending_payments'] ?? 0) > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                        {{ $stats['pending_payments'] }} Pending Reviews
                    </span>
                @else
                    <span class="text-emerald-600 font-bold">&check; Fully Reconciled</span>
                @endif
                <a href="{{ route('admin.finance') }}" class="font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                    Ledger &rarr;
                </a>
            </div>
        </div>

    </div>

    <!-- Secondary Quick Stats Strip (RBAC, Admissions, Submissions) -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-slate-50/80 p-3 rounded-2xl border border-slate-200/80 text-xs">
        <a href="{{ route('admin.applications') }}" class="p-3 bg-white rounded-xl border border-slate-200/60 hover:border-amber-300 transition-colors flex items-center justify-between">
            <div>
                <span class="text-slate-400 block text-[10px] font-bold uppercase">Admissions Queue</span>
                <span class="text-lg font-black text-slate-900 font-serif-title">{{ $stats['pending_applications'] }} Pending</span>
            </div>
            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </a>

        <a href="{{ route('admin.submissions') }}" class="p-3 bg-white rounded-xl border border-slate-200/60 hover:border-amber-300 transition-colors flex items-center justify-between">
            <div>
                <span class="text-slate-400 block text-[10px] font-bold uppercase">Portfolios to Grade</span>
                <span class="text-lg font-black text-slate-900 font-serif-title">{{ $stats['pending_submissions'] }} Submitted</span>
            </div>
            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </a>

        <a href="{{ route('admin.certificates') }}" class="p-3 bg-white rounded-xl border border-slate-200/60 hover:border-amber-300 transition-colors flex items-center justify-between">
            <div>
                <span class="text-slate-400 block text-[10px] font-bold uppercase">Certificate Registry</span>
                <span class="text-lg font-black text-slate-900 font-serif-title">{{ $stats['total_certificates'] }} Issued</span>
            </div>
            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
        </a>

        <a href="{{ route('admin.users') }}" class="p-3 bg-white rounded-xl border border-slate-200/60 hover:border-amber-300 transition-colors flex items-center justify-between">
            <div>
                <span class="text-slate-400 block text-[10px] font-bold uppercase">Users &amp; RBAC</span>
                <span class="text-lg font-black text-slate-900 font-serif-title">{{ $stats['total_users'] }} Users</span>
            </div>
            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </a>
    </div>

    <!-- Cohort Application Windows -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                    <h2 class="text-lg font-bold text-slate-900 font-serif-title">Workshop Cohorts &amp; Application Windows</h2>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">Automated time-bound admissions windows that dynamically appear on the public landing page.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.workshops.create') }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors">
                    + New Workshop
                </a>
                <a href="{{ route('admin.workshops') }}" class="text-xs font-bold text-amber-600 hover:underline">
                    View All &rarr;
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold text-[10px]">
                    <tr>
                        <th class="px-4 py-3">Cohort Title &amp; Track</th>
                        <th class="px-4 py-3">Landing Page Visibility</th>
                        <th class="px-4 py-3">Application Window</th>
                        <th class="px-4 py-3">Window Status</th>
                        <th class="px-4 py-3">Training Duration</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($workshops as $workshop)
                        @php $wStatus = $workshop->application_window_status; @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-4 py-3.5">
                                <span class="font-bold text-slate-900 block text-sm">{{ $workshop->title }}</span>
                                <span class="text-[10px] text-amber-700 font-semibold">{{ $workshop->track_label }} &bull; {{ ucfirst($workshop->delivery_mode) }}</span>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('admin.workshops.toggle-status', $workshop->id) }}" method="POST" class="inline">
                                        @csrf
                                        @if($workshop->status === 'published')
                                            <button type="submit" title="Click to hide from landing page" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-rose-50 hover:text-rose-700 hover:border-rose-200 transition-colors">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                <span>Live on Landing Page</span>
                                            </button>
                                        @else
                                            <button type="submit" title="Click to publish to landing page" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 transition-colors">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                <span>Draft (Hidden)</span>
                                            </button>
                                        @endif
                                    </form>

                                    @if($workshop->is_featured)
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-100 text-amber-900 border border-amber-300">
                                            &#11088; Featured
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-slate-600">
                                {{ $workshop->application_starts_at->format('M d') }} &ndash; {{ $workshop->application_deadline->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $wStatus['badge_class'] }}">
                                    {{ $wStatus['label'] }} ({{ $wStatus['detail'] }})
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-slate-600">
                                {{ $workshop->starts_at->format('M d') }} &ndash; {{ $workshop->ends_at->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-3.5 text-right space-x-2">
                                <a href="{{ route('admin.workshops.edit', $workshop->id) }}" class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-[10px]">
                                    Edit
                                </a>
                                <form action="{{ route('admin.workshops.bulk-issue-certificates', $workshop->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Generate and dispatch certificates to all participants in {{ $workshop->title }}?')" class="px-2.5 py-1 rounded-lg bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-[10px]">
                                        Dispatch Certs
                                    </button>
                                </form>
                                <a href="{{ route('workshops.show', $workshop->slug) }}" target="_blank" class="font-bold text-amber-600 hover:underline text-[11px]">
                                    Live &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-500">
                                No workshops configured yet. <a href="{{ route('admin.workshops.create') }}" class="text-amber-600 font-bold hover:underline">Create the first cohort &rarr;</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Applications Queue -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xs">
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
                        <th class="px-4 py-3 text-right">Admissions &amp; Certificate Action</th>
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
                                            Issue &amp; Email Certificate
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

</div>

@endsection
