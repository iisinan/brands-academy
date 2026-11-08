@extends('layouts.admin')

@section('title', 'Manage Workshops & Application Windows - Admin')
@section('page_title', '1. Workshops & Training Management')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header Actions Strip -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-serif-title">
                    Workshops &amp; Certification Cohorts
                </h1>
            </div>
            <p class="text-xs text-slate-500 mt-1">
                Configure certification syllabus, manage admission windows, control landing page visibility, and dispatch cryptographic certificates to graduates.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.certificates') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                <span>Certificate Registry</span>
            </a>
            <a href="{{ route('admin.workshops.create') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-all flex items-center gap-1.5 shadow-md shadow-amber-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>+ Create Workshop Cohort</span>
            </a>
        </div>
    </div>

    <!-- Workshops Listing Table -->
    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold text-[10px]">
                    <tr>
                        <th class="px-6 py-4">Title &amp; Track</th>
                        <th class="px-6 py-4">Landing Page Visibility</th>
                        <th class="px-6 py-4">Delivery &amp; Tuition</th>
                        <th class="px-6 py-4">Application Window</th>
                        <th class="px-6 py-4">Applicants &amp; Certificates</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($workshops as $workshop)
                        @php $window = $workshop->application_window_status; @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <a href="{{ route('workshops.show', $workshop->slug) }}" target="_blank" class="font-bold text-slate-900 text-sm hover:text-amber-600">
                                    {{ $workshop->title }}
                                </a>
                                <span class="block text-[10px] text-amber-700 font-semibold mt-0.5">{{ $workshop->track_label }}</span>
                            </td>

                            <!-- Landing Page Visibility & Featured Flag -->
                            <td class="px-6 py-4">
                                <div class="space-y-1.5">
                                    <!-- Toggle Live / Draft -->
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

                                    <!-- Featured Toggle Button -->
                                    <div>
                                        <form action="{{ route('admin.workshops.toggle-featured', $workshop->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-[10px] font-semibold {{ $workshop->is_featured ? 'text-amber-700 hover:text-amber-800' : 'text-slate-400 hover:text-slate-600' }} flex items-center gap-1">
                                                <span>{{ $workshop->is_featured ? '&#11088; Featured on Hero' : '&#9734; Feature on Hero' }}</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="block font-semibold text-slate-800 capitalize">{{ $workshop->delivery_mode }}</span>
                                <span class="text-[10px] {{ $workshop->fee_type == 'free' ? 'text-emerald-700 font-bold' : 'text-slate-500' }}">
                                    {{ $workshop->fee_type == 'free' ? 'Free Track' : 'NGN ' . number_format($workshop->fee_amount) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                <div>
                                    <span class="font-semibold text-slate-800">{{ $workshop->application_starts_at->format('M d') }}</span> to 
                                    <span class="font-semibold text-slate-800">{{ $workshop->application_deadline->format('M d, Y') }}</span>
                                </div>
                                <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[9px] font-bold border {{ $window['badge_class'] }}">
                                    {{ $window['label'] }} ({{ $window['detail'] }})
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="space-y-1.5">
                                    <a href="{{ route('admin.applications', ['workshop_id' => $workshop->id]) }}" class="font-bold text-amber-600 hover:underline block text-xs">
                                        {{ $workshop->applications_count }} Candidates Enrolled &rarr;
                                    </a>
                                    
                                    <!-- 1-Click Dispatch Certificates to All Participants -->
                                    <form action="{{ route('admin.workshops.bulk-issue-certificates', $workshop->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Generate authentic cryptographic certificates and email them to all eligible participants in {{ $workshop->title }}?')" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-[10px] shadow-xs transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                            <span>Dispatch Certificates to All</span>
                                        </button>
                                    </form>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.workshops.edit', $workshop->id) }}" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs inline-block transition-colors">
                                    Edit Cohort
                                </a>
                                <a href="{{ route('workshops.show', $workshop->slug) }}" target="_blank" class="font-bold text-slate-700 hover:text-amber-600 text-xs inline-block">
                                    Public Page &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-500">
                                <div class="max-w-sm mx-auto space-y-3">
                                    <svg class="w-12 h-12 mx-auto text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    <p class="font-medium text-slate-600">No workshop cohorts created yet.</p>
                                    <a href="{{ route('admin.workshops.create') }}" class="inline-block px-4 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950">
                                        Create New Cohort
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
