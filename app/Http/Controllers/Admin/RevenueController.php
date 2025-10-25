<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Revenue;
use App\Models\Counselor;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class RevenueController extends Controller
{
    /**
     * Display a listing of revenues.
     */
    public function index(Request $request): Response
    {
        $query = Revenue::with(['counselor', 'lead', 'collectedBy', 'verifiedBy']);

        // Filter by counselor
        if ($request->has('counselor_id') && !empty($request->counselor_id)) {
            $query->where('counselor_id', $request->counselor_id);
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by payment type
        if ($request->has('payment_type') && !empty($request->payment_type)) {
            $query->where('payment_type', $request->payment_type);
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

        // Search by receipt number or transaction ID
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

        // Get revenues with pagination
        $revenues = $query->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        // Calculate statistics
        $stats = $this->calculateStats($request);

        // Get counselors for filter dropdown
        $counselors = Counselor::active()
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Admin/Revenues/Index', [
            'revenues' => $revenues,
            'stats' => $stats,
            'counselors' => $counselors,
            'filters' => $request->only([
                'counselor_id',
                'status',
                'payment_type',
                'payment_mode',
                'date_from',
                'date_to',
                'search'
            ]),
        ]);
    }

    /**
     * Show the form for creating a new revenue.
     */
    public function create(): Response
    {
        $counselors = Counselor::active()
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'phone']);

        $leads = Lead::with('counselor')
            ->orderBy('student_name')
            ->get(['id', 'student_name', 'mobile_number', 'counselor_id']);

        $receiptNumber = Revenue::generateReceiptNumber();

        return Inertia::render('Admin/Revenues/Create', [
            'counselors' => $counselors,
            'leads' => $leads,
            'receiptNumber' => $receiptNumber,
        ]);
    }

    /**
     * Store a newly created revenue in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'counselor_id' => ['required', 'integer', 'exists:counselors,id'],
            'lead_id' => ['nullable', 'integer', 'exists:leads,id'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_mode' => ['required', 'string', 'in:Cash,UPI,Card,Net Banking,Cheque,Other'],
            'transaction_id' => ['nullable', 'string', 'max:255'],
            'receipt_number' => ['nullable', 'string', 'max:255', 'unique:revenues'],
            'course_type' => ['nullable', 'string', 'max:255'],
            'payment_type' => ['required', 'string', 'in:Registration Fee,Course Fee,Installment,Material Fee,Exam Fee,Other'],
            'installment_number' => ['nullable', 'integer', 'min:1'],
            'total_installments' => ['nullable', 'integer', 'min:1'],
            'discount_applied' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:Pending,Confirmed,Cancelled,Refunded'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Generate receipt number if not provided
        $receiptNumber = $request->receipt_number ?? Revenue::generateReceiptNumber();

        $revenue = Revenue::create([
            'counselor_id' => $request->counselor_id,
            'lead_id' => $request->lead_id,
            'date' => $request->date,
            'amount' => $request->amount,
            'payment_mode' => $request->payment_mode,
            'transaction_id' => $request->transaction_id,
            'receipt_number' => $receiptNumber,
            'course_type' => $request->course_type,
            'payment_type' => $request->payment_type,
            'installment_number' => $request->installment_number,
            'total_installments' => $request->total_installments,
            'discount_applied' => $request->discount_applied ?? 0,
            'notes' => $request->notes,
            'status' => $request->status,
            'collected_by' => Auth::id(),
        ]);

        return redirect()->route('admin.revenues.index')
            ->with('success', "Revenue record created successfully! Receipt: {$revenue->receipt_number}");
    }

    /**
     * Display the specified revenue.
     */
    public function show(Revenue $revenue): Response
    {
        $revenue->load(['counselor', 'lead', 'collectedBy', 'verifiedBy']);

        return Inertia::render('Admin/Revenues/Show', [
            'revenue' => $revenue,
        ]);
    }

    /**
     * Show the form for editing the specified revenue.
     */
    public function edit(Revenue $revenue): Response
    {
        if (!$revenue->isEditable()) {
            return back()->with('error', 'This revenue record cannot be edited.');
        }

        $revenue->load(['counselor', 'lead']);

        $counselors = Counselor::active()
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'phone']);

        $leads = Lead::with('counselor')
            ->orderBy('student_name')
            ->get(['id', 'student_name', 'mobile_number', 'counselor_id']);

        return Inertia::render('Admin/Revenues/Edit', [
            'revenue' => $revenue,
            'counselors' => $counselors,
            'leads' => $leads,
        ]);
    }

    /**
     * Update the specified revenue in storage.
     */
    public function update(Request $request, Revenue $revenue): RedirectResponse
    {
        if (!$revenue->isEditable()) {
            return back()->with('error', 'This revenue record cannot be edited.');
        }

        $validator = Validator::make($request->all(), [
            'counselor_id' => ['required', 'integer', 'exists:counselors,id'],
            'lead_id' => ['nullable', 'integer', 'exists:leads,id'],
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_mode' => ['required', 'string', 'in:Cash,UPI,Card,Net Banking,Cheque,Other'],
            'transaction_id' => ['nullable', 'string', 'max:255'],
            'receipt_number' => ['nullable', 'string', 'max:255', 'unique:revenues,receipt_number,' . $revenue->id],
            'course_type' => ['nullable', 'string', 'max:255'],
            'payment_type' => ['required', 'string', 'in:Registration Fee,Course Fee,Installment,Material Fee,Exam Fee,Other'],
            'installment_number' => ['nullable', 'integer', 'min:1'],
            'total_installments' => ['nullable', 'integer', 'min:1'],
            'discount_applied' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:Pending,Confirmed,Cancelled,Refunded'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $revenue->update([
            'counselor_id' => $request->counselor_id,
            'lead_id' => $request->lead_id,
            'date' => $request->date,
            'amount' => $request->amount,
            'payment_mode' => $request->payment_mode,
            'transaction_id' => $request->transaction_id,
            'receipt_number' => $request->receipt_number,
            'course_type' => $request->course_type,
            'payment_type' => $request->payment_type,
            'installment_number' => $request->installment_number,
            'total_installments' => $request->total_installments,
            'discount_applied' => $request->discount_applied ?? 0,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.revenues.index')
            ->with('success', "Revenue record updated successfully!");
    }

    /**
     * Remove the specified revenue from storage.
     */
    public function destroy(Revenue $revenue): RedirectResponse
    {
        $receiptNumber = $revenue->receipt_number;
        $revenue->delete();

        return redirect()->route('admin.revenues.index')
            ->with('success', "Revenue record '{$receiptNumber}' deleted successfully!");
    }

    /**
     * Verify a revenue record.
     */
    public function verify(Revenue $revenue): RedirectResponse
    {
        if ($revenue->status !== 'Confirmed') {
            return back()->with('error', 'Only confirmed revenue records can be verified.');
        }

        if ($revenue->verified_at) {
            return back()->with('error', 'This revenue record is already verified.');
        }

        $revenue->update([
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Revenue record verified successfully!');
    }

    /**
     * Get revenue report by counselor.
     */
    public function reportByCounselor(Request $request): Response
    {
        $dateFrom = $request->input('date_from', now()->startOfMonth()->toDateString());
        $dateTo = $request->input('date_to', now()->endOfMonth()->toDateString());

        $counselorRevenues = Revenue::confirmed()
            ->with('counselor')
            ->whereBetween('date', [$dateFrom, $dateTo])
            ->select('counselor_id', DB::raw('COUNT(*) as total_transactions'),
                     DB::raw('SUM(amount) as total_amount'),
                     DB::raw('SUM(discount_applied) as total_discount'),
                     DB::raw('SUM(amount - discount_applied) as net_amount'))
            ->groupBy('counselor_id')
            ->get();

        // Get counselor details
        $counselorIds = $counselorRevenues->pluck('counselor_id');
        $counselors = Counselor::whereIn('id', $counselorIds)->get()->keyBy('id');

        $report = $counselorRevenues->map(function ($item) use ($counselors) {
            return [
                'counselor' => $counselors[$item->counselor_id] ?? null,
                'total_transactions' => $item->total_transactions,
                'total_amount' => $item->total_amount,
                'total_discount' => $item->total_discount,
                'net_amount' => $item->net_amount,
            ];
        });

        return Inertia::render('Admin/Revenues/CounselorReport', [
            'report' => $report,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }

    /**
     * Calculate revenue statistics.
     */
    private function calculateStats(Request $request)
    {
        $query = Revenue::query();

        // Apply same filters as main query
        if ($request->has('counselor_id') && !empty($request->counselor_id)) {
            $query->where('counselor_id', $request->counselor_id);
        }
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->where('date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->where('date', '<=', $request->date_to);
        }

        return [
            'total_revenue' => (clone $query)->confirmed()->sum('amount'),
            'total_discount' => (clone $query)->confirmed()->sum('discount_applied'),
            'net_revenue' => (clone $query)->confirmed()->sum(DB::raw('amount - discount_applied')),
            'total_transactions' => (clone $query)->confirmed()->count(),
            'pending_count' => (clone $query)->pending()->count(),
            'pending_amount' => (clone $query)->pending()->sum('amount'),
            'today_revenue' => Revenue::confirmed()->whereDate('date', today())->sum('amount'),
            'this_month_revenue' => Revenue::confirmed()
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->sum('amount'),
        ];
    }

    /**
     * Export revenues to CSV.
     */
    public function export(Request $request)
    {
        $query = Revenue::with(['counselor', 'lead']);

        // Apply filters
        if ($request->has('counselor_id') && !empty($request->counselor_id)) {
            $query->where('counselor_id', $request->counselor_id);
        }
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->where('date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->where('date', '<=', $request->date_to);
        }

        $revenues = $query->orderBy('date', 'desc')->get();

        $filename = 'revenues_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($revenues) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, [
                'Receipt Number',
                'Date',
                'Counselor',
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
                    $revenue->counselor->name ?? 'N/A',
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
        };

        return response()->stream($callback, 200, $headers);
    }
}
