<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Counselor;
use App\Models\Marketer;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class LeadController extends Controller
{
    /**
     * Display a listing of leads.
     */
    public function index(Request $request): Response
    {
        $query = Lead::with(['counselor', 'marketer', 'faculty']);

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by qualification
        if ($request->has('qualification') && !empty($request->qualification)) {
            $query->where('qualification', $request->qualification);
        }

        // Filter by state
        if ($request->has('state') && !empty($request->state)) {
            $query->where('state', $request->state);
        }

        // Filter by counselor
        if ($request->has('counselor_id') && !empty($request->counselor_id)) {
            $query->where('counselor_id', $request->counselor_id);
        }

        // Filter by marketer
        if ($request->has('marketer_id') && !empty($request->marketer_id)) {
            $query->where('marketer_id', $request->marketer_id);
        }

        // Filter by date range
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('date', '<=', $request->date_to);
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
        $leads = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Get statistics
        $stats = [
            'total_leads' => Lead::count(),
            'new_leads' => Lead::where('status', 'New')->count(),
            'contacted_leads' => Lead::where('status', 'Contacted')->count(),
            'interested_leads' => Lead::where('status', 'Interested')->count(),
            'enrolled_leads' => Lead::where('status', 'Enrolled')->count(),
        ];

        // Get filter options
        $filterOptions = [
            'counselors' => Counselor::active()->select('id', 'name')->get(),
            'marketers' => Marketer::active()->select('id', 'name')->get(),
            'faculty' => Faculty::active()->select('id', 'name', 'subject')->get(),
            'statuses' => ['New', 'Contacted', 'Interested', 'Not Interested', 'Enrolled'],
            'qualifications' => ['Masters', 'Graduation', '12th'],
            'states' => Lead::distinct()->pluck('state')->filter()->sort()->values(),
        ];

        return Inertia::render('Admin/Leads/Index', [
            'leads' => $leads,
            'stats' => $stats,
            'filterOptions' => $filterOptions,
            'filters' => $request->only(['status', 'qualification', 'state', 'counselor_id', 'marketer_id', 'date_from', 'date_to', 'search']),
        ]);
    }

    /**
     * Store a newly created lead in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'date' => ['required', 'date'],
            'student_name' => ['required', 'string', 'max:255'],
            'gender' => ['nullable', 'in:Male,Female,Trans'],
            'age' => ['nullable', 'integer', 'min:1', 'max:100'],
            'mobile_number' => ['required', 'string', 'max:15'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['required', 'string'],
            'pin_code' => ['required', 'string', 'max:6'],
            'state' => ['required', 'string', 'max:255'],
            'qualification' => ['required', 'in:Masters,Graduation,12th'],
            'college' => ['nullable', 'string', 'max:255'],
            'visited_with' => ['required', 'in:Self,Parent/Friend'],
            'parent_friend_specify' => ['nullable', 'string', 'max:255'],
            'parent_occupation' => ['nullable', 'string', 'max:255'],
            'interested_in' => ['nullable', 'array'],
            'course_language' => ['nullable', 'string', 'max:255'],
            'course_type_details' => ['nullable', 'string', 'max:255'],
            'gs_module' => ['nullable', 'string', 'max:255'],
            'optional_subject' => ['nullable', 'string', 'max:255'],
            'other_query' => ['nullable', 'string'],
            'target_year' => ['nullable', 'string', 'max:4'],
            'enquiry_by' => ['nullable', 'string', 'max:255'],
            'marketer_id' => ['nullable', 'exists:marketers,id'],
            'counselor_id' => ['nullable', 'exists:counselors,id'],
            'faculty_id' => ['nullable', 'exists:faculty,id'],
            'visited_class' => ['boolean'],
            'demo_attended' => ['boolean'],
            'status' => ['required', 'in:New,Contacted,Interested,Not Interested,Enrolled'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $lead = Lead::create([
            'date' => $request->date,
            'student_name' => $request->student_name,
            'gender' => $request->gender,
            'age' => $request->age,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'address' => $request->address,
            'pin_code' => $request->pin_code,
            'state' => $request->state,
            'qualification' => $request->qualification,
            'college' => $request->college,
            'visited_with' => $request->visited_with,
            'parent_friend_specify' => $request->parent_friend_specify,
            'parent_occupation' => $request->parent_occupation,
            'interested_in' => $request->interested_in,
            'course_language' => $request->course_language,
            'course_type_details' => $request->course_type_details,
            'gs_module' => $request->gs_module,
            'optional_subject' => $request->optional_subject,
            'other_query' => $request->other_query,
            'target_year' => $request->target_year,
            'enquiry_by' => $request->enquiry_by,
            'marketer_id' => $request->marketer_id,
            'counselor_id' => $request->counselor_id,
            'faculty_id' => $request->faculty_id,
            'visited_class' => $request->visited_class ?? false,
            'demo_attended' => $request->demo_attended ?? false,
            'status' => $request->status ?? 'New',
        ]);

        return redirect()->route('admin.leads.index')
            ->with('success', "Lead for '{$lead->student_name}' created successfully!");
    }

    /**
     * Display the specified lead.
     */
    public function show(Lead $lead): Response
    {
        $lead->load(['counselor', 'marketer', 'faculty']);
        
        return Inertia::render('Admin/Leads/Show', [
            'lead' => $lead,
        ]);
    }

    /**
     * Update the specified lead in storage.
     */
    public function update(Request $request, Lead $lead): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'date' => ['required', 'date'],
            'student_name' => ['required', 'string', 'max:255'],
            'gender' => ['nullable', 'in:Male,Female,Trans'],
            'age' => ['nullable', 'integer', 'min:1', 'max:100'],
            'mobile_number' => ['required', 'string', 'max:15'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['required', 'string'],
            'pin_code' => ['required', 'string', 'max:6'],
            'state' => ['required', 'string', 'max:255'],
            'qualification' => ['required', 'in:Masters,Graduation,12th'],
            'college' => ['nullable', 'string', 'max:255'],
            'visited_with' => ['required', 'in:Self,Parent/Friend'],
            'parent_friend_specify' => ['nullable', 'string', 'max:255'],
            'parent_occupation' => ['nullable', 'string', 'max:255'],
            'interested_in' => ['nullable', 'array'],
            'course_language' => ['nullable', 'string', 'max:255'],
            'course_type_details' => ['nullable', 'string', 'max:255'],
            'gs_module' => ['nullable', 'string', 'max:255'],
            'optional_subject' => ['nullable', 'string', 'max:255'],
            'other_query' => ['nullable', 'string'],
            'target_year' => ['nullable', 'string', 'max:4'],
            'enquiry_by' => ['nullable', 'string', 'max:255'],
            'marketer_id' => ['nullable', 'exists:marketers,id'],
            'counselor_id' => ['nullable', 'exists:counselors,id'],
            'faculty_id' => ['nullable', 'exists:faculty,id'],
            'visited_class' => ['boolean'],
            'demo_attended' => ['boolean'],
            'status' => ['required', 'in:New,Contacted,Interested,Not Interested,Enrolled'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $lead->update([
            'date' => $request->date,
            'student_name' => $request->student_name,
            'gender' => $request->gender,
            'age' => $request->age,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'address' => $request->address,
            'pin_code' => $request->pin_code,
            'state' => $request->state,
            'qualification' => $request->qualification,
            'college' => $request->college,
            'visited_with' => $request->visited_with,
            'parent_friend_specify' => $request->parent_friend_specify,
            'parent_occupation' => $request->parent_occupation,
            'interested_in' => $request->interested_in,
            'course_language' => $request->course_language,
            'course_type_details' => $request->course_type_details,
            'gs_module' => $request->gs_module,
            'optional_subject' => $request->optional_subject,
            'other_query' => $request->other_query,
            'target_year' => $request->target_year,
            'enquiry_by' => $request->enquiry_by,
            'marketer_id' => $request->marketer_id,
            'counselor_id' => $request->counselor_id,
            'faculty_id' => $request->faculty_id,
            'visited_class' => $request->visited_class ?? false,
            'demo_attended' => $request->demo_attended ?? false,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.leads.index')
            ->with('success', "Lead for '{$lead->student_name}' updated successfully!");
    }

    /**
     * Remove the specified lead from storage.
     */
    public function destroy(Lead $lead): RedirectResponse
    {
        $studentName = $lead->student_name;
        $lead->delete();

        return redirect()->route('admin.leads.index')
            ->with('success', "Lead for '{$studentName}' deleted successfully!");
    }

    /**
     * Handle bulk actions on leads.
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'action' => ['required', 'string', 'in:update_status,assign_counselor,assign_marketer,delete'],
            'lead_ids' => ['required', 'array', 'min:1'],
            'lead_ids.*' => ['integer', 'exists:leads,id'],
            'status' => ['required_if:action,update_status', 'in:New,Contacted,Interested,Not Interested,Enrolled'],
            'counselor_id' => ['required_if:action,assign_counselor', 'exists:counselors,id'],
            'marketer_id' => ['required_if:action,assign_marketer', 'exists:marketers,id'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $leadIds = $request->lead_ids;
        $action = $request->action;

        switch ($action) {
            case 'update_status':
                Lead::whereIn('id', $leadIds)->update(['status' => $request->status]);
                $message = "Selected leads status updated to '{$request->status}' successfully!";
                break;

            case 'assign_counselor':
                $counselor = Counselor::find($request->counselor_id);
                Lead::whereIn('id', $leadIds)->update(['counselor_id' => $request->counselor_id]);
                $message = "Selected leads assigned to counselor '{$counselor->name}' successfully!";
                break;

            case 'assign_marketer':
                $marketer = Marketer::find($request->marketer_id);
                Lead::whereIn('id', $leadIds)->update(['marketer_id' => $request->marketer_id]);
                $message = "Selected leads assigned to marketer '{$marketer->name}' successfully!";
                break;

            case 'delete':
                Lead::whereIn('id', $leadIds)->delete();
                $message = 'Selected leads have been deleted successfully!';
                break;
        }

        return back()->with('success', $message);
    }
}