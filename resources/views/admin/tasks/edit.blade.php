@extends('layouts.adminlayout')

@section('content')
    <h1>Edit Task</h1>

    <!-- Display success or error messages -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit Task Form -->
    <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="description" class="form-label">Task Description</label>
            <input type="text" name="description" id="description" class="form-control" value="{{ $task->description }}" required>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="completed" id="completed" class="form-check-input" {{ $task->isCompleted() ? 'checked' : '' }}>
            <label for="completed" class="form-check-label">Mark as Completed</label>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
