@extends(auth()->check() && auth()->user()->member ? 'layouts.member' : 'layouts.app')

@section('title', 'Notifications & Activity Center | Brands Academy')
@section('page_title', 'Notifications & Activity Center')

@section('content')
<div class="min-h-screen bg-slate-50 py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb & Top Bar -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ auth()->user()->member ? route('member.dashboard') : route('home') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-slate-800 transition-colors mb-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    <span>{{ auth()->user()->member ? 'Back to Member Dashboard' : 'Back to Home' }}</span>
                </a>
                <h1 class="text-2xl sm:text-3xl font-extrabold font-serif-title text-slate-900 tracking-tight flex items-center gap-3">
                    <span>Notifications &amp; Activity Center</span>
                    @if($unreadCount > 0)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                            {{ $unreadCount }} unread
                        </span>
                    @endif
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Real-time updates regarding your statutory filings, course credentials, conference passes, and academy activity.
                </p>
            </div>

            @if($unreadCount > 0)
                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs border border-slate-200 shadow-xs transition-all">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Mark All as Read</span>
                    </button>
                </form>
            @endif
        </div>

        <!-- Filter Tabs -->
        <div class="flex items-center gap-2 border-b border-slate-200 mb-6 pb-2 text-xs font-bold">
            <a href="{{ route('notifications.index', ['filter' => 'all']) }}"
               class="px-3 py-1.5 rounded-lg transition-colors {{ $filter !== 'unread' ? 'bg-blue-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-200' }}">
                All Updates ({{ $notifications->total() }})
            </a>
            <a href="{{ route('notifications.index', ['filter' => 'unread']) }}"
               class="px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1.5 {{ $filter === 'unread' ? 'bg-blue-600 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-200' }}">
                <span>Unread Only</span>
                @if($unreadCount > 0)
                    <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $filter === 'unread' ? 'bg-white text-blue-700' : 'bg-blue-600 text-white' }} font-mono font-bold">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>
        </div>

        <!-- Notifications List -->
        <div class="space-y-3">
            @forelse($notifications as $notification)
                @php
                    $isUnread = is_null($notification->read_at);
                    $data = $notification->data;
                    $category = $data['category'] ?? 'system';
                    $title = $data['title'] ?? 'System Notification';
                    $message = $data['message'] ?? '';
                    $actionUrl = $data['action_url'] ?? null;
                    $badgeText = $data['badge_text'] ?? null;
                @endphp

                <div class="bg-white rounded-2xl border transition-all p-4 sm:p-5 flex items-start gap-4 relative {{ $isUnread ? 'border-blue-300 shadow-sm ring-1 ring-blue-100 bg-blue-50/20' : 'border-slate-200 hover:border-slate-300' }}">
                    <!-- Category Icon Pill -->
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-xs
                        @if($category === 'filing') bg-blue-100 text-blue-700 border border-blue-200
                        @elseif($category === 'certificate') bg-amber-100 text-amber-700 border border-amber-200
                        @elseif($category === 'course') bg-emerald-100 text-emerald-700 border border-emerald-200
                        @elseif($category === 'conference') bg-indigo-100 text-indigo-700 border border-indigo-200
                        @elseif($category === 'forum') bg-purple-100 text-purple-700 border border-purple-200
                        @else bg-slate-100 text-slate-700 border border-slate-200
                        @endif">
                        @if($category === 'filing')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        @elseif($category === 'certificate')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        @elseif($category === 'course')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        @elseif($category === 'conference')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        @elseif($category === 'forum')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        @endif
                    </div>

                    <!-- Details -->
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center justify-between gap-2 mb-1">
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-bold text-slate-900">{{ $title }}</h3>
                                @if($isUnread)
                                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse" title="Unread"></span>
                                @endif
                                @if($badgeText)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $badgeText }}
                                    </span>
                                @endif
                            </div>
                            <span class="text-[11px] text-slate-400 font-mono">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>

                        <p class="text-xs text-slate-600 leading-relaxed mb-3">
                            {{ $message }}
                        </p>

                        <!-- Actions cluster -->
                        <div class="flex items-center gap-3">
                            @if(! empty($actionUrl))
                                <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs shadow-xs transition-all">
                                        <span>View Details</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </button>
                                </form>
                            @endif

                            @if($isUnread)
                                <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xs text-slate-500 hover:text-slate-800 font-medium transition-colors">
                                        Mark as read
                                    </button>
                                </form>
                            @else
                                <span class="text-[11px] text-slate-400 font-medium">Read {{ $notification->read_at->diffForHumans() }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-xs">
                    <div class="w-16 h-16 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-4 border border-blue-100">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">You're All Caught Up!</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto">
                        There are no {{ $filter === 'unread' ? 'unread' : '' }} notifications in your account right now. Updates on your courses, filings, and credentials will appear here.
                    </p>
                    @if($filter === 'unread')
                        <div class="mt-4">
                            <a href="{{ route('notifications.index', ['filter' => 'all']) }}" class="text-xs text-blue-600 hover:underline font-bold">
                                View all notification history &rarr;
                            </a>
                        </div>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
