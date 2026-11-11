<?php

namespace App\Http\Controllers;

use App\Models\JournalArticle;
use App\Models\JournalIssue;
use App\Models\JournalVolume;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminJournalController extends Controller
{
    /**
     * Admin Editorial Desk Overview.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $query = JournalArticle::with(['issue.volume', 'authors', 'submittedBy']);

        if (! empty($status) && $status !== 'all') {
            $query->where('submission_status', $status);
        }

        $articles = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        $volumes = JournalVolume::with('issues')->orderBy('volume_number', 'desc')->get();

        $stats = [
            'total_papers' => JournalArticle::count(),
            'published' => JournalArticle::where('submission_status', JournalArticle::STATUS_PUBLISHED)->count(),
            'under_review' => JournalArticle::where('submission_status', JournalArticle::STATUS_UNDER_REVIEW)->count(),
            'submitted' => JournalArticle::where('submission_status', JournalArticle::STATUS_SUBMITTED)->count(),
            'volumes_count' => JournalVolume::count(),
            'issues_count' => JournalIssue::count(),
        ];

        return view('admin.journal.index', [
            'articles' => $articles,
            'volumes' => $volumes,
            'stats' => $stats,
            'selectedStatus' => $status,
        ]);
    }

    /**
     * Create Volume.
     */
    public function storeVolume(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'volume_number' => ['required', 'integer', 'min:1', 'max:100'],
            'year' => ['required', 'integer', 'min:2020', 'max:2035'],
            'title' => ['nullable', 'string', 'max:255'],
        ]);

        JournalVolume::create($validated);

        return back()->with('success', "Journal Volume {$validated['volume_number']} created!");
    }

    /**
     * Create Issue inside Volume.
     */
    public function storeIssue(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'volume_id' => ['required', 'exists:journal_volumes,id'],
            'issue_number' => ['required', 'integer', 'min:1', 'max:20'],
            'title' => ['nullable', 'string', 'max:255'],
            'published_date' => ['required', 'date'],
        ]);

        JournalIssue::create($validated);

        return back()->with('success', "Journal Issue {$validated['issue_number']} created successfully!");
    }

    /**
     * Update Manuscript Status & Publication Particulars.
     */
    public function updateManuscript(Request $request, int $id): RedirectResponse
    {
        $article = JournalArticle::findOrFail($id);

        $validated = $request->validate([
            'submission_status' => ['required', 'string', 'in:draft,submitted,under_review,revision_required,accepted,published,declined'],
            'issue_id' => ['nullable', 'exists:journal_issues,id'],
            'doi' => ['nullable', 'string', 'max:100'],
            'page_start' => ['nullable', 'integer', 'min:1'],
            'page_end' => ['nullable', 'integer', 'min:1'],
        ]);

        if ($validated['submission_status'] === JournalArticle::STATUS_PUBLISHED && empty($article->published_at)) {
            $validated['published_at'] = now();
        }

        $article->update($validated);

        return back()->with('success', "Manuscript '{$article->title}' updated to ".ucfirst(str_replace('_', ' ', $validated['submission_status'])));
    }
}
