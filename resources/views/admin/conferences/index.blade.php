@extends('layouts.admin')

@section('title', 'Conferences & Brand Summits Management')

@section('content')
<div class="space-y-8" x-data="{ showModal: false }">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Conferences &amp; Brand Summits</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Manage annual brand leadership summits, delegate ticketing, and Call for Papers.</p>
        </div>
        <button type="button" @click="showModal = true" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Create New Summit</span>
        </button>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl text-xs text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <!-- Conferences Table -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                    <tr>
                        <th class="p-4 pl-6">Summit Title</th>
                        <th class="p-4">Year &amp; Dates</th>
                        <th class="p-4">Venue</th>
                        <th class="p-4">Delegates</th>
                        <th class="p-4">Abstracts (CFP)</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 pr-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($conferences as $conf)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 pl-6">
                                <a href="{{ route('admin.conferences.show', $conf->id) }}" class="font-bold text-slate-900 hover:text-blue-600 block text-sm">
                                    {{ $conf->title }}
                                </a>
                                @if($conf->theme)
                                    <span class="text-[11px] text-slate-500 line-clamp-1">"{{ $conf->theme }}"</span>
                                @endif
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <span class="font-mono font-bold text-slate-800">{{ $conf->year }}</span>
                                <span class="text-[10px] text-slate-400 block">{{ $conf->starts_at->format('M d') }} - {{ $conf->ends_at->format('M d, Y') }}</span>
                            </td>
                            <td class="p-4 text-slate-600">
                                {{ $conf->venue ?: 'Abuja / Hybrid' }}
                            </td>
                            <td class="p-4 font-mono font-bold text-slate-900">
                                {{ $conf->delegates_count }} Registered
                            </td>
                            <td class="p-4 font-mono">
                                {{ $conf->papers_count }} Papers
                            </td>
                            <td class="p-4">
                                @if($conf->isUpcoming())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Upcoming
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600">
                                        Concluded
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 pr-6 text-right whitespace-nowrap">
                                <a href="{{ route('admin.conferences.show', $conf->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold text-xs transition-colors">
                                    <span>Manage &rarr;</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-slate-400">
                                No conferences created yet. Click "Create New Summit" above to start.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($conferences->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $conferences->links() }}
            </div>
        @endif
    </div>

    <!-- Create Summit Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/70 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl relative" @click.away="showModal = false">
            <h3 class="text-lg font-black text-slate-900 mb-4">Create Brand Summit / Conference</h3>
            <form action="{{ route('admin.conferences.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Summit Title *</label>
                    <input type="text" name="title" required placeholder="e.g. 2026 Nigeria Brand Leadership Summit" class="w-full text-xs rounded-xl border-slate-300">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Theme</label>
                    <input type="text" name="theme" placeholder="e.g. Brand Valuation, Equity & Policy in Emerging African Markets" class="w-full text-xs rounded-xl border-slate-300">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Year *</label>
                        <input type="number" name="year" value="{{ date('Y') }}" required class="w-full text-xs rounded-xl border-slate-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Venue *</label>
                        <input type="text" name="venue" required placeholder="e.g. International Conference Centre, Abuja" class="w-full text-xs rounded-xl border-slate-300">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Starts At *</label>
                        <input type="datetime-local" name="starts_at" required class="w-full text-xs rounded-xl border-slate-300">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Ends At *</label>
                        <input type="datetime-local" name="ends_at" required class="w-full text-xs rounded-xl border-slate-300">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Description</label>
                    <textarea name="description" rows="3" placeholder="Summit overview and objectives..." class="w-full text-xs rounded-xl border-slate-300"></textarea>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="cfp_open" id="cfp_open" value="1" checked class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <label for="cfp_open" class="text-xs text-slate-700 font-medium">Open Call for Papers (CFP) for this conference</label>
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="showModal = false" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs">Create Summit &amp; Generate Passes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
