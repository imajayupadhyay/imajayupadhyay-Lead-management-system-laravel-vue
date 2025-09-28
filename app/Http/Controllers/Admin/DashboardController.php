<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Lead;
use App\Models\Counselor;
use App\Models\Marketer;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): Response
    {
        // Get comprehensive statistics
        $stats = $this->getDashboardStats();

        // Get leads analytics data
        $leadsAnalytics = $this->getLeadsAnalytics();

        return Inertia::render('Admin/Dashboard', [
            'user' => auth()->user(),
            'stats' => $stats,
            'leadsAnalytics' => $leadsAnalytics,
        ]);
    }

    /**
     * Get dashboard statistics
     */
    private function getDashboardStats(): array
    {
        return [
            'users' => [
                'total' => User::count(),
                'active' => User::where('is_active', true)->count(),
                'admins' => User::where('role', 'admin')->count(),
                'recent' => User::where('created_at', '>=', Carbon::now()->subDays(30))->count(),
            ],
            'leads' => [
                'total' => Lead::count(),
                'new' => Lead::where('status', 'New')->count(),
                'contacted' => Lead::where('status', 'Contacted')->count(),
                'interested' => Lead::where('status', 'Interested')->count(),
                'enrolled' => Lead::where('status', 'Enrolled')->count(),
                'not_interested' => Lead::where('status', 'Not Interested')->count(),
                'today' => Lead::whereDate('created_at', Carbon::today())->count(),
                'this_week' => Lead::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
                'this_month' => Lead::whereMonth('created_at', Carbon::now()->month)->count(),
            ],
            'counselors' => [
                'total' => Counselor::count(),
                'active' => Counselor::where('is_active', true)->count(),
                'inactive' => Counselor::where('is_active', false)->count(),
            ],
            'marketers' => [
                'total' => Marketer::count(),
                'active' => Marketer::where('is_active', true)->count(),
                'inactive' => Marketer::where('is_active', false)->count(),
            ],
            'faculty' => [
                'total' => Faculty::count(),
                'active' => Faculty::where('is_active', true)->count(),
                'inactive' => Faculty::where('is_active', false)->count(),
            ],
        ];
    }

    /**
     * Get leads analytics data for charts
     */
    private function getLeadsAnalytics(): array
    {
        // Leads by status (for pie chart)
        $leadsByStatus = Lead::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Leads trend over last 30 days (for line chart)
        $leadsLast30Days = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $leadsLast30Days[] = [
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('M j'),
                'count' => Lead::whereDate('created_at', $date)->count(),
            ];
        }

        // Leads by course interest (for bar chart)
        $leadsByCourse = Lead::select('interested_in', DB::raw('count(*) as count'))
            ->whereNotNull('interested_in')
            ->where('interested_in', '!=', '')
            ->groupBy('interested_in')
            ->pluck('count', 'interested_in')
            ->toArray();

        // Process course data (since interested_in is stored as JSON)
        $courseStats = [];
        foreach ($leadsByCourse as $courses => $count) {
            $coursesArray = json_decode($courses, true);
            if (is_array($coursesArray)) {
                foreach ($coursesArray as $course) {
                    if (!isset($courseStats[$course])) {
                        $courseStats[$course] = 0;
                    }
                    $courseStats[$course] += $count;
                }
            }
        }

        // Monthly leads comparison (current vs previous month)
        $currentMonth = Lead::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $previousMonth = Lead::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        return [
            'leadsByStatus' => $leadsByStatus,
            'leadsLast30Days' => $leadsLast30Days,
            'leadsByCourse' => $courseStats,
            'monthlyComparison' => [
                'current' => $currentMonth,
                'previous' => $previousMonth,
                'growth' => $previousMonth > 0 ? round((($currentMonth - $previousMonth) / $previousMonth) * 100, 1) : 0,
            ],
        ];
    }
}