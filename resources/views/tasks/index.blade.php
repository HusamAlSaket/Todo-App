@extends ('layouts.app')

@section('content')
<h1>Your Task List</h1>

@foreach($tasks as $task)
    <div class="card mb-2 {{ $task->isCompleted() ? 'border-success' : '' }}">
        <div class="card-body" style="margin-bottom:20px;">
            <p>
                @if($task->isCompleted())
                    <span class="badge bg-success text-light">Completed</span>
                @endif
                {{ $task->description }}
            </p>

            <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                @method('PATCH')
                @csrf
                @if(!$task->isCompleted()) 
                    <button class="btn btn-secondary" type="submit">
                        Complete
                    </button>
                @endif
            </form>
        </div>
    </div>
@endforeach

<a href="{{ route('tasks.create') }}" class="btn btn-primary btn-lg w-100">New Task</a>
@endsection
