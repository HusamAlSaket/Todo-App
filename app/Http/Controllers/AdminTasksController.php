<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class AdminTasksController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('admin.tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('admin.tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate(['description' => 'required|string|max:255']);
        Task::create(['description' => $request->description]);
        return redirect()->route('admin.tasks.index')->with('success', 'Task created successfully');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('admin.tasks.edit', compact('task'));
    }
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
    
        if ($request->has('description')) {
            $request->validate(['description' => 'required|string|max:255']);
            $task->description = $request->description;
        }
    
        // Check if we are marking as completed or reverting to incomplete
        if ($request->has('completed')) {
            $task->completed_at = $request->completed ? now() : null;
        }
    
        $task->save();
    
        return redirect()->route('admin.tasks.index')->with('success', 'Task updated successfully');
    }
        
    

    public function destroy($id)
    {
        Task::findOrFail($id)->delete();
        return redirect()->route('admin.tasks.index')->with('success', 'Task deleted successfully');
    }

}
