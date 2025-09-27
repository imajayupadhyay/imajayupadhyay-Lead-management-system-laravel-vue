<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Counselor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class CounselorController extends Controller
{
    /**
     * Display a listing of counselors.
     */
    public function index(Request $request): Response
    {
        $query = Counselor::query();

        // Filter by status if provided
        if ($request->has('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        // Search by name, email, or phone
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%")
                  ->orWhere('phone', 'like', "%{$searchTerm}%");
            });
        }

        // Get counselors with pagination
        $counselors = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Get simple statistics
        $stats = [
            'total_counselors' => Counselor::count(),
            'active_counselors' => Counselor::where('is_active', true)->count(),
            'inactive_counselors' => Counselor::where('is_active', false)->count(),
        ];

        return Inertia::render('Admin/Counselors/Index', [
            'counselors' => $counselors,
            'stats' => $stats,
            'filters' => $request->only(['status', 'search']),
        ]);
    }

    /**
     * Store a newly created counselor in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:counselors'],
            'phone' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $counselor = Counselor::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.counselors.index')
            ->with('success', "Counselor '{$counselor->name}' created successfully!");
    }

    /**
     * Display the specified counselor.
     */
    public function show(Counselor $counselor): Response
    {
        return Inertia::render('Admin/Counselors/Show', [
            'counselor' => $counselor,
        ]);
    }

    /**
     * Update the specified counselor in storage.
     */
    public function update(Request $request, Counselor $counselor): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('counselors')->ignore($counselor->id)],
            'phone' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $counselor->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.counselors.index')
            ->with('success', "Counselor '{$counselor->name}' updated successfully!");
    }

    /**
     * Remove the specified counselor from storage.
     */
    public function destroy(Counselor $counselor): RedirectResponse
    {
        $counselorName = $counselor->name;
        
        // Check if counselor has associated leads
        $leadsCount = $counselor->leads()->count();
        
        if ($leadsCount > 0) {
            return back()->with('error', "Cannot delete counselor '{$counselorName}' as they have {$leadsCount} associated lead(s). Please reassign or remove the leads first.");
        }

        $counselor->delete();

        return redirect()->route('admin.counselors.index')
            ->with('success', "Counselor '{$counselorName}' deleted successfully!");
    }

    /**
     * Toggle counselor active status.
     */
    public function toggleStatus(Counselor $counselor): RedirectResponse
    {
        $counselor->update([
            'is_active' => !$counselor->is_active
        ]);

        $status = $counselor->is_active ? 'activated' : 'deactivated';
        
        return back()->with('success', "Counselor '{$counselor->name}' has been {$status}!");
    }

    /**
     * Handle bulk actions on counselors.
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'action' => ['required', 'string', 'in:activate,deactivate,delete'],
            'counselor_ids' => ['required', 'array', 'min:1'],
            'counselor_ids.*' => ['integer', 'exists:counselors,id'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $counselorIds = $request->counselor_ids;
        $action = $request->action;

        switch ($action) {
            case 'activate':
                Counselor::whereIn('id', $counselorIds)->update(['is_active' => true]);
                $message = 'Selected counselors have been activated successfully!';
                break;

            case 'deactivate':
                Counselor::whereIn('id', $counselorIds)->update(['is_active' => false]);
                $message = 'Selected counselors have been deactivated successfully!';
                break;

            case 'delete':
                // Check for counselors with leads before deletion
                $counselorsWithLeads = Counselor::whereIn('id', $counselorIds)
                    ->whereHas('leads')
                    ->pluck('name')
                    ->toArray();

                if (!empty($counselorsWithLeads)) {
                    return back()->with('error', 'Cannot delete counselors with associated leads: ' . implode(', ', $counselorsWithLeads));
                }

                Counselor::whereIn('id', $counselorIds)->delete();
                $message = 'Selected counselors have been deleted successfully!';
                break;
        }

        return back()->with('success', $message);
    }
}