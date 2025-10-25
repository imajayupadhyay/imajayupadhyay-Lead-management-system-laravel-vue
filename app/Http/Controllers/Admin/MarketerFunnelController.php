<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Marketer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Carbon\Carbon;

class MarketerFunnelController extends Controller
{
    /**
     * Display the marketer funnel analytics dashboard.
     */
    public function index(Request $request): Response
    {
        // Get date range filters
        $dateFrom = $request->input('date_from', now()->startOfMonth()->toDateString());
        $dateTo = $request->input('date_to', now()->endOfMonth()->toDateString());
        $marketerId = $request->input('marketer_id');

        // Lead Distribution by Marketer
        $leadsByMarketer = $this->getLeadsByMarketer($dateFrom, $dateTo);

        // Leads by Status (for selected marketer or all)
        $leadsByStatus = $this->getLeadsByStatus($dateFrom, $dateTo, $marketerId);

        // Leads Trend (Daily)
        $leadsTrend = $this->getLeadsTrend($dateFrom, $dateTo, $marketerId);

        // Lead Category Distribution
        $leadCategoryDistribution = $this->getLeadCategoryDistribution($dateFrom, $dateTo, $marketerId);

        // Conversion Rates
        $conversionRates = $this->getConversionRates($dateFrom, $dateTo, $marketerId);

        // Top Performing Marketers
        $topMarketers = $this->getTopMarketers($dateFrom, $dateTo);

        // Summary Statistics
        $summaryStats = $this->getSummaryStats($dateFrom, $dateTo, $marketerId);

        // Lead Quality Metrics
        $leadQualityMetrics = $this->getLeadQualityMetrics($dateFrom, $dateTo, $marketerId);

        // Lead Source/Enquiry Distribution
        $enquiryByDistribution = $this->getEnquiryByDistribution($dateFrom, $dateTo, $marketerId);

        // Get marketers for filter
        $marketers = Marketer::active()
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Admin/MarketerFunnel/Index', [
            'leadsByMarketer' => $leadsByMarketer,
            'leadsByStatus' => $leadsByStatus,
            'leadsTrend' => $leadsTrend,
            'leadCategoryDistribution' => $leadCategoryDistribution,
            'conversionRates' => $conversionRates,
            'topMarketers' => $topMarketers,
            'summaryStats' => $summaryStats,
            'leadQualityMetrics' => $leadQualityMetrics,
            'enquiryByDistribution' => $enquiryByDistribution,
            'marketers' => $marketers,
            'filters' => [
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'marketer_id' => $marketerId,
            ],
        ]);
    }

    /**
     * Get lead distribution by marketer.
     */
    private function getLeadsByMarketer($dateFrom, $dateTo)
    {
        $leadsData = Lead::with('marketer')
            ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->whereNotNull('marketer_id')
            ->select('marketer_id', DB::raw('COUNT(*) as count'))
            ->groupBy('marketer_id')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        return [
            'labels' => $leadsData->map(function($item) {
                return $item->marketer ? $item->marketer->name : 'Unknown';
            })->toArray(),
            'values' => $leadsData->pluck('count')->toArray(),
        ];
    }

    /**
     * Get leads by status.
     */
    private function getLeadsByStatus($dateFrom, $dateTo, $marketerId = null)
    {
        $query = Lead::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);

        if ($marketerId) {
            $query->where('marketer_id', $marketerId);
        }

        $statusCounts = $query->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Define all possible statuses
        $statuses = [
            'New' => $statusCounts['New'] ?? 0,
            'Contacted' => $statusCounts['Contacted'] ?? 0,
            'Interested' => $statusCounts['Interested'] ?? 0,
            'Not Interested' => $statusCounts['Not Interested'] ?? 0,
            'Enrolled' => $statusCounts['Enrolled'] ?? 0,
        ];

        return [
            'labels' => array_keys($statuses),
            'values' => array_values($statuses),
        ];
    }

    /**
     * Get leads trend over time.
     */
    private function getLeadsTrend($dateFrom, $dateTo, $marketerId = null)
    {
        $query = Lead::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);

        if ($marketerId) {
            $query->where('marketer_id', $marketerId);
        }

        $trendsData = $query->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        return [
            'labels' => $trendsData->pluck('date')->map(function($date) {
                return Carbon::parse($date)->format('M d');
            })->toArray(),
            'values' => $trendsData->pluck('count')->toArray(),
        ];
    }

    /**
     * Get lead category distribution.
     */
    private function getLeadCategoryDistribution($dateFrom, $dateTo, $marketerId = null)
    {
        $query = Lead::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);

        if ($marketerId) {
            $query->where('marketer_id', $marketerId);
        }

        $categoryData = $query->select('lead_category', DB::raw('COUNT(*) as count'))
            ->groupBy('lead_category')
            ->orderBy('count', 'desc')
            ->get();

        return [
            'labels' => $categoryData->pluck('lead_category')->map(function($category) {
                return $category ?: 'Uncategorized';
            })->toArray(),
            'values' => $categoryData->pluck('count')->toArray(),
        ];
    }

    /**
     * Get conversion rates.
     */
    private function getConversionRates($dateFrom, $dateTo, $marketerId = null)
    {
        $query = Lead::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);

        if ($marketerId) {
            $query->where('marketer_id', $marketerId);
        }

        $totalLeads = $query->count();
        $enrolledLeads = (clone $query)->where('status', 'Enrolled')->count();
        $interestedLeads = (clone $query)->where('status', 'Interested')->count();
        $notInterestedLeads = (clone $query)->where('status', 'Not Interested')->count();

        return [
            'total' => $totalLeads,
            'enrolled' => $enrolledLeads,
            'interested' => $interestedLeads,
            'not_interested' => $notInterestedLeads,
            'enrollment_rate' => $totalLeads > 0 ? round(($enrolledLeads / $totalLeads) * 100, 2) : 0,
            'interest_rate' => $totalLeads > 0 ? round(($interestedLeads / $totalLeads) * 100, 2) : 0,
        ];
    }

    /**
     * Get top performing marketers.
     */
    private function getTopMarketers($dateFrom, $dateTo)
    {
        return Marketer::with(['leads' => function($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);
            }])
            ->withCount([
                'leads as total_leads' => function($query) use ($dateFrom, $dateTo) {
                    $query->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);
                },
                'leads as enrolled_leads' => function($query) use ($dateFrom, $dateTo) {
                    $query->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
                          ->where('status', 'Enrolled');
                },
                'leads as interested_leads' => function($query) use ($dateFrom, $dateTo) {
                    $query->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
                          ->where('status', 'Interested');
                },
                'leads as hot_leads' => function($query) use ($dateFrom, $dateTo) {
                    $query->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
                          ->where('lead_category', 'Hot');
                },
            ])
            ->having('total_leads', '>', 0)
            ->orderBy('total_leads', 'desc')
            ->limit(10)
            ->get()
            ->map(function($marketer) {
                return [
                    'name' => $marketer->name,
                    'email' => $marketer->email,
                    'total_leads' => $marketer->total_leads,
                    'enrolled_leads' => $marketer->enrolled_leads,
                    'interested_leads' => $marketer->interested_leads,
                    'hot_leads' => $marketer->hot_leads,
                    'enrollment_rate' => $marketer->total_leads > 0
                        ? round(($marketer->enrolled_leads / $marketer->total_leads) * 100, 2)
                        : 0,
                ];
            });
    }

    /**
     * Get summary statistics.
     */
    private function getSummaryStats($dateFrom, $dateTo, $marketerId = null)
    {
        // Leads stats
        $leadsQuery = Lead::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);
        if ($marketerId) {
            $leadsQuery->where('marketer_id', $marketerId);
        }

        $totalLeads = $leadsQuery->count();
        $activeMarketers = Lead::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->whereNotNull('marketer_id')
            ->distinct('marketer_id')
            ->count('marketer_id');

        $averageLeadsPerMarketer = $activeMarketers > 0 ? round($totalLeads / $activeMarketers, 2) : 0;

        $hotLeads = (clone $leadsQuery)->where('lead_category', 'Hot')->count();

        return [
            'total_leads' => $totalLeads,
            'active_marketers' => $activeMarketers,
            'average_leads_per_marketer' => $averageLeadsPerMarketer,
            'hot_leads' => $hotLeads,
        ];
    }

    /**
     * Get lead quality metrics.
     */
    private function getLeadQualityMetrics($dateFrom, $dateTo, $marketerId = null)
    {
        $query = Lead::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);

        if ($marketerId) {
            $query->where('marketer_id', $marketerId);
        }

        $totalLeads = $query->count();
        $demoAttended = (clone $query)->where('demo_attended', true)->count();
        $visitedClass = (clone $query)->where('visited_class', true)->count();

        return [
            'demo_attendance_rate' => $totalLeads > 0 ? round(($demoAttended / $totalLeads) * 100, 2) : 0,
            'class_visit_rate' => $totalLeads > 0 ? round(($visitedClass / $totalLeads) * 100, 2) : 0,
            'demo_attended' => $demoAttended,
            'visited_class' => $visitedClass,
        ];
    }

    /**
     * Get enquiry by distribution.
     */
    private function getEnquiryByDistribution($dateFrom, $dateTo, $marketerId = null)
    {
        $query = Lead::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->whereNotNull('enquiry_by');

        if ($marketerId) {
            $query->where('marketer_id', $marketerId);
        }

        $enquiryData = $query->select('enquiry_by', DB::raw('COUNT(*) as count'))
            ->groupBy('enquiry_by')
            ->orderBy('count', 'desc')
            ->get();

        return [
            'labels' => $enquiryData->pluck('enquiry_by')->toArray(),
            'values' => $enquiryData->pluck('count')->toArray(),
        ];
    }
}
