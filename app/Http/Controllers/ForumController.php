<?php

namespace App\Http\Controllers;

use App\Models\ForumChannel;
use App\Models\ForumReaction;
use App\Models\ForumReply;
use App\Models\ForumThread;
use App\Notifications\EcosystemActivityNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForumController extends Controller
{
    /**
     * Display community discussion board.
     */
    public function index(Request $request): View
    {
        $channels = ForumChannel::where('is_active', true)
            ->withCount('threads')
            ->orderBy('sort_order')
            ->get();

        $query = ForumThread::with(['channel', 'author.member'])
            ->withCount('replies');

        // Channel filter
        if ($request->filled('channel')) {
            $query->whereHas('channel', function ($q) use ($request): void {
                $q->where('slug', $request->query('channel'));
            });
        }

        // Search filter
        if ($request->filled('q')) {
            $search = '%'.$request->query('q').'%';
            $query->where(function ($q) use ($search): void {
                $q->where('title', 'like', $search)
                    ->orWhere('body', 'like', $search);
            });
        }

        // Sort filter
        $sort = $request->query('sort', 'recent');
        if ($sort === 'popular') {
            $query->orderByDesc('replies_count')->orderByDesc('likes_count');
        } elseif ($sort === 'unanswered') {
            $query->where('replies_count', 0)->latest();
        } else {
            // Default: pinned first, then newest activity
            $query->orderByDesc('is_pinned')->orderByDesc('last_activity_at');
        }

        $threads = $query->paginate(15)->withQueryString();

        $selectedChannel = $request->filled('channel')
            ? ForumChannel::where('slug', $request->query('channel'))->first()
            : null;

        return view('forum.index', [
            'channels' => $channels,
            'threads' => $threads,
            'selectedChannel' => $selectedChannel,
            'currentSort' => $sort,
        ]);
    }

    /**
     * Filter threads by specific channel.
     */
    public function channel(string $slug, Request $request): View
    {
        $channel = ForumChannel::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $channels = ForumChannel::where('is_active', true)
            ->withCount('threads')
            ->orderBy('sort_order')
            ->get();

        $sort = $request->query('sort', 'recent');

        $query = ForumThread::where('channel_id', $channel->id)
            ->with(['channel', 'author.member'])
            ->withCount('replies');

        if ($request->filled('q')) {
            $search = '%'.$request->query('q').'%';
            $query->where(function ($q) use ($search): void {
                $q->where('title', 'like', $search)
                    ->orWhere('body', 'like', $search);
            });
        }

        if ($sort === 'popular') {
            $query->orderByDesc('replies_count')->orderByDesc('likes_count');
        } elseif ($sort === 'unanswered') {
            $query->where('replies_count', 0)->latest();
        } else {
            $query->orderByDesc('is_pinned')->orderByDesc('last_activity_at');
        }

        $threads = $query->paginate(15)->withQueryString();

        return view('forum.index', [
            'channels' => $channels,
            'threads' => $threads,
            'selectedChannel' => $channel,
            'currentSort' => $sort,
        ]);
    }

    /**
     * Display a single discussion thread.
     */
    public function show(string $channelSlug, string $threadSlug): View
    {
        $channel = ForumChannel::where('slug', $channelSlug)->firstOrFail();

        $thread = ForumThread::where('channel_id', $channel->id)
            ->where('slug', $threadSlug)
            ->with(['author.member', 'channel'])
            ->firstOrFail();

        // Increment views safely
        $thread->increment('views_count');

        $replies = $thread->replies()
            ->with(['author.member', 'children.author.member'])
            ->whereNull('parent_reply_id')
            ->orderByDesc('is_accepted_answer')
            ->oldest()
            ->get();

        return view('forum.show', [
            'channel' => $channel,
            'thread' => $thread,
            'replies' => $replies,
        ]);
    }

    /**
     * Show form to compose a new thread.
     */
    public function create(): View
    {
        $channels = ForumChannel::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('forum.create', [
            'channels' => $channels,
        ]);
    }

    /**
     * Store a newly created discussion thread.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'channel_id' => ['required', 'exists:forum_channels,id'],
            'title' => ['required', 'string', 'min:5', 'max:250'],
            'body' => ['required', 'string', 'min:15', 'max:10000'],
        ]);

        $channel = ForumChannel::findOrFail($validated['channel_id']);
        $user = $request->user();

        // Enforce member-only channel restriction
        if ($channel->is_member_only && ! $user->isApprovedMember() && ! $user->isAdmin()) {
            return back()
                ->withInput()
                ->with('error', "The channel \"{$channel->name}\" is reserved exclusively for verified Foundation members.");
        }

        $thread = ForumThread::create([
            'channel_id' => $channel->id,
            'user_id' => $user->id,
            'title' => $validated['title'],
            'body' => $validated['body'],
            'last_activity_at' => now(),
        ]);

        return redirect()->route('forum.show', [$channel->slug, $thread->slug])
            ->with('success', 'Your discussion thread has been published to the community board!');
    }

    /**
     * Store a reply to a thread.
     */
    public function storeReply(Request $request, string $channelSlug, string $threadSlug): RedirectResponse
    {
        $channel = ForumChannel::where('slug', $channelSlug)->firstOrFail();
        $thread = ForumThread::where('channel_id', $channel->id)->where('slug', $threadSlug)->firstOrFail();

        if ($thread->is_locked) {
            return back()->with('error', 'This discussion thread has been locked by moderators. New replies are disabled.');
        }

        $validated = $request->validate([
            'body' => ['required', 'string', 'min:3', 'max:5000'],
            'parent_reply_id' => ['nullable', 'exists:forum_replies,id'],
        ]);

        $reply = ForumReply::create([
            'thread_id' => $thread->id,
            'user_id' => $request->user()->id,
            'parent_reply_id' => $validated['parent_reply_id'] ?? null,
            'body' => $validated['body'],
        ]);

        if ($thread->author && $thread->user_id !== $request->user()->id) {
            $thread->author->notify(new EcosystemActivityNotification(
                title: 'New Community Discussion Reply',
                message: "{$request->user()->name} replied to your topic: \"{$thread->title}\"",
                actionUrl: route('forum.show', [$channel->slug, $thread->slug]),
                category: 'forum',
                badgeText: $channel->name
            ));
        }

        return redirect()->route('forum.show', [$channel->slug, $thread->slug])
            ->with('success', 'Your reply has been posted.');
    }

    /**
     * Toggle reaction (like / upvote) on thread or reply.
     */
    public function toggleReaction(Request $request, string $type, int $id): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        $modelClass = match ($type) {
            'thread' => ForumThread::class,
            'reply' => ForumReply::class,
            default => abort(404),
        };

        $model = $modelClass::findOrFail($id);

        $existing = ForumReaction::where('user_id', $user->id)
            ->where('reactable_type', $modelClass)
            ->where('reactable_id', $model->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $model->decrement('likes_count');
            $liked = false;
        } else {
            ForumReaction::create([
                'user_id' => $user->id,
                'reactable_type' => $modelClass,
                'reactable_id' => $model->id,
                'reaction' => 'like',
            ]);
            $model->increment('likes_count');
            $liked = true;
        }

        if ($request->wantsJson()) {
            return response()->json([
                'liked' => $liked,
                'likes_count' => $model->fresh()->likes_count,
            ]);
        }

        return back();
    }

    /**
     * Mark a reply as the accepted answer (Thread Author or Admin).
     */
    public function acceptAnswer(Request $request, int $replyId): RedirectResponse
    {
        $reply = ForumReply::with(['thread.channel', 'author'])->findOrFail($replyId);
        $user = $request->user();

        if ($reply->thread->user_id !== $user->id && ! $user->isAdmin()) {
            abort(403, 'Only the author of this thread or an administrator can mark an accepted answer.');
        }

        // Toggle or unset existing
        if ($reply->is_accepted_answer) {
            $reply->update(['is_accepted_answer' => false]);
            $message = 'Accepted answer marked as unselected.';
        } else {
            // Unmark any previous accepted answers in this thread
            ForumReply::where('thread_id', $reply->thread_id)->update(['is_accepted_answer' => false]);
            $reply->update(['is_accepted_answer' => true]);
            $message = 'This contribution has been marked as the Accepted Answer!';

            if ($reply->author && $reply->user_id !== $user->id) {
                $reply->author->notify(new EcosystemActivityNotification(
                    title: 'Contribution Endorsed as Accepted Answer',
                    message: "Your answer on \"{$reply->thread->title}\" was accepted by the author!",
                    actionUrl: route('forum.show', [$reply->thread->channel->slug, $reply->thread->slug]),
                    category: 'forum',
                    badgeText: 'Accepted Answer'
                ));
            }
        }

        return back()->with('success', $message);
    }
}
