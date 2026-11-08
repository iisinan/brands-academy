<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Workshop;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Show the application landing page.
     */
    public function index(): View
    {
        $openWorkshops = Workshop::query()
            ->where('status', 'published')
            ->where('application_starts_at', '<=', now())
            ->where('application_deadline', '>=', now())
            ->orderBy('application_deadline', 'asc')
            ->take(3)
            ->get();

        $allWorkshops = Workshop::query()
            ->where('status', 'published')
            ->orderByDesc('is_featured')
            ->orderBy('application_starts_at', 'asc')
            ->take(6)
            ->get();

        $stats = [
            'total_members' => Member::count(),
            'active_cohorts' => Workshop::where('status', 'published')->count(),
            'governance_board' => 4,
            'cac_number' => '7344471',
        ];

        return view('home', compact('openWorkshops', 'allWorkshops', 'stats'));
    }

    /**
     * Show the institutional credential, manifesto, and governance page.
     */
    public function about(): View
    {
        return view('about');
    }
}
