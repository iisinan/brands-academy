@extends(auth()->check() && auth()->user()->member ? 'layouts.member' : 'layouts.app')

@section('title', 'Community & Knowledge Board | Brands Academy Nigeria Foundation')
@section('page_title', 'Community & Knowledge Board')

@section('content')
<div class="bg-slate-950 text-white py-16 sm:py-20 border-b border-slate-800 relative overflow-hidden">
    <div class="absolute inset-0 bg-radial-gradient from-amber-500/10 via-transparent to-transparent pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/15 text-amber-300 border border-amber-500/30 mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                    Peer Exchange &amp; Advisory
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-serif-title font-bold tracking-tight text-white">
                    Brands Academy Community Board
                </h1>
                <p class="mt-3 text-slate-300 text-sm sm:text-base max-w-2xl leading-relaxed">
                    A collaborative arena for brand strategists, researchers, IP practitioners, and enterprise custodians to debate frameworks, resolve regulatory hurdles, and share empirical insights.
                </p>
            </div>
            <div class="shrink-0 flex items-center gap-3">
                @auth
                    <a href="{{ route('forum.create') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-sm shadow-lg shadow-amber-500/20 transition-all hover:scale-[1.02]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Start Discussion
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-sm shadow-lg shadow-amber-500/20 transition-all">
                        Sign In to Participate
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Channels Bar -->
        <div class="mb-8">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Browse Channels</h2>
            <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
                <a href="{{ route('forum.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold shrink-0 transition-all {{ ! $selectedChannel ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                    All Channels
                </a>
                @foreach($channels as $channel)
                    <a href="{{ route('forum.channel', $channel->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold shrink-0 transition-all {{ $selectedChannel?->id === $channel->id ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                        @if($channel->is_member_only)
                            <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        @endif
                        <span>{{ $channel->name }}</span>
                        <span class="px-1.5 py-0.5 rounded-full text-[10px] {{ $selectedChannel?->id === $channel->id ? 'bg-slate-800 text-slate-300' : 'bg-slate-100 text-slate-600' }}">
                            {{ $channel->threads_count }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Filter & Search Strip -->
        <div class="bg-white rounded-2xl border border-slate-200 p-4 mb-6 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
            
            <!-- Sort Tabs -->
            <div class="flex items-center gap-1.5 w-full md:w-auto">
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'recent']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ $currentSort === 'recent' ? 'bg-amber-100 text-amber-900' : 'text-slate-600 hover:bg-slate-100' }}">
                    Latest Activity
                </a>
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ $currentSort === 'popular' ? 'bg-amber-100 text-amber-900' : 'text-slate-600 hover:bg-slate-100' }}">
                    Most Popular
                </a>
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'unanswered']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ $currentSort === 'unanswered' ? 'bg-amber-100 text-amber-900' : 'text-slate-600 hover:bg-slate-100' }}">
                    Unanswered
                </a>
            </div>

            <!-- Search input -->
            <form method="GET" action="{{ route('forum.index') }}" class="w-full md:w-80 flex items-center gap-2">
                @if(request('channel'))
                    <input type="hidden" name="channel" value="{{ request('channel') }}">
                @endif
                <div class="relative w-full">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search discussions..." class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <button type="submit" class="px-3 py-2 bg-slate-900 text-white rounded-xl text-xs font-semibold hover:bg-slate-800 shrink-0">Search</button>
            </form>
        </div>

        <!-- Thread List -->
        <div class="space-y-3">
            @forelse($threads as $thread)
                <div class="bg-white rounded-2xl border border-slate-200 p-5 sm:p-6 transition-all hover:border-amber-400 hover:shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                @if($thread->is_pinned)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-900 border border-amber-300">
                                        📌 Pinned
                                    </span>
                                @endif
                                @if($thread->is_locked)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-300">
                                        🔒 Locked
                                    </span>
                                @endif
                                <a href="{{ route('forum.channel', $thread->channel->slug) }}" class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700 hover:bg-slate-200">
                                    {{ $thread->channel->name }}
                                </a>
                                @if($thread->hasAcceptedAnswer())
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                        <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        Solved
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-base sm:text-lg font-bold text-slate-900 hover:text-amber-600 transition-colors">
                                <a href="{{ route('forum.show', [$thread->channel->slug, $thread->slug]) }}">
                                    {{ $thread->title }}
                                </a>
                            </h3>

                            <p class="mt-2 text-xs sm:text-sm text-slate-600 line-clamp-2 leading-relaxed">
                                {{ Str::limit(strip_tags($thread->body), 220) }}
                            </p>

                            <div class="mt-4 flex flex-wrap items-center gap-4 text-xs text-slate-500">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-slate-900 text-amber-400 font-bold text-[10px] flex items-center justify-center">
                                        {{ strtoupper(substr($thread->author->name, 0, 1)) }}
                                    </div>
                                    <span class="font-semibold text-slate-700">{{ $thread->author->name }}</span>
                                    @if($thread->author->isApprovedMember())
                                        <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-amber-100 text-amber-900">Member</span>
                                    @endif
                                </div>
                                <span>&bull;</span>
                                <span>Active {{ $thread->last_activity_at?->diffForHumans() ?? $thread->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Counters -->
                        <div class="hidden sm:flex items-center gap-4 shrink-0 text-slate-400 text-xs">
                            <div class="flex flex-col items-center">
                                <span class="font-bold text-slate-700 text-sm">{{ $thread->replies_count }}</span>
                                <span class="text-[10px] uppercase">Replies</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <span class="font-bold text-slate-700 text-sm">{{ $thread->views_count }}</span>
                                <span class="text-[10px] uppercase">Views</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <span class="font-bold text-slate-700 text-sm">{{ $thread->likes_count }}</span>
                                <span class="text-[10px] uppercase">Likes</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    <h3 class="text-base font-bold text-slate-800">No discussions found</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Be the first to open an inquiry or strategic case study in this channel.</p>
                    @auth
                        <a href="{{ route('forum.create') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs">
                            Start First Discussion
                        </a>
                    @endauth
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $threads->links() }}
        </div>
    </div>
</div>
@endsection
