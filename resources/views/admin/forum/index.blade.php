@extends('layouts.admin')

@section('title', 'Community Forum Moderation')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Community Forum Moderation</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Oversee peer discussion threads, enforce academic charter civility, and pin or lock threads.</p>
        </div>
        <a href="{{ route('forum.index') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-amber-400 font-bold text-xs shadow-xs transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            <span>Open Public Board</span>
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl text-xs text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <!-- Metrics Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Discussions</div>
            <div class="text-2xl font-black text-slate-900 mt-1">{{ number_format($stats['total_threads']) }}</div>
            <div class="text-[11px] text-slate-500 mt-1">Across all channels</div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Replies</div>
            <div class="text-2xl font-black text-emerald-600 mt-1">{{ number_format($stats['total_replies']) }}</div>
            <div class="text-[11px] text-slate-500 mt-1">Peer answers &amp; solutions</div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Pinned Threads</div>
            <div class="text-2xl font-black text-amber-600 mt-1">{{ number_format($stats['pinned_threads']) }}</div>
            <div class="text-[11px] text-slate-500 mt-1">Featured at top</div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Locked Discussions</div>
            <div class="text-2xl font-black text-rose-600 mt-1">{{ number_format($stats['locked_threads']) }}</div>
            <div class="text-[11px] text-slate-500 mt-1">Closed to new replies</div>
        </div>
    </div>

    <!-- Filter & Search Strip -->
    <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-xs">
        <form method="GET" action="{{ route('admin.forum') }}" class="flex flex-col md:flex-row items-center gap-3 justify-between">
            <div class="flex items-center gap-3 w-full md:w-auto">
                <select name="channel" onchange="this.form.submit()" class="px-3 py-2 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                    <option value="">All Channels</option>
                    @foreach($channels as $channel)
                        <option value="{{ $channel->id }}" {{ request('channel') == $channel->id ? 'selected' : '' }}>
                            {{ $channel->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2 w-full md:w-80">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by title or body..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                <button type="submit" class="px-3.5 py-2 bg-slate-900 text-white rounded-xl text-xs font-semibold hover:bg-slate-800 shrink-0">Search</button>
            </div>
        </form>
    </div>

    <!-- Threads Table -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                    <tr>
                        <th class="p-4 pl-6">Discussion Title</th>
                        <th class="p-4">Channel</th>
                        <th class="p-4">Author</th>
                        <th class="p-4">Engagement</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 pr-6 text-right">Moderation Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($threads as $thread)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 pl-6 max-w-sm">
                                <a href="{{ route('forum.show', [$thread->channel->slug, $thread->slug]) }}" target="_blank" class="font-bold text-slate-900 hover:text-blue-600 block line-clamp-2">
                                    {{ $thread->title }}
                                </a>
                                <span class="text-[11px] text-slate-400 block mt-0.5">
                                    Created {{ $thread->created_at->format('M d, Y') }} &bull; Last active {{ $thread->last_activity_at?->diffForHumans() }}
                                </span>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-700">
                                    {{ $thread->channel->name }}
                                </span>
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                <div class="font-semibold text-slate-900">{{ $thread->author->name }}</div>
                                <div class="text-[10px] text-slate-400">{{ $thread->author->email }}</div>
                            </td>
                            <td class="p-4 whitespace-nowrap text-slate-600">
                                <div><span class="font-bold text-slate-900">{{ $thread->replies_count }}</span> replies</div>
                                <div class="text-[10px] text-slate-400">{{ $thread->views_count }} views &bull; {{ $thread->likes_count }} likes</div>
                            </td>
                            <td class="p-4 whitespace-nowrap space-y-1">
                                @if($thread->is_pinned)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900">
                                        📌 Pinned
                                    </span>
                                @endif
                                @if($thread->is_locked)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">
                                        🔒 Locked
                                    </span>
                                @endif
                                @if(! $thread->is_pinned && ! $thread->is_locked)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-600">
                                        Standard
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 pr-6 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    <form method="POST" action="{{ route('admin.forum.threads.pin', $thread) }}">
                                        @csrf
                                        <button type="submit" class="px-2 py-1 rounded-lg text-[11px] font-semibold border border-slate-200 text-slate-700 hover:bg-slate-100">
                                            {{ $thread->is_pinned ? 'Unpin' : 'Pin' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.forum.threads.lock', $thread) }}">
                                        @csrf
                                        <button type="submit" class="px-2 py-1 rounded-lg text-[11px] font-semibold border border-slate-200 text-slate-700 hover:bg-slate-100">
                                            {{ $thread->is_locked ? 'Unlock' : 'Lock' }}
                                        </button>
                                    </form>
                                    <a href="{{ route('forum.show', [$thread->channel->slug, $thread->slug]) }}" target="_blank" class="px-2 py-1 rounded-lg text-[11px] font-semibold bg-blue-50 text-blue-700 hover:bg-blue-100">
                                        View
                                    </a>
                                    <form method="POST" action="{{ route('admin.forum.threads.destroy', $thread) }}" onsubmit="return confirm('Permanently remove this discussion thread?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 rounded-lg text-[11px] font-semibold bg-rose-50 text-rose-700 hover:bg-rose-100">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400">
                                No discussion threads found matching criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($threads->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $threads->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
