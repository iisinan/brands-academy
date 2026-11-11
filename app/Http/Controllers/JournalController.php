<?php

namespace App\Http\Controllers;

use App\Models\ArticleAuthor;
use App\Models\JournalArticle;
use App\Models\JournalIssue;
use App\Models\JournalVolume;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class JournalController extends Controller
{
    /**
     * Journal of Brand Strategy & Management (JBSM) Public Portal.
     */
    public function index(Request $request): View
    {
        $search = $request->query('q');
        $issueId = $request->query('issue');

        $query = JournalArticle::where('submission_status', JournalArticle::STATUS_PUBLISHED)
            ->with(['issue.volume', 'authors']);

        if (! empty($issueId)) {
            $query->where('issue_id', $issueId);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search): void {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('abstract', 'like', "%{$search}%")
                    ->orWhere('keywords', 'like', "%{$search}%")
                    ->orWhereHas('authors', function ($aq) use ($search): void {
                        $aq->where('full_name', 'like', "%{$search}%")
                            ->orWhere('affiliation', 'like', "%{$search}%");
                    });
            });
        }

        $articles = $query->orderBy('published_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $latestIssue = JournalIssue::where('is_published', true)
            ->with(['volume', 'publishedArticles'])
            ->orderBy('published_date', 'desc')
            ->first();

        $volumes = JournalVolume::where('is_published', true)
            ->with(['issues' => function ($q): void {
                $q->where('is_published', true)->orderBy('issue_number', 'desc');
            }])
            ->orderBy('volume_number', 'desc')
            ->get();

        return view('journal.index', [
            'articles' => $articles,
            'latestIssue' => $latestIssue,
            'volumes' => $volumes,
            'search' => $search,
            'selectedIssue' => $issueId,
        ]);
    }

    /**
     * Article Reader & Academic Citation View.
     */
    public function show(string $slug): View
    {
        $article = JournalArticle::where('slug', $slug)
            ->where('submission_status', JournalArticle::STATUS_PUBLISHED)
            ->with(['issue.volume', 'authors'])
            ->firstOrFail();

        $article->increment('views_count');

        $relatedArticles = JournalArticle::where('submission_status', JournalArticle::STATUS_PUBLISHED)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('journal.show', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
        ]);
    }

    /**
     * Download Open-Access Article PDF.
     */
    public function downloadPdf(string $slug): StreamedResponse|RedirectResponse
    {
        $article = JournalArticle::where('slug', $slug)->firstOrFail();

        if (empty($article->manuscript_pdf_path) || ! Storage::disk('public')->exists($article->manuscript_pdf_path)) {
            return back()->with('error', 'The requested manuscript PDF file is currently being prepared for archiving.');
        }

        $article->increment('downloads_count');

        return Storage::disk('public')->download($article->manuscript_pdf_path, "JBSM-{$article->slug}.pdf");
    }

    /**
     * Author Manuscript Submission View.
     */
    public function submit(): View
    {
        return view('journal.submit');
    }

    /**
     * Process Manuscript Submission.
     */
    public function storeSubmission(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:350'],
            'abstract' => ['required', 'string', 'min:120', 'max:5000'],
            'keywords' => ['required', 'string', 'max:255'],
            'manuscript_pdf' => ['required', 'file', 'mimes:pdf', 'max:25600'],
            'primary_author_name' => ['required', 'string', 'max:150'],
            'primary_author_affiliation' => ['required', 'string', 'max:200'],
            'primary_author_email' => ['required', 'email', 'max:255'],
            'primary_author_orcid' => ['nullable', 'string', 'max:50'],
            'coauthors' => ['nullable', 'string', 'max:1000'],
        ]);

        $pdfPath = $request->file('manuscript_pdf')->store('journal/manuscripts', 'public');

        $article = JournalArticle::create([
            'submitted_by_user_id' => $request->user()?->id,
            'title' => $validated['title'],
            'abstract' => $validated['abstract'],
            'keywords' => $validated['keywords'],
            'manuscript_pdf_path' => $pdfPath,
            'submission_status' => JournalArticle::STATUS_SUBMITTED,
        ]);

        // Primary author
        ArticleAuthor::create([
            'article_id' => $article->id,
            'full_name' => $validated['primary_author_name'],
            'affiliation' => $validated['primary_author_affiliation'],
            'email' => $validated['primary_author_email'],
            'orcid_id' => $validated['primary_author_orcid'] ?? null,
            'is_corresponding' => true,
            'sort_order' => 1,
        ]);

        // Parse optional co-authors if provided
        if (! empty($validated['coauthors'])) {
            $coauthors = array_filter(array_map('trim', explode("\n", $validated['coauthors'])));
            $sort = 2;
            foreach ($coauthors as $coauthorLine) {
                // Format: Name | Affiliation | Email
                $parts = array_map('trim', explode('|', $coauthorLine));
                if (! empty($parts[0])) {
                    ArticleAuthor::create([
                        'article_id' => $article->id,
                        'full_name' => $parts[0],
                        'affiliation' => $parts[1] ?? 'Co-Author',
                        'email' => $parts[2] ?? null,
                        'is_corresponding' => false,
                        'sort_order' => $sort++,
                    ]);
                }
            }
        }

        return redirect()->route('journal.index')
            ->with('success', 'Manuscript successfully submitted to the Journal of Brand Strategy & Management! Our editorial office will conduct initial screening.');
    }
}
