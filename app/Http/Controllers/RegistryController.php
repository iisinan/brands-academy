<?php

namespace App\Http\Controllers;

use App\Models\ConferenceDelegate;
use App\Models\CourseEnrollment;
use App\Models\JournalArticle;
use App\Models\Member;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RegistryController extends Controller
{
    /**
     * Public Directory of Certified Brand Practitioners.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $category = $request->query('category');
        $state = $request->query('state');

        $query = Member::query()
            ->where('status', 'active')
            ->whereIn('payment_status', ['paid', 'waived'])
            ->whereNotNull('member_number')
            ->with(['user', 'certificates']);

        if (! empty($search)) {
            $query->where(function ($q) use ($search): void {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('member_number', 'like', "%{$search}%")
                    ->orWhere('institution_or_company', 'like', "%{$search}%")
                    ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        if (! empty($category) && $category !== 'all') {
            $query->where('category', $category);
        }

        if (! empty($state) && $state !== 'all') {
            $query->where('state', $state);
        }

        $members = $query->orderBy('first_name')
            ->paginate(12)
            ->withQueryString();

        $categories = [
            'fellow' => 'Fellows of Brands Academy (FBA)',
            'professional' => 'Certified Brand Professionals',
            'associate' => 'Associate Brand Practitioners',
            'student' => 'Student / Academic Affiliates',
        ];

        $states = Member::where('status', 'active')
            ->whereIn('payment_status', ['paid', 'waived'])
            ->whereNotNull('state')
            ->distinct()
            ->pluck('state')
            ->sort()
            ->values();

        $totalPractitioners = Member::where('status', 'active')
            ->whereIn('payment_status', ['paid', 'waived'])
            ->whereNotNull('member_number')
            ->count();

        return view('registry.index', compact(
            'members',
            'search',
            'category',
            'state',
            'categories',
            'states',
            'totalPractitioners'
        ));
    }

    /**
     * Public Verified Practitioner Profile & Credential Dossier.
     */
    public function show(string $memberNumber): View
    {
        $member = Member::where('member_number', $memberNumber)
            ->where('status', 'active')
            ->whereIn('payment_status', ['paid', 'waived'])
            ->with(['user', 'certificates'])
            ->firstOrFail();

        $user = $member->user;

        $completedCourses = $user
            ? CourseEnrollment::where('user_id', $user->id)
                ->whereIn('status', ['active', 'completed'])
                ->where('progress_percentage', 100)
                ->with(['course', 'certificate'])
                ->get()
            : collect();

        $conferencesAttended = $user
            ? ConferenceDelegate::where('user_id', $user->id)
                ->with('conference')
                ->get()
            : collect();

        $publishedArticles = $user
            ? JournalArticle::where('submitted_by_user_id', $user->id)
                ->where('submission_status', JournalArticle::STATUS_PUBLISHED)
                ->with('issue.volume')
                ->get()
            : collect();

        // Calculate cumulative CPD units
        $cpdUnits = ($completedCourses->count() * 10)
            + ($conferencesAttended->count() * 15)
            + ($publishedArticles->count() * 20)
            + ($member->certificates->count() * 10);

        return view('registry.show', compact(
            'member',
            'completedCourses',
            'conferencesAttended',
            'publishedArticles',
            'cpdUnits'
        ));
    }
}
