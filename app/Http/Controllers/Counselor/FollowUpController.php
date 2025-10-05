<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\FollowUp;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class FollowUpController extends Controller
{
    /**
     * Display a listing of follow-ups.
     */
    public function index(Request $request): Response
    {
        $counselor = auth()->guard('counselor')->user();

        $query = FollowUp::with(['lead', 'counselor'])
            ->forCounselor($counselor->id);

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'today':
                    $query->today();
                    break;
                case 'overdue':
                    $query->overdue();
                    break;
                case 'upcoming':
                    $query->upcoming();
                    break;
                case 'completed':
                    $query->completed();
                    break;
            }
        }

        // Get follow-ups with pagination
        $followUps = $query->orderBy('follow_up_date', 'asc')
            ->orderBy('follow_up_time', 'asc')
            ->paginate(20)
            ->withQueryString();

        // Get statistics
        $stats = [
            'total_follow_ups' => FollowUp::forCounselor($counselor->id)->count(),
            'pending' => FollowUp::forCounselor($counselor->id)->pending()->count(),
            'completed' => FollowUp::forCounselor($counselor->id)->completed()->count(),
            'today' => FollowUp::forCounselor($counselor->id)->today()->pending()->count(),
            'overdue' => FollowUp::forCounselor($counselor->id)->overdue()->count(),
            'upcoming' => FollowUp::forCounselor($counselor->id)->upcoming()->count(),
        ];

        return Inertia::render('Counselor/FollowUps/Index', [
            'followUps' => $followUps,
            'stats' => $stats,
            'filters' => $request->only(['status', 'filter']),
        ]);
    }

    /**
     * Store a newly created follow-up.
     */
    public function store(Request $request): RedirectResponse
    {
        $counselor = auth()->guard('counselor')->user();

        $validator = Validator::make($request->all(), [
            'lead_id' => ['required', 'exists:leads,id'],
            'follow_up_date' => ['required', 'date'],
            'follow_up_time' => ['nullable', 'date_format:H:i'],
            'contact_method' => ['required', 'in:Phone,Email,WhatsApp,In-Person,Other'],
            'notes' => ['required', 'string'],
            'priority' => ['required', 'in:High,Medium,Low'],
            'next_follow_up_date' => ['nullable', 'date', 'after:follow_up_date'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Verify the lead belongs to this counselor
        $lead = Lead::findOrFail($request->lead_id);
        if ($lead->counselor_id !== $counselor->id) {
            abort(403, 'Unauthorized access to this lead.');
        }

        $followUp = FollowUp::create([
            'lead_id' => $request->lead_id,
            'counselor_id' => $counselor->id,
            'follow_up_date' => $request->follow_up_date,
            'follow_up_time' => $request->follow_up_time,
            'status' => 'Pending',
            'contact_method' => $request->contact_method,
            'notes' => $request->notes,
            'priority' => $request->priority,
            'next_follow_up_date' => $request->next_follow_up_date,
        ]);

        // Update lead's next follow-up date
        $lead->update([
            'next_follow_up_date' => $request->follow_up_date,
        ]);

        return back()->with('success', 'Follow-up scheduled successfully!');
    }

    /**
     * Update the specified follow-up (mark as completed).
     */
    public function update(Request $request, FollowUp $followUp): RedirectResponse
    {
        $counselor = auth()->guard('counselor')->user();

        // Ensure the follow-up belongs to this counselor
        if ($followUp->counselor_id !== $counselor->id) {
            abort(403, 'Unauthorized access to this follow-up.');
        }

        $validator = Validator::make($request->all(), [
            'status' => ['required', 'in:Completed,Missed,Rescheduled'],
            'outcome' => ['nullable', 'in:Interested,Not Interested,Call Back Later,No Response,Enrolled,Other'],
            'notes' => ['nullable', 'string'],
            'next_follow_up_date' => ['nullable', 'date'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $updateData = [
            'status' => $request->status,
            'outcome' => $request->outcome,
        ];

        if ($request->filled('notes')) {
            $updateData['notes'] = $followUp->notes . "\n\n[Completed] " . $request->notes;
        }

        if ($request->status === 'Completed') {
            $updateData['completed_at'] = now();
        }

        if ($request->filled('next_follow_up_date')) {
            $updateData['next_follow_up_date'] = $request->next_follow_up_date;
        }

        $followUp->update($updateData);

        // Update lead information
        $lead = $followUp->lead;
        $lead->update([
            'last_follow_up_date' => now(),
            'next_follow_up_date' => $request->next_follow_up_date,
            'follow_up_count' => $lead->follow_up_count + 1,
        ]);

        // Update lead category
        $lead->updateLeadCategory();

        // If status is changed to Enrolled, update lead status
        if ($request->outcome === 'Enrolled') {
            $lead->update(['status' => 'Enrolled']);
        }

        return back()->with('success', 'Follow-up updated successfully!');
    }

    /**
     * Remove the specified follow-up.
     */
    public function destroy(FollowUp $followUp): RedirectResponse
    {
        $counselor = auth()->guard('counselor')->user();

        // Ensure the follow-up belongs to this counselor
        if ($followUp->counselor_id !== $counselor->id) {
            abort(403, 'Unauthorized access to this follow-up.');
        }

        $followUp->delete();

        return back()->with('success', 'Follow-up deleted successfully!');
    }

    /**
     * Get today's follow-ups.
     */
    public function today(): Response
    {
        $counselor = auth()->guard('counselor')->user();

        $followUps = FollowUp::with(['lead', 'counselor'])
            ->forCounselor($counselor->id)
            ->today()
            ->pending()
            ->orderBy('follow_up_time', 'asc')
            ->get();

        return Inertia::render('Counselor/FollowUps/Today', [
            'followUps' => $followUps,
        ]);
    }

    /**
     * Get overdue follow-ups.
     */
    public function overdue(): Response
    {
        $counselor = auth()->guard('counselor')->user();

        $followUps = FollowUp::with(['lead', 'counselor'])
            ->forCounselor($counselor->id)
            ->overdue()
            ->orderBy('follow_up_date', 'asc')
            ->get();

        return Inertia::render('Counselor/FollowUps/Overdue', [
            'followUps' => $followUps,
        ]);
    }
}
