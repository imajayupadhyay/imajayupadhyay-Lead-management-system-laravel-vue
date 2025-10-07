<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('counselor_id', Auth::guard('counselor')->id())
            ->orderBy('due_date', 'asc')
            ->orderBy('priority', 'desc')
            ->paginate(15);

        $pendingCount = Task::where('counselor_id', Auth::guard('counselor')->id())
            ->where('status', 'Pending')->count();
        $inProgressCount = Task::where('counselor_id', Auth::guard('counselor')->id())
            ->where('status', 'In Progress')->count();
        $completedCount = Task::where('counselor_id', Auth::guard('counselor')->id())
            ->where('status', 'Completed')->count();

        return Inertia::render('Counselor/Tasks/Index', [
            'tasks' => $tasks,
            'pendingCount' => $pendingCount,
            'inProgressCount' => $inProgressCount,
            'completedCount' => $completedCount,
            'user' => Auth::guard('counselor')->user()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Counselor/Tasks/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'due_time' => 'nullable',
            'priority' => 'required|in:High,Medium,Low',
            'status' => 'required|in:Pending,In Progress,Completed'
        ]);

        $validated['counselor_id'] = Auth::guard('counselor')->id();

        if ($validated['status'] === 'Completed') {
            $validated['completed_at'] = now();
        }

        Task::create($validated);

        return redirect()->route('counselor.tasks.index')->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::where('counselor_id', Auth::guard('counselor')->id())
            ->findOrFail($id);

        return Inertia::render('Counselor/Tasks/Show', [
            'task' => $task
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::where('counselor_id', Auth::guard('counselor')->id())
            ->findOrFail($id);

        return Inertia::render('Counselor/Tasks/Edit', [
            'task' => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::where('counselor_id', Auth::guard('counselor')->id())
            ->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'due_time' => 'nullable',
            'priority' => 'required|in:High,Medium,Low',
            'status' => 'required|in:Pending,In Progress,Completed'
        ]);

        if ($validated['status'] === 'Completed' && $task->status !== 'Completed') {
            $validated['completed_at'] = now();
        } elseif ($validated['status'] !== 'Completed') {
            $validated['completed_at'] = null;
        }

        $task->update($validated);

        return redirect()->route('counselor.tasks.index')->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::where('counselor_id', Auth::guard('counselor')->id())
            ->findOrFail($id);

        $task->delete();

        return redirect()->route('counselor.tasks.index')->with('success', 'Task deleted successfully!');
    }

    /**
     * Mark task as completed
     */
    public function markComplete(string $id)
    {
        $task = Task::where('counselor_id', Auth::guard('counselor')->id())
            ->findOrFail($id);

        $task->update([
            'status' => 'Completed',
            'completed_at' => now()
        ]);

        return redirect()->back()->with('success', 'Task marked as completed!');
    }
}
