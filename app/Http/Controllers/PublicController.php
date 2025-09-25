<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Counselor;
use App\Models\Faculty;
use App\Models\Marketer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class PublicController extends Controller
{
    /**
     * Show the enquiry form
     */
    public function index()
    {
        return Inertia::render('Public/EnquiryForm', [
            'counselors' => Counselor::active()->get(['id', 'name']),
            'faculty' => Faculty::active()->get(['id', 'name', 'subject']),
            'marketers' => Marketer::active()->get(['id', 'name', 'designation']),
        ]);
    }

    /**
     * Store the enquiry form data
     */
    public function store(Request $request)
    {
        // Debug: Log incoming data
        \Log::info('Form submission data:', $request->all());

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'student_name' => 'required|string|max:255',
            'gender' => 'nullable|in:Male,Female,Trans',
            'age' => 'nullable|integer|min:15|max:50',
            'mobile_number' => 'required|string|max:15',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
            'pin_code' => 'required|string|max:6',
            'state' => 'required|string|max:255',
            'qualification' => 'required|in:Masters,Graduation,12th',
            'college' => 'nullable|string|max:255',
            'visited_with' => 'required|in:Self,Parent/Friend',
            'parent_friend_specify' => 'nullable|string|max:255',
            'parent_occupation' => 'nullable|string|max:255',
            'interested_in' => 'nullable|array',
            'course_language' => 'nullable|string',
            'course_type_details' => 'nullable|string',
            'gs_module' => 'nullable|string',
            'optional_subject' => 'nullable|string',
            'other_query' => 'nullable|string',
            'target_year' => 'nullable|string|max:4',
            'enquiry_by' => 'nullable|string|max:255',
            'marketer_id' => 'nullable|exists:marketers,id',
            'counselor_id' => 'nullable|exists:counselors,id',
            'visited_class' => 'nullable|boolean',
            'demo_attended' => 'nullable|boolean',
            'faculty_id' => 'nullable|exists:faculty,id',
        ]);

        if ($validator->fails()) {
            \Log::error('Validation errors:', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please check the form for errors and try again.');
        }

        try {
            // Create the lead
            $leadData = [
                'date' => $request->date,
                'student_name' => $request->student_name,
                'gender' => $request->gender,
                'age' => $request->age ? (int)$request->age : null,
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
                'interested_in' => $request->interested_in ? json_encode($request->interested_in) : null,
                'course_language' => $request->course_language,
                'course_type_details' => $request->course_type_details,
                'gs_module' => $request->gs_module,
                'optional_subject' => $request->optional_subject,
                'other_query' => $request->other_query,
                'target_year' => $request->target_year,
                'enquiry_by' => $request->enquiry_by,
                'marketer_id' => $request->marketer_id ?: null,
                'counselor_id' => $request->counselor_id ?: null,
                'visited_class' => $request->boolean('visited_class', false),
                'demo_attended' => $request->boolean('demo_attended', false),
                'faculty_id' => $request->faculty_id ?: null,
                'status' => 'New',
            ];

            \Log::info('Attempting to create lead with data:', $leadData);

            $lead = Lead::create($leadData);

            \Log::info('Lead created successfully with ID:', ['id' => $lead->id]);

            return Inertia::render('Public/ThankYou', [
                'message' => 'Your enquiry has been submitted successfully!',
                'lead_id' => $lead->id
            ]);

        } catch (\Exception $e) {
            \Log::error('Error creating lead:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again. Error: ' . $e->getMessage());
        }
    }

    /**
     * Show success page
     */
    public function success()
    {
        return Inertia::render('Public/ThankYou');
    }
}