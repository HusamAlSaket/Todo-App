<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task; // Ensure you import the Task model
use Illuminate\Support\Facades\Auth; // Import Auth to access the logged-in user

class TasksController extends Controller
{
    public function index()
    {
        // Fetch tasks related to the currently authenticated user
        $tasks = Auth::user()->tasks() // Get tasks for the logged-in user
            ->orderByRaw('completed_at IS NOT NULL') // Order by uncompleted tasks first
            ->orderBy('id', 'DESC') // Then order by ID in descending order
            ->get();

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        // Validate the input data if needed
        $request->validate([
            'description' => 'required|string|max:255',
        ]);

        // Create the task using the validated input, and assign it to the logged-in user
        Auth::user()->tasks()->create([ // Create task for the logged-in user
            'description' => $request->input('description'),
        ]);

        // Redirect to the tasks index page
        return redirect()->route('tasks.index');
    }

    public function update($id)
    {
        $task = Task::where('id', $id)->where('user_id', Auth::id())->firstOrFail(); // Ensure the task belongs to the logged-in user
    
        // Update the task's completion status
        $task->completed_at = now();
        $task->save();
    
        // Redirect to the tasks index page
        return redirect()->route('tasks.index');
    }
}
