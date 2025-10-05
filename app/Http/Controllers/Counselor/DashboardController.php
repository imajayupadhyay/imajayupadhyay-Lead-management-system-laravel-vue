<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\FollowUp;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the counselor dashboard.
     */
    public function index(): Response
    {
        $counselor = auth()->guard('counselor')->user();

        // Get lead statistics
        $stats = [
            'total_leads' => Lead::forCounselor($counselor->id)->count(),
            'hot_leads' => Lead::forCounselor($counselor->id)->hot()->count(),
            'warm_leads' => Lead::forCounselor($counselor->id)->warm()->count(),
            'cold_leads' => Lead::forCounselor($counselor->id)->cold()->count(),
            'new_leads' => Lead::forCounselor($counselor->id)->where('status', 'New')->count(),
            'interested_leads' => Lead::forCounselor($counselor->id)->where('status', 'Interested')->count(),
            'enrolled_leads' => Lead::forCounselor($counselor->id)->where('status', 'Enrolled')->count(),
        ];

        // Get follow-up statistics
        $followUpStats = [
            'total_follow_ups' => FollowUp::forCounselor($counselor->id)->count(),
            'today_follow_ups' => FollowUp::forCounselor($counselor->id)->today()->pending()->count(),
            'overdue_follow_ups' => FollowUp::forCounselor($counselor->id)->overdue()->count(),
            'upcoming_follow_ups' => FollowUp::forCounselor($counselor->id)->upcoming()->count(),
        ];

        // Get today's follow-ups
        $todayFollowUps = FollowUp::with('lead')
            ->forCounselor($counselor->id)
            ->today()
            ->pending()
            ->orderBy('follow_up_time', 'asc')
            ->limit(5)
            ->get();

        // Get overdue follow-ups
        $overdueFollowUps = FollowUp::with('lead')
            ->forCounselor($counselor->id)
            ->overdue()
            ->orderBy('follow_up_date', 'asc')
            ->limit(5)
            ->get();

        // Get recent leads
        $recentLeads = Lead::forCounselor($counselor->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return Inertia::render('Counselor/Dashboard', [
            'user' => $counselor,
            'stats' => $stats,
            'followUpStats' => $followUpStats,
            'todayFollowUps' => $todayFollowUps,
            'overdueFollowUps' => $overdueFollowUps,
            'recentLeads' => $recentLeads,
        ]);
    }
}