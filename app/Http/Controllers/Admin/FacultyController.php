<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class FacultyController extends Controller
{
    /**
     * Display a listing of faculty.
     */
    public function index(Request $request): Response
    {
        $query = Faculty::query();

        // Filter by status if provided
        if ($request->has('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        // Search by name, email, phone, or subject
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%")
                  ->orWhere('phone', 'like', "%{$searchTerm}%")
                  ->orWhere('subject', 'like', "%{$searchTerm}%");
            });
        }

        // Get faculty with pagination
        $faculty = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Get simple statistics
        $stats = [
            'total_faculty' => Faculty::count(),
            'active_faculty' => Faculty::where('is_active', true)->count(),
            'inactive_faculty' => Faculty::where('is_active', false)->count(),
        ];

        return Inertia::render('Admin/Faculty/Index', [
            'faculty' => $faculty,
            'stats' => $stats,
            'filters' => $request->only(['status', 'search']),
        ]);
    }

    /**
     * Store a newly created faculty in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:faculty'],
            'phone' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $faculty = Faculty::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.faculty.index')
            ->with('success', "Faculty '{$faculty->name}' created successfully!");
    }

    /**
     * Display the specified faculty.
     */
    public function show(Faculty $faculty): Response
    {
        return Inertia::render('Admin/Faculty/Show', [
            'faculty' => $faculty,
        ]);
    }

    /**
     * Update the specified faculty in storage.
     */
    public function update(Request $request, Faculty $faculty): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('faculty')->ignore($faculty->id)],
            'phone' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $faculty->update([
            'name' => $request->name,
            'subject' => $request->subject,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.faculty.index')
            ->with('success', "Faculty '{$faculty->name}' updated successfully!");
    }

    /**
     * Remove the specified faculty from storage.
     */
    public function destroy(Faculty $faculty): RedirectResponse
    {
        $facultyName = $faculty->name;

        // Check if faculty has associated leads
        $leadsCount = $faculty->leads()->count();

        if ($leadsCount > 0) {
            return back()->with('error', "Cannot delete faculty '{$facultyName}' as they have {$leadsCount} associated lead(s). Please reassign or remove the leads first.");
        }

        $faculty->delete();

        return redirect()->route('admin.faculty.index')
            ->with('success', "Faculty '{$facultyName}' deleted successfully!");
    }

    /**
     * Toggle faculty active status.
     */
    public function toggleStatus(Faculty $faculty): RedirectResponse
    {
        $faculty->update([
            'is_active' => !$faculty->is_active
        ]);

        $status = $faculty->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Faculty '{$faculty->name}' has been {$status}!");
    }

    /**
     * Handle bulk actions on faculty.
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'action' => ['required', 'string', 'in:activate,deactivate,delete'],
            'faculty_ids' => ['required', 'array', 'min:1'],
            'faculty_ids.*' => ['integer', 'exists:faculty,id'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $facultyIds = $request->faculty_ids;
        $action = $request->action;

        switch ($action) {
            case 'activate':
                Faculty::whereIn('id', $facultyIds)->update(['is_active' => true]);
                $message = 'Selected faculty have been activated successfully!';
                break;

            case 'deactivate':
                Faculty::whereIn('id', $facultyIds)->update(['is_active' => false]);
                $message = 'Selected faculty have been deactivated successfully!';
                break;

            case 'delete':
                // Check for faculty with leads before deletion
                $facultyWithLeads = Faculty::whereIn('id', $facultyIds)
                    ->whereHas('leads')
                    ->pluck('name')
                    ->toArray();

                if (!empty($facultyWithLeads)) {
                    return back()->with('error', 'Cannot delete faculty with associated leads: ' . implode(', ', $facultyWithLeads));
                }

                Faculty::whereIn('id', $facultyIds)->delete();
                $message = 'Selected faculty have been deleted successfully!';
                break;
        }

        return back()->with('success', $message);
    }
}