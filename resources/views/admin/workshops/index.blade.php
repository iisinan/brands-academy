@extends('layouts.app')

@section('title', 'Manage Workshops & Application Windows - Admin')

@section('content')

<!-- Header -->
<section class="bg-slate-900 text-white py-10 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-xs text-amber-400 hover:underline block mb-1">&larr; Admin Dashboard</a>
                <h1 class="text-2xl sm:text-3xl font-extrabold font-serif-title">
                    Workshops & Application Windows
                </h1>
            </div>
            <a href="{{ route('admin.workshops.create') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors flex items-center gap-1.5 shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Create New Workshop
            </a>
        </div>
    </div>
</section>

<!-- Table -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold text-[10px]">
                    <tr>
                        <th class="px-6 py-4">Title & Track</th>
                        <th class="px-6 py-4">Delivery & Fee</th>
                        <th class="px-6 py-4">Application Window</th>
                        <th class="px-6 py-4">Window Status</th>
                        <th class="px-6 py-4">Applications</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($workshops as $workshop)
                        @php $window = $workshop->application_window_status; @endphp
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-6 py-4">
                                <a href="{{ route('workshops.show', $workshop->slug) }}" target="_blank" class="font-bold text-slate-900 text-sm hover:text-amber-600">
                                    {{ $workshop->title }}
                                </a>
                                <span class="block text-[10px] text-amber-700 font-semibold">{{ $workshop->track_label }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="block font-semibold text-slate-800 capitalize">{{ $workshop->delivery_mode }}</span>
                                <span class="text-[10px] {{ $workshop->fee_type == 'free' ? 'text-emerald-700 font-bold' : 'text-slate-500' }}">
                                    {{ $workshop->fee_type == 'free' ? 'Free Track' : 'NGN ' . number_format($workshop->fee_amount) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                <span class="font-semibold text-slate-800">{{ $workshop->application_starts_at->format('M d') }}</span> to 
                                <span class="font-semibold text-slate-800">{{ $workshop->application_deadline->format('M d, Y') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $window['badge_class'] }}">
                                    {{ $window['label'] }} ({{ $window['detail'] }})
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.applications', ['workshop_id' => $workshop->id]) }}" class="font-bold text-amber-600 hover:underline">
                                    {{ $workshop->applications_count }} applicants
                                </a>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.workshops.edit', $workshop->id) }}" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-[10px] inline-block">
                                    Edit Cohort
                                </a>
                                <form action="{{ route('admin.workshops.bulk-issue-certificates', $workshop->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Generate and email certificates to all eligible participants in {{ $workshop->title }}?')" class="px-2.5 py-1.5 rounded-lg bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-[10px] shadow-xs">
                                        Batch Issue Certificates
                                    </button>
                                </form>
                                <a href="{{ route('workshops.show', $workshop->slug) }}" target="_blank" class="font-bold text-slate-700 hover:text-amber-600 text-xs inline-block">
                                    View Live &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">No workshops created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection
