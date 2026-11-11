@extends('layouts.admin')

@section('title', 'Webinars & Virtual Events - Admin Control Center')

@section('content')

<div class="space-y-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold font-serif-title text-slate-900">
                Webinars &amp; Live Masterclasses
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Schedule virtual sessions with Google Meet links, manage attendee RSVPs, and export attendee rosters.
            </p>
        </div>

        <button type="button" onclick="document.getElementById('add-webinar-modal').classList.remove('hidden')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold shadow-md transition-all shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>Schedule New Webinar</span>
        </button>
    </div>

    <!-- Webinars Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto touch-scroll">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4 font-bold">Session &amp; Speaker</th>
                        <th class="py-3 px-4 font-bold">Scheduled Time</th>
                        <th class="py-3 px-4 font-bold">Platform</th>
                        <th class="py-3 px-4 font-bold">Access</th>
                        <th class="py-3 px-4 font-bold">RSVPs</th>
                        <th class="py-3 px-4 font-bold">Status</th>
                        <th class="py-3 px-4 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($webinars as $webinar)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $webinar->title }}</div>
                                <div class="text-[11px] text-slate-400 mt-0.5">{{ $webinar->speaker_name }} • {{ $webinar->speaker_title ?: 'Speaker' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-slate-800">{{ $webinar->starts_at->format('M d, Y') }}</div>
                                <div class="text-[11px] text-slate-400">{{ $webinar->starts_at->format('h:i A') }} ({{ $webinar->duration_minutes }}m)</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                    Google Meet
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-bold">
                                {{ $webinar->formattedPrice() }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-800 font-mono">
                                    {{ $webinar->registrations_count }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold capitalize {{ $webinar->isLive() ? 'bg-rose-100 text-rose-800 animate-pulse' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $webinar->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.webinars.export', $webinar->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors" title="Export Attendees CSV">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span>CSV</span>
                                    </a>

                                    <form method="POST" action="{{ route('admin.webinars.destroy', $webinar->id) }}" onsubmit="return confirm('Delete this webinar?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                No webinars scheduled yet. Click "+ Schedule New Webinar" to add one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $webinars->links() }}
        </div>
    </div>

    <!-- Modal: Add Webinar -->
    <div id="add-webinar-modal" class="hidden fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 text-slate-900 shadow-xl">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-900">Schedule Live Webinar</h3>
                <button type="button" onclick="document.getElementById('add-webinar-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-700">✕</button>
            </div>
            <form method="POST" action="{{ route('admin.webinars.store') }}" class="space-y-3.5">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Webinar Title *</label>
                    <input type="text" name="title" required placeholder="e.g. Navigating African Brand Equity in 2026" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Keynote Speaker *</label>
                        <input type="text" name="speaker_name" required placeholder="e.g. Dr. John Doe" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Speaker Designation</label>
                        <input type="text" name="speaker_title" placeholder="e.g. Managing Partner, IP Firm" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Starts At (Date &amp; Time) *</label>
                        <input type="datetime-local" name="starts_at" required class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Duration (Minutes)</label>
                        <input type="number" name="duration_minutes" value="60" min="15" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Fee Type</label>
                        <select name="fee_type" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                            <option value="free">Free</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Price (₦)</label>
                        <input type="number" name="regular_price" value="0" step="0.01" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Member (₦)</label>
                        <input type="number" name="member_price" value="0" step="0.01" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Platform</label>
                    <select name="meeting_provider" class="w-full text-xs border border-slate-300 rounded-lg p-2.5">
                        <option value="google_meet">Google Meet (Auto-generates room link)</option>
                        <option value="zoom">Zoom</option>
                        <option value="youtube_live">YouTube Live Stream</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Summary</label>
                    <textarea name="summary" rows="2" placeholder="Brief synopsis of key insights..." class="w-full text-xs border border-slate-300 rounded-lg p-2.5"></textarea>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('add-webinar-modal').classList.add('hidden')" class="px-4 py-2 rounded-lg border border-slate-200 text-xs font-semibold">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold">Schedule Webinar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
