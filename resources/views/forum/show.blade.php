@extends('layouts.app')

@section('title', "{$thread->title} | Brands Academy Community")

@section('content')
<!-- Header Bar -->
<div class="bg-slate-950 text-white py-12 border-b border-slate-800">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs text-slate-400 mb-4">
            <a href="{{ route('forum.index') }}" class="hover:text-amber-400 transition-colors">Community</a>
            <span>/</span>
            <a href="{{ route('forum.channel', $channel->slug) }}" class="hover:text-amber-400 transition-colors">{{ $channel->name }}</a>
            <span>/</span>
            <span class="text-slate-300 truncate max-w-xs">{{ $thread->title }}</span>
        </nav>

        <div class="flex flex-wrap items-center gap-2 mb-3">
            @if($thread->is_pinned)
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                    📌 Pinned
                </span>
            @endif
            @if($thread->is_locked)
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30">
                    🔒 Locked
                </span>
            @endif
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-800 text-slate-300">
                {{ $channel->name }}
            </span>
            @if($thread->hasAcceptedAnswer())
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    Solved
                </span>
            @endif
        </div>

        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-serif-title font-bold text-white tracking-tight">
            {{ $thread->title }}
        </h1>

        <!-- Author Meta -->
        <div class="mt-4 flex flex-wrap items-center justify-between gap-4 pt-4 border-t border-slate-800 text-xs text-slate-400">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-amber-500 text-slate-950 font-bold flex items-center justify-center">
                    {{ strtoupper(substr($thread->author->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-bold text-white flex items-center gap-1.5">
                        <span>{{ $thread->author->name }}</span>
                        @if($thread->author->isApprovedMember())
                            <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">Verified Member</span>
                        @endif
                        @if($thread->author->isAdmin())
                            <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-slate-800 text-slate-300 border border-slate-700">Admin</span>
                        @endif
                    </div>
                    <div class="text-slate-400 text-[11px]">
                        Started {{ $thread->created_at->format('M d, Y') }} ({{ $thread->created_at->diffForHumans() }})
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4 text-slate-400">
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    {{ $thread->views_count }} views
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    {{ $thread->replies_count }} replies
                </span>
            </div>
        </div>
    </div>
</div>

<div class="bg-slate-50 py-10 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Main Thread Card -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
            <div class="prose prose-slate max-w-none text-sm sm:text-base leading-relaxed text-slate-800 whitespace-pre-line">
                {{ $thread->body }}
            </div>

            <!-- Thread Footer Actions -->
            <div class="mt-8 pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    @auth
                        <form method="POST" action="{{ route('forum.react', ['thread', $thread->id]) }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold border transition-all {{ $thread->isLikedBy(auth()->user()) ? 'bg-amber-100 border-amber-300 text-amber-900 shadow-2xs' : 'bg-slate-50 border-slate-200 text-slate-700 hover:bg-slate-100' }}">
                                <svg class="w-4 h-4 {{ $thread->isLikedBy(auth()->user()) ? 'text-amber-600 fill-amber-500' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                <span>{{ $thread->isLikedBy(auth()->user()) ? 'Liked' : 'Like Post' }}</span>
                                <span class="ml-1 font-bold">({{ $thread->likes_count }})</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-50 border border-slate-200 text-slate-600 hover:bg-slate-100">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                            <span>{{ $thread->likes_count }} Likes</span>
                        </a>
                    @endauth
                </div>

                @if(auth()->check() && auth()->user()->isAdmin())
                    <div class="flex items-center gap-2">
                        <form method="POST" action="{{ route('admin.forum.threads.pin', $thread) }}">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-semibold border border-slate-200 text-slate-700 hover:bg-slate-100">
                                {{ $thread->is_pinned ? 'Unpin' : 'Pin to Top' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.forum.threads.lock', $thread) }}">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-semibold border border-slate-200 text-slate-700 hover:bg-slate-100">
                                {{ $thread->is_locked ? 'Unlock' : 'Lock Thread' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.forum.threads.destroy', $thread) }}" onsubmit="return confirm('Permanently delete this discussion?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100">
                                Delete
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- Replies Section -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold text-slate-900">
                    Discussion Contributions ({{ $thread->replies_count }})
                </h2>
            </div>

            @forelse($replies as $reply)
                <div class="rounded-2xl border p-6 transition-all {{ $reply->is_accepted_answer ? 'bg-emerald-50/50 border-emerald-300 shadow-xs' : 'bg-white border-slate-200 shadow-xs' }}">
                    
                    @if($reply->is_accepted_answer)
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-900 border border-emerald-300 mb-4">
                            <svg class="w-4 h-4 text-emerald-700" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Accepted Answer / Author Recommended
                        </div>
                    @endif

                    <div class="flex items-start justify-between gap-4 mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-900 text-amber-400 font-bold text-xs flex items-center justify-center">
                                {{ strtoupper(substr($reply->author->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-bold text-sm text-slate-900 flex items-center gap-1.5">
                                    <span>{{ $reply->author->name }}</span>
                                    @if($reply->author->id === $thread->user_id)
                                        <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-blue-100 text-blue-800">Author</span>
                                    @endif
                                    @if($reply->author->isApprovedMember())
                                        <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-amber-100 text-amber-900">Member</span>
                                    @endif
                                    @if($reply->author->isAdmin())
                                        <span class="px-1.5 py-0.2 rounded text-[10px] font-bold bg-slate-800 text-white">Admin</span>
                                    @endif
                                </div>
                                <div class="text-[11px] text-slate-500">
                                    {{ $reply->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        <!-- Accept answer action (thread author or admin) -->
                        @auth
                            @if(auth()->id() === $thread->user_id || auth()->user()->isAdmin())
                                <form method="POST" action="{{ route('forum.accept', $reply->id) }}">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold transition-colors {{ $reply->is_accepted_answer ? 'bg-emerald-600 text-white hover:bg-emerald-700' : 'bg-slate-100 text-slate-700 hover:bg-emerald-100 hover:text-emerald-900' }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        {{ $reply->is_accepted_answer ? 'Accepted Solution' : 'Accept Solution' }}
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>

                    <div class="text-sm leading-relaxed text-slate-800 whitespace-pre-line pl-11">
                        {{ $reply->body }}
                    </div>

                    <!-- Reply Footer Actions -->
                    <div class="mt-4 pt-3 border-t border-slate-100/80 flex items-center justify-between pl-11 text-xs">
                        @auth
                            <form method="POST" action="{{ route('forum.react', ['reply', $reply->id]) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1 text-xs font-semibold {{ $reply->isLikedBy(auth()->user()) ? 'text-amber-600' : 'text-slate-500 hover:text-slate-900' }}">
                                    <svg class="w-3.5 h-3.5" fill="{{ $reply->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                    <span>Helpful ({{ $reply->likes_count }})</span>
                                </button>
                            </form>
                        @else
                            <span class="text-slate-400">{{ $reply->likes_count }} Helpful</span>
                        @endauth

                        @if(auth()->check() && auth()->user()->isAdmin())
                            <form method="POST" action="{{ route('admin.forum.replies.destroy', $reply) }}" onsubmit="return confirm('Delete this reply?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:underline">Remove</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center text-slate-500 text-xs">
                    No replies yet. Be the first to share an answer or perspective!
                </div>
            @endforelse
        </div>

        <!-- Reply Composer -->
        @if($thread->is_locked)
            <div class="bg-slate-100 rounded-2xl border border-slate-300 p-6 text-center text-slate-600 text-xs font-semibold">
                🔒 This discussion has been locked by community moderators. Additional responses are disabled.
            </div>
        @elseif(auth()->check())
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
                <h3 class="text-base font-bold text-slate-900 mb-2">Contribute to the Discussion</h3>
                <p class="text-xs text-slate-500 mb-4">Please share constructive analysis, citing relevant empirical frameworks or regulatory statutes where applicable.</p>

                <form method="POST" action="{{ route('forum.reply', [$channel->slug, $thread->slug]) }}">
                    @csrf
                    <div>
                        <textarea name="body" rows="5" required placeholder="Type your response or proposed solution here..." class="w-full px-4 py-3 rounded-xl border border-slate-300 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 leading-relaxed"></textarea>
                        @error('body')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4 flex items-center justify-end">
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-md shadow-amber-500/20 transition-all hover:scale-[1.02]">
                            Post Contribution
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center shadow-xs">
                <h3 class="text-base font-bold text-slate-900">Join this discussion</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-md mx-auto">Sign in to your Brands Academy account to participate in peer debates and share expert counsel.</p>
                <div class="mt-4 flex items-center justify-center gap-3">
                    <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs">
                        Sign In
                    </a>
                    <a href="{{ route('membership.register') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 font-semibold text-xs">
                        Join Membership
                    </a>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
