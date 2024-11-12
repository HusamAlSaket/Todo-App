@extends('layouts.adminlayout')

@section('content')
    <h1>Admin Task List</h1>

    <!-- Show Create Task button only for admins -->
    @if(auth()->user()->role == 'admin')  <!-- or use isAdmin() if you've defined it -->
        <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary mb-3">Create Task</a>
    @endif

    @foreach($tasks as $task)
        <div class="card mb-2 {{ $task->isCompleted() ? 'border-success' : '' }}">
            <div class="card-body">
                <p>
                    @if($task->isCompleted())
                        <span class="badge bg-success text-light">Completed</span>
                    @endif
                    {{ $task->description }}
                </p>

                <!-- Button to Open Edit Modal -->
                <a href="{{ route('admin.tasks.edit', $task->id) }}" class="btn btn-outline-primary btn-md-3 w-10" style="border-radius: 5px; padding: 7px 20px;">
                    <i class="bi bi-pencil-square"></i> Edit Task
                </a>

                <!-- Single Form for Completing / Reverting the Task -->
                <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="completed" value="{{ $task->isCompleted() ? '0' : '1' }}">
                    <button type="submit" class="btn btn-warning">
                        {{ $task->isCompleted() ? 'Revert to Incomplete' : 'Complete Task' }}
                    </button>
                </form>

                <!-- Form for Deleting the Task -->
                <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Task</button>
                </form>
            </div>
        </div>

        <!-- Edit Task Modal -->
        <div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1" aria-labelledby="editTaskModalLabel{{ $task->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTaskModalLabel{{ $task->id }}">Edit Task</h5>
                        <!-- Close button for the modal -->
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="description{{ $task->id }}" class="form-label">Task Description</label>
                                <input type="text" name="description" id="description{{ $task->id }}" class="form-control" value="{{ $task->description }}" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
