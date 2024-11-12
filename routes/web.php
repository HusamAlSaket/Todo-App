<?php
use App\Http\Controllers\TasksController;
use App\Http\Controllers\AdminTasksController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// User-specific tasks (only accessible when logged in)
Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TasksController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TasksController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TasksController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{id}', [TasksController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{id}', [TasksController::class, 'destroy'])->name('tasks.destroy');
});

// Admin-specific routes with prefix and name
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/tasks', [AdminTasksController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [AdminTasksController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [AdminTasksController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{id}/edit', [AdminTasksController::class, 'edit'])->name('tasks.edit');
    Route::patch('/tasks/{id}', [AdminTasksController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{id}', [AdminTasksController::class, 'destroy'])->name('tasks.destroy');
    
    // Route to create an admin user
    Route::get('/create-admin', [AdminTasksController::class, 'showCreateAdminForm'])->name('createAdminForm');
    Route::post('/create-admin', [AdminTasksController::class, 'createAdminUser'])->name('createAdminUser');
});

// Auth routes for login and registration
require __DIR__.'/auth.php';
