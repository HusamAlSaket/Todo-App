<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User; // Add User model
use Illuminate\Support\Facades\Hash; // Add for password hashing

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

    // Add method to create an admin user
// App\Http\Controllers\AdminTasksController.php

public function createAdmin(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'admin', // Assign the 'admin' role
    ]);

    return redirect()->route('admin.tasks.index')->with('success', 'Admin user created successfully');
}
public function createAdminUser(Request $request)
{
    // Validate input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Create the admin user
    $admin = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'admin', // Set the role to 'admin'
    ]);

    // Redirect back with a success message
    return redirect()->route('admin.tasks.index')->with('success', 'Admin user created successfully');
}
public function showCreateAdminForm()
{
    return view('admin.createAdminUser'); // Show the form to create an admin user
}


}
