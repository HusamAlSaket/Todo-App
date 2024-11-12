<?php

use App\Http\Controllers\TasksController;
use App\Http\Controllers\AdminTasksController;

Route::get('/', [TasksController::class, 'index']);
Route::get('tasks', [TasksController::class, 'index']);
Route::get('/tasks/create', [TasksController::class, 'create']);
Route::post('/tasks', [TasksController::class, 'store']);
Route::patch('/tasks/{id}', [TasksController::class, 'update']);

Route::get('/logins', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';




Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/tasks', [AdminTasksController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [AdminTasksController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [AdminTasksController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{id}/edit', [AdminTasksController::class, 'edit'])->name('tasks.edit');
    Route::patch('/tasks/{id}', [AdminTasksController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{id}', [AdminTasksController::class, 'destroy'])->name('tasks.destroy');
});
