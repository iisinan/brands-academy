<?php

namespace App\Http\Controllers;

use App\Models\ForumChannel;
use App\Models\ForumReply;
use App\Models\ForumThread;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminForumController extends Controller
{
    /**
     * Display forum moderation desk.
     */
    public function index(Request $request): View
    {
        $query = ForumThread::with(['channel', 'author'])
            ->withCount('replies');

        if ($request->filled('channel')) {
            $query->where('channel_id', $request->query('channel'));
        }

        if ($request->filled('q')) {
            $search = '%'.$request->query('q').'%';
            $query->where(function ($q) use ($search): void {
                $q->where('title', 'like', $search)
                    ->orWhere('body', 'like', $search);
            });
        }

        $threads = $query->latest('last_activity_at')->paginate(20)->withQueryString();
        $channels = ForumChannel::orderBy('sort_order')->get();

        $stats = [
            'total_threads' => ForumThread::count(),
            'total_replies' => ForumReply::count(),
            'pinned_threads' => ForumThread::where('is_pinned', true)->count(),
            'locked_threads' => ForumThread::where('is_locked', true)->count(),
        ];

        return view('admin.forum.index', [
            'threads' => $threads,
            'channels' => $channels,
            'stats' => $stats,
        ]);
    }

    /**
     * Toggle pinned status of a thread.
     */
    public function togglePin(ForumThread $thread): RedirectResponse
    {
        $thread->update(['is_pinned' => ! $thread->is_pinned]);

        $status = $thread->is_pinned ? 'pinned to the top of the channel' : 'unpinned';

        return back()->with('success', "Thread #{$thread->id} \"{$thread->title}\" has been {$status}.");
    }

    /**
     * Toggle locked status of a thread.
     */
    public function toggleLock(ForumThread $thread): RedirectResponse
    {
        $thread->update(['is_locked' => ! $thread->is_locked]);

        $status = $thread->is_locked ? 'locked against new replies' : 'unlocked for discussion';

        return back()->with('success', "Thread #{$thread->id} \"{$thread->title}\" has been {$status}.");
    }

    /**
     * Delete an inappropriate or spam thread.
     */
    public function destroyThread(ForumThread $thread): RedirectResponse
    {
        $title = $thread->title;
        $thread->delete();

        return back()->with('success', "Thread \"{$title}\" and all associated replies have been removed.");
    }

    /**
     * Delete a single reply.
     */
    public function destroyReply(ForumReply $reply): RedirectResponse
    {
        $reply->delete();

        return back()->with('success', 'The reply has been permanently removed by moderator.');
    }
}
