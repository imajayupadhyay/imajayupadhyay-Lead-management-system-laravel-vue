<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Revenue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class RevenueController extends Controller
{
    /**
     * Display a listing of the counselor's revenues.
     */
    public function index(Request $request): Response
    {
        $counselor = auth()->guard('counselor')->user();

        $query = Revenue::with(['marketer', 'lead', 'collectedBy', 'verifiedBy'])
            ->where('counselor_id', $counselor->id);

        // Filter by marketer
        if ($request->has('marketer_id') && !empty($request->marketer_id)) {
            $query->where('marketer_id', $request->marketer_id);
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by payment mode
        if ($request->has('payment_mode') && !empty($request->payment_mode)) {
            $query->where('payment_mode', $request->payment_mode);
        }

        // Filter by date range
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->where('date', '<=', $request->date_to);
        }

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('receipt_number', 'like', "%{$searchTerm}%")
                  ->orWhere('transaction_id', 'like', "%{$searchTerm}%")
                  ->orWhereHas('lead', function ($leadQuery) use ($searchTerm) {
                      $leadQuery->where('student_name', 'like', "%{$searchTerm}%")
                                ->orWhere('mobile_number', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Sort
        $query->orderBy('date', 'desc')->orderBy('created_at', 'desc');

        // Paginate
        $revenues = $query->paginate(20)->withQueryString();

        // Calculate stats based on filters
        $stats = $this->calculateStats($request, $counselor->id);

        // Get all active marketers for filter dropdown
        $marketers = \App\Models\Marketer::active()
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Counselor/Revenues/Index', [
            'revenues' => $revenues,
            'stats' => $stats,
            'marketers' => $marketers,
            'filters' => $request->only([
                'marketer_id',
                'status',
                'payment_mode',
                'date_from',
                'date_to',
                'search'
            ]),
        ]);
    }

    /**
     * Calculate revenue statistics for the counselor.
     */
    private function calculateStats(Request $request, int $counselorId)
    {
        $query = Revenue::where('counselor_id', $counselorId);

        // Apply same filters as main query
        if ($request->has('marketer_id') && !empty($request->marketer_id)) {
            $query->where('marketer_id', $request->marketer_id);
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('payment_mode') && !empty($request->payment_mode)) {
            $query->where('payment_mode', $request->payment_mode);
        }

        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->where('date', '<=', $request->date_to);
        }

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('receipt_number', 'like', "%{$searchTerm}%")
                  ->orWhere('transaction_id', 'like', "%{$searchTerm}%")
                  ->orWhereHas('lead', function ($leadQuery) use ($searchTerm) {
                      $leadQuery->where('student_name', 'like', "%{$searchTerm}%")
                                ->orWhere('mobile_number', 'like', "%{$searchTerm}%");
                  });
            });
        }

        return [
            'total_revenue' => (clone $query)->confirmed()->sum('amount'),
            'total_discount' => (clone $query)->confirmed()->sum('discount_applied'),
            'net_revenue' => (clone $query)->confirmed()->sum(DB::raw('amount - discount_applied')),
            'total_transactions' => (clone $query)->confirmed()->count(),
            'pending_count' => (clone $query)->pending()->count(),
            'pending_amount' => (clone $query)->pending()->sum('amount'),
            'this_month_revenue' => Revenue::confirmed()
                ->where('counselor_id', $counselorId)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->sum('amount'),
        ];
    }

    /**
     * Export counselor's revenues to CSV.
     */
    public function export(Request $request)
    {
        $counselor = auth()->guard('counselor')->user();

        $query = Revenue::with(['marketer', 'lead'])
            ->where('counselor_id', $counselor->id);

        // Apply filters (same as index)
        if ($request->has('marketer_id') && !empty($request->marketer_id)) {
            $query->where('marketer_id', $request->marketer_id);
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('payment_mode') && !empty($request->payment_mode)) {
            $query->where('payment_mode', $request->payment_mode);
        }

        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->where('date', '<=', $request->date_to);
        }

        $revenues = $query->orderBy('date', 'desc')->get();

        $filename = 'my-revenues-' . now()->format('Y-m-d') . '.csv';

        return response()->stream(function () use ($revenues) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, [
                'Receipt Number',
                'Date',
                'Marketer',
                'Lead Name',
                'Payment Type',
                'Amount',
                'Discount',
                'Net Amount',
                'Payment Mode',
                'Transaction ID',
                'Status',
            ]);

            // Data rows
            foreach ($revenues as $revenue) {
                fputcsv($file, [
                    $revenue->receipt_number,
                    $revenue->date->format('Y-m-d'),
                    $revenue->marketer->name ?? 'N/A',
                    $revenue->lead->student_name ?? 'N/A',
                    $revenue->payment_type,
                    $revenue->amount,
                    $revenue->discount_applied,
                    $revenue->net_amount,
                    $revenue->payment_mode,
                    $revenue->transaction_id ?? '',
                    $revenue->status,
                ]);
            }

            fclose($file);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
