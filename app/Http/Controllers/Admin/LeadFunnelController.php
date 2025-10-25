<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Revenue;
use App\Models\Counselor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Carbon\Carbon;

class LeadFunnelController extends Controller
{
    /**
     * Display the lead funnel analytics dashboard.
     */
    public function index(Request $request): Response
    {
        // Get date range filters
        $dateFrom = $request->input('date_from', now()->startOfMonth()->toDateString());
        $dateTo = $request->input('date_to', now()->endOfMonth()->toDateString());
        $counselorId = $request->input('counselor_id');

        // Lead Funnel Data (by status)
        $leadFunnelData = $this->getLeadFunnelData($dateFrom, $dateTo, $counselorId);

        // Revenue by Counselor
        $revenueByCounselor = $this->getRevenueByCounselor($dateFrom, $dateTo);

        // Leads Trend (Daily/Weekly)
        $leadsTrend = $this->getLeadsTrend($dateFrom, $dateTo, $counselorId);

        // Revenue Trend
        $revenueTrend = $this->getRevenueTrend($dateFrom, $dateTo, $counselorId);

        // Conversion Rates
        $conversionRates = $this->getConversionRates($dateFrom, $dateTo, $counselorId);

        // Lead Source Distribution
        $leadSourceDistribution = $this->getLeadSourceDistribution($dateFrom, $dateTo, $counselorId);

        // Top Performing Counselors
        $topCounselors = $this->getTopCounselors($dateFrom, $dateTo);

        // Summary Statistics
        $summaryStats = $this->getSummaryStats($dateFrom, $dateTo, $counselorId);

        // Payment Mode Distribution
        $paymentModeDistribution = $this->getPaymentModeDistribution($dateFrom, $dateTo, $counselorId);

        // Get counselors for filter
        $counselors = Counselor::active()
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Admin/LeadFunnel/Index', [
            'leadFunnelData' => $leadFunnelData,
            'revenueByCounselor' => $revenueByCounselor,
            'leadsTrend' => $leadsTrend,
            'revenueTrend' => $revenueTrend,
            'conversionRates' => $conversionRates,
            'leadSourceDistribution' => $leadSourceDistribution,
            'topCounselors' => $topCounselors,
            'summaryStats' => $summaryStats,
            'paymentModeDistribution' => $paymentModeDistribution,
            'counselors' => $counselors,
            'filters' => [
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'counselor_id' => $counselorId,
            ],
        ]);
    }

    /**
     * Get lead funnel data by status.
     */
    private function getLeadFunnelData($dateFrom, $dateTo, $counselorId = null)
    {
        $query = Lead::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);

        if ($counselorId) {
            $query->where('counselor_id', $counselorId);
        }

        $statusCounts = $query->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Define funnel stages
        $funnelStages = [
            'New' => $statusCounts['New'] ?? 0,
            'Contacted' => $statusCounts['Contacted'] ?? 0,
            'Qualified' => $statusCounts['Qualified'] ?? 0,
            'Proposal Sent' => $statusCounts['Proposal Sent'] ?? 0,
            'Negotiation' => $statusCounts['Negotiation'] ?? 0,
            'Converted' => $statusCounts['Converted'] ?? 0,
            'Lost' => $statusCounts['Lost'] ?? 0,
        ];

        return [
            'labels' => array_keys($funnelStages),
            'values' => array_values($funnelStages),
        ];
    }

    /**
     * Get revenue by counselor.
     */
    private function getRevenueByCounselor($dateFrom, $dateTo)
    {
        $revenueData = Revenue::with('counselor')
            ->whereBetween('date', [$dateFrom, $dateTo])
            ->where('status', 'Confirmed')
            ->select('counselor_id', DB::raw('SUM(amount - discount_applied) as total_revenue'))
            ->groupBy('counselor_id')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->get();

        return [
            'labels' => $revenueData->pluck('counselor.name')->toArray(),
            'values' => $revenueData->pluck('total_revenue')->toArray(),
        ];
    }

    /**
     * Get leads trend over time.
     */
    private function getLeadsTrend($dateFrom, $dateTo, $counselorId = null)
    {
        $query = Lead::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);

        if ($counselorId) {
            $query->where('counselor_id', $counselorId);
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
     * Get revenue trend over time.
     */
    private function getRevenueTrend($dateFrom, $dateTo, $counselorId = null)
    {
        $query = Revenue::whereBetween('date', [$dateFrom, $dateTo])
            ->where('status', 'Confirmed');

        if ($counselorId) {
            $query->where('counselor_id', $counselorId);
        }

        $trendsData = $query->select(
                'date',
                DB::raw('SUM(amount - discount_applied) as total_revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'labels' => $trendsData->pluck('date')->map(function($date) {
                return Carbon::parse($date)->format('M d');
            })->toArray(),
            'values' => $trendsData->pluck('total_revenue')->toArray(),
        ];
    }

    /**
     * Get conversion rates.
     */
    private function getConversionRates($dateFrom, $dateTo, $counselorId = null)
    {
        $query = Lead::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);

        if ($counselorId) {
            $query->where('counselor_id', $counselorId);
        }

        $totalLeads = $query->count();
        $convertedLeads = (clone $query)->where('status', 'Converted')->count();
        $lostLeads = (clone $query)->where('status', 'Lost')->count();
        $activeLeads = $totalLeads - $convertedLeads - $lostLeads;

        return [
            'total' => $totalLeads,
            'converted' => $convertedLeads,
            'lost' => $lostLeads,
            'active' => $activeLeads,
            'conversion_rate' => $totalLeads > 0 ? round(($convertedLeads / $totalLeads) * 100, 2) : 0,
            'loss_rate' => $totalLeads > 0 ? round(($lostLeads / $totalLeads) * 100, 2) : 0,
        ];
    }

    /**
     * Get lead category distribution.
     */
    private function getLeadSourceDistribution($dateFrom, $dateTo, $counselorId = null)
    {
        $query = Lead::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);

        if ($counselorId) {
            $query->where('counselor_id', $counselorId);
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
     * Get top performing counselors.
     */
    private function getTopCounselors($dateFrom, $dateTo)
    {
        return Counselor::with(['leads' => function($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);
            }])
            ->withCount([
                'leads as total_leads' => function($query) use ($dateFrom, $dateTo) {
                    $query->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);
                },
                'leads as converted_leads' => function($query) use ($dateFrom, $dateTo) {
                    $query->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
                          ->where('status', 'Converted');
                },
            ])
            ->withSum([
                'revenues as total_revenue' => function($query) use ($dateFrom, $dateTo) {
                    $query->whereBetween('date', [$dateFrom, $dateTo])
                          ->where('status', 'Confirmed');
                }
            ], DB::raw('amount - discount_applied'))
            ->having('total_leads', '>', 0)
            ->orderBy('total_revenue', 'desc')
            ->limit(5)
            ->get()
            ->map(function($counselor) {
                return [
                    'name' => $counselor->name,
                    'total_leads' => $counselor->total_leads,
                    'converted_leads' => $counselor->converted_leads,
                    'total_revenue' => $counselor->total_revenue ?? 0,
                    'conversion_rate' => $counselor->total_leads > 0
                        ? round(($counselor->converted_leads / $counselor->total_leads) * 100, 2)
                        : 0,
                ];
            });
    }

    /**
     * Get summary statistics.
     */
    private function getSummaryStats($dateFrom, $dateTo, $counselorId = null)
    {
        // Leads stats
        $leadsQuery = Lead::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);
        if ($counselorId) {
            $leadsQuery->where('counselor_id', $counselorId);
        }

        // Revenue stats
        $revenueQuery = Revenue::whereBetween('date', [$dateFrom, $dateTo])
            ->where('status', 'Confirmed');
        if ($counselorId) {
            $revenueQuery->where('counselor_id', $counselorId);
        }

        $totalLeads = $leadsQuery->count();
        $totalRevenue = $revenueQuery->sum(DB::raw('amount - discount_applied'));
        $averageRevenuePerLead = $totalLeads > 0 ? $totalRevenue / $totalLeads : 0;

        return [
            'total_leads' => $totalLeads,
            'total_revenue' => $totalRevenue,
            'average_revenue_per_lead' => round($averageRevenuePerLead, 2),
            'total_transactions' => $revenueQuery->count(),
        ];
    }

    /**
     * Get payment mode distribution.
     */
    private function getPaymentModeDistribution($dateFrom, $dateTo, $counselorId = null)
    {
        $query = Revenue::whereBetween('date', [$dateFrom, $dateTo])
            ->where('status', 'Confirmed');

        if ($counselorId) {
            $query->where('counselor_id', $counselorId);
        }

        $paymentData = $query->select('payment_mode', DB::raw('SUM(amount - discount_applied) as total'))
            ->groupBy('payment_mode')
            ->orderBy('total', 'desc')
            ->get();

        return [
            'labels' => $paymentData->pluck('payment_mode')->toArray(),
            'values' => $paymentData->pluck('total')->toArray(),
        ];
    }
}
