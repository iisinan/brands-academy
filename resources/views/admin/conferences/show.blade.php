@extends('layouts.admin')

@section('title', 'Manage Summit: ' . $conference->title)

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div>
        <a href="{{ route('admin.conferences') }}" class="text-xs text-blue-600 hover:underline flex items-center gap-1 mb-2 font-medium">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Summits
        </a>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200 mb-1">
                    {{ $conference->year }} Plenary Assembly
                </span>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">{{ $conference->title }}</h1>
                <p class="text-xs text-slate-500 mt-1">{{ $conference->starts_at->format('M d, Y') }} - {{ $conference->ends_at->format('M d, Y') }} &bull; {{ $conference->venue }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.conferences.export', $conference->id) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs shadow-2xs transition-colors">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Export Delegates CSV</span>
                </a>
                <a href="{{ route('conferences.show', $conference->slug) }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-blue-600 transition-colors">
                    <span>Public Page &rarr;</span>
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl text-xs text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <!-- Metric Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Delegates</span>
            <span class="text-2xl font-black text-slate-900">{{ $conference->delegates_count }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider block mb-1">Checked In</span>
            <span class="text-2xl font-black text-emerald-600">{{ $conference->delegates->where('checked_in', true)->count() }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider block mb-1">Abstracts (CFP)</span>
            <span class="text-2xl font-black text-blue-600">{{ $conference->papers_count }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Ticketing Revenue</span>
            <span class="text-2xl font-black text-slate-900">₦{{ number_format($conference->delegates->sum('amount_paid'), 0) }}</span>
        </div>
    </div>

    <!-- Delegates Roster with 1-Click Check In -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">Registered Delegates ({{ $conference->delegates->count() }})</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                    <tr>
                        <th class="p-4 pl-6">Badge Ref</th>
                        <th class="p-4">Delegate Name</th>
                        <th class="p-4">Contact</th>
                        <th class="p-4">Pass Category</th>
                        <th class="p-4">Paid</th>
                        <th class="p-4">Check-In</th>
                        <th class="p-4 pr-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($conference->delegates as $delegate)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 pl-6 font-mono font-bold text-blue-600">
                                <a href="{{ route('conferences.badge', $delegate->badge_code) }}" target="_blank" class="hover:underline">
                                    {{ $delegate->badge_code }}
                                </a>
                            </td>
                            <td class="p-4">
                                <span class="font-bold text-slate-900 block">{{ $delegate->full_name }}</span>
                                <span class="text-[10px] text-slate-400">{{ $delegate->organization }}</span>
                            </td>
                            <td class="p-4">
                                <div>{{ $delegate->email }}</div>
                                <div class="text-[10px] text-slate-400">{{ $delegate->phone }}</div>
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700">
                                    {{ $delegate->ticket ? $delegate->ticket->name : 'Delegate' }}
                                </span>
                            </td>
                            <td class="p-4 font-mono font-semibold">
                                ₦{{ number_format($delegate->amount_paid, 0) }}
                            </td>
                            <td class="p-4">
                                @if($delegate->checked_in)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        ✓ Checked In
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-500">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 pr-6 text-right whitespace-nowrap">
                                <form action="{{ route('admin.conferences.checkin', $delegate->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors {{ $delegate->checked_in ? 'bg-rose-50 text-rose-700 hover:bg-rose-100' : 'bg-emerald-600 text-white hover:bg-emerald-700' }}">
                                        {{ $delegate->checked_in ? 'Undo Check-In' : 'Accredit & Check-In' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-slate-400">
                                No delegates registered yet for this summit.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Call for Papers Abstracts Review Section -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-sm font-bold text-slate-900">Call for Papers & Academic Submissions ({{ $conference->papers->count() }})</h3>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse($conference->papers as $paper)
                <div class="p-6 sm:p-8 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <span class="text-xs font-bold text-blue-600 block">{{ $paper->author_name }} &bull; {{ $paper->author_institution }}</span>
                            <h4 class="text-base font-bold text-slate-900">{{ $paper->title }}</h4>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-800">
                            {{ $paper->status_label }}
                        </span>
                    </div>

                    <p class="text-xs text-slate-600 leading-relaxed font-light bg-slate-50 p-4 rounded-xl">
                        {{ $paper->abstract_text }}
                    </p>

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2">
                        @if($paper->manuscript_pdf_path)
                            <a href="{{ asset('storage/' . $paper->manuscript_pdf_path) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:underline">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span>Download Manuscript PDF</span>
                            </a>
                        @else
                            <span class="text-xs text-slate-400 italic">No PDF attached</span>
                        @endif

                        <!-- Fast Review Actions -->
                        <form action="{{ route('admin.conferences.cfp.review', $paper->id) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            <input type="text" name="reviewer_feedback" placeholder="Review feedback..." class="text-xs rounded-lg border-slate-300 w-48">
                            <button type="submit" name="review_status" value="accepted_presentation" class="px-3 py-1.5 rounded-lg bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-700">
                                Accept Plenary
                            </button>
                            <button type="submit" name="review_status" value="accepted_poster" class="px-3 py-1.5 rounded-lg bg-blue-600 text-white font-bold text-xs hover:bg-blue-700">
                                Accept Poster
                            </button>
                            <button type="submit" name="review_status" value="rejected" class="px-3 py-1.5 rounded-lg bg-rose-50 text-rose-700 font-bold text-xs hover:bg-rose-100">
                                Decline
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-slate-400 text-xs">
                    No academic papers submitted yet for this summit.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
