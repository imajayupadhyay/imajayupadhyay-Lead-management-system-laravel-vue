<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Marketer;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class MarketerController extends Controller
{
    /**
     * Display a listing of marketers.
     */
    public function index(Request $request): Response
    {
        $query = Marketer::query();

        // Filter by status if provided
        if ($request->has('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        // Search by name, email, or designation
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%")
                  ->orWhere('designation', 'like', "%{$searchTerm}%");
            });
        }

        // Get marketers with pagination
        $marketers = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Get simple statistics
        $stats = [
            'total_marketers' => Marketer::count(),
            'active_marketers' => Marketer::where('is_active', true)->count(),
            'inactive_marketers' => Marketer::where('is_active', false)->count(),
        ];

        return Inertia::render('Admin/Marketers/Index', [
            'marketers' => $marketers,
            'stats' => $stats,
            'filters' => $request->only(['status', 'search']),
        ]);
    }

    /**
     * Store a newly created marketer in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:marketers'],
            'phone' => ['nullable', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $marketer = Marketer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'designation' => $request->designation,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.marketers.index')
            ->with('success', "Marketer '{$marketer->name}' created successfully!");
    }

    /**
     * Display the specified marketer.
     */
    public function show(Marketer $marketer): Response
    {
        return Inertia::render('Admin/Marketers/Show', [
            'marketer' => $marketer,
        ]);
    }

    /**
     * Update the specified marketer in storage.
     */
    public function update(Request $request, Marketer $marketer): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('marketers')->ignore($marketer->id)],
            'phone' => ['nullable', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $marketer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'designation' => $request->designation,
            'is_active' => $request->is_active ?? true,
        ]);

        return redirect()->route('admin.marketers.index')
            ->with('success', "Marketer '{$marketer->name}' updated successfully!");
    }

    /**
     * Remove the specified marketer from storage.
     */
    public function destroy(Marketer $marketer): RedirectResponse
    {
        $marketerName = $marketer->name;
        
        // Check if marketer has associated leads
        $leadsCount = $marketer->leads()->count();
        
        if ($leadsCount > 0) {
            return back()->with('error', "Cannot delete marketer '{$marketerName}' as they have {$leadsCount} associated lead(s). Please reassign or remove the leads first.");
        }

        $marketer->delete();

        return redirect()->route('admin.marketers.index')
            ->with('success', "Marketer '{$marketerName}' deleted successfully!");
    }

    /**
     * Toggle marketer active status.
     */
    public function toggleStatus(Marketer $marketer): RedirectResponse
    {
        $marketer->update([
            'is_active' => !$marketer->is_active
        ]);

        $status = $marketer->is_active ? 'activated' : 'deactivated';
        
        return back()->with('success', "Marketer '{$marketer->name}' has been {$status}!");
    }

    /**
     * Handle bulk actions on marketers.
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'action' => ['required', 'string', 'in:activate,deactivate,delete'],
            'marketer_ids' => ['required', 'array', 'min:1'],
            'marketer_ids.*' => ['integer', 'exists:marketers,id'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $marketerIds = $request->marketer_ids;
        $action = $request->action;

        switch ($action) {
            case 'activate':
                Marketer::whereIn('id', $marketerIds)->update(['is_active' => true]);
                $message = 'Selected marketers have been activated successfully!';
                break;

            case 'deactivate':
                Marketer::whereIn('id', $marketerIds)->update(['is_active' => false]);
                $message = 'Selected marketers have been deactivated successfully!';
                break;

            case 'delete':
                // Check for marketers with leads before deletion
                $marketersWithLeads = Marketer::whereIn('id', $marketerIds)
                    ->whereHas('leads')
                    ->pluck('name')
                    ->toArray();

                if (!empty($marketersWithLeads)) {
                    return back()->with('error', 'Cannot delete marketers with associated leads: ' . implode(', ', $marketersWithLeads));
                }

                Marketer::whereIn('id', $marketerIds)->delete();
                $message = 'Selected marketers have been deleted successfully!';
                break;
        }

        return back()->with('success', $message);
    }
}