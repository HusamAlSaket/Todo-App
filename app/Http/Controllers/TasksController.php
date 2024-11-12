<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task; // Ensure you import the Task model

class TasksController extends Controller
{
    public function index()
    {
        $tasks = Task::orderByRaw('completed_at IS NOT NULL') // Order by uncompleted tasks first
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

        // Create the task using the validated input
        Task::create([
            'description' => $request->input('description'),
        ]);
        return redirect('/');

        // Redirect or return a response
        // return redirect('/tasks');
    }
    public function update($id){
        $task =Task::where('id',$id)->first();
        $task->completed_at= now();
        $task->save();
        return redirect('/');
    }
    
}
