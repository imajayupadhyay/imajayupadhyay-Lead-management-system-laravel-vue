<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\FollowUp;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LeadController extends Controller
{
    /**
     * Display a listing of leads assigned to the counselor.
     */
    public function index(Request $request): Response
    {
        $counselor = auth()->guard('counselor')->user();

        $query = Lead::with(['counselor', 'marketer', 'faculty', 'latestFollowUp', 'nextFollowUp'])
            ->forCounselor($counselor->id);

        // Filter by category (Hot/Warm/Cold)
        if ($request->has('category') && in_array($request->category, ['Hot', 'Warm', 'Cold'])) {
            $query->where('lead_category', $request->category);
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Search by name, email, or mobile
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('student_name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%")
                  ->orWhere('mobile_number', 'like', "%{$searchTerm}%");
            });
        }

        // Get leads with pagination
        $leads = $query->orderBy('next_follow_up_date', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Update lead categories before displaying
        foreach ($leads as $lead) {
            $lead->updateLeadCategory();
        }

        // Get statistics
        $stats = [
            'total_leads' => Lead::forCounselor($counselor->id)->count(),
            'hot_leads' => Lead::forCounselor($counselor->id)->hot()->count(),
            'warm_leads' => Lead::forCounselor($counselor->id)->warm()->count(),
            'cold_leads' => Lead::forCounselor($counselor->id)->cold()->count(),
            'new_leads' => Lead::forCounselor($counselor->id)->where('status', 'New')->count(),
            'interested_leads' => Lead::forCounselor($counselor->id)->where('status', 'Interested')->count(),
            'enrolled_leads' => Lead::forCounselor($counselor->id)->where('status', 'Enrolled')->count(),
        ];

        // Get today's follow-ups count
        $todayFollowUps = FollowUp::forCounselor($counselor->id)
            ->today()
            ->pending()
            ->count();

        // Get overdue follow-ups count
        $overdueFollowUps = FollowUp::forCounselor($counselor->id)
            ->overdue()
            ->count();

        return Inertia::render('Counselor/Leads/Index', [
            'leads' => $leads,
            'stats' => $stats,
            'todayFollowUps' => $todayFollowUps,
            'overdueFollowUps' => $overdueFollowUps,
            'filters' => $request->only(['category', 'status', 'search']),
        ]);
    }

    /**
     * Display the specified lead.
     */
    public function show(Lead $lead): Response
    {
        $counselor = auth()->guard('counselor')->user();

        // Ensure the lead belongs to this counselor
        if ($lead->counselor_id !== $counselor->id) {
            abort(403, 'Unauthorized access to this lead.');
        }

        // Load relationships
        $lead->load(['counselor', 'marketer', 'faculty', 'followUps' => function ($query) {
            $query->orderBy('follow_up_date', 'desc');
        }]);

        // Update lead category
        $lead->updateLeadCategory();

        return Inertia::render('Counselor/Leads/Show', [
            'lead' => $lead,
        ]);
    }

    /**
     * Update the lead status.
     */
    public function updateStatus(Request $request, Lead $lead)
    {
        $counselor = auth()->guard('counselor')->user();

        // Ensure the lead belongs to this counselor
        if ($lead->counselor_id !== $counselor->id) {
            abort(403, 'Unauthorized access to this lead.');
        }

        $request->validate([
            'status' => ['required', 'in:New,Contacted,Interested,Not Interested,Enrolled'],
        ]);

        $lead->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Lead status updated successfully!');
    }
}
