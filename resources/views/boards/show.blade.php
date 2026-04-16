@extends('layouts.app')
@section('title', $board->name)

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h2 class="mb-1">{{ $board->name }}</h2>
        @if($board->description)
            <p class="text-muted mb-0">{{ $board->description }}</p>
        @endif
        <small class="text-muted">Créé par {{ $board->user->name }}</small>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('tasks.create', ['board_id' => $board->id]) }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i>Nouvelle tâche
        </a>
        <a href="{{ route('boards.edit', $board) }}" class="btn btn-outline-secondary">
            <i class="bi bi-pencil me-1"></i>Modifier
        </a>
    </div>
</div>

{{-- Filtres par statut --}}
<div class="mb-3 d-flex gap-2 flex-wrap">
    <a href="{{ route('boards.show', $board) }}"
       class="btn btn-sm {{ !request('status') ? 'btn-dark' : 'btn-outline-dark' }}">Tous</a>
    <a href="{{ route('boards.show', $board) }}?status=todo"
       class="btn btn-sm {{ request('status') === 'todo' ? 'btn-secondary' : 'btn-outline-secondary' }}">À faire</a>
    <a href="{{ route('boards.show', $board) }}?status=in_progress"
       class="btn btn-sm {{ request('status') === 'in_progress' ? 'btn-warning' : 'btn-outline-warning' }}">En cours</a>
    <a href="{{ route('boards.show', $board) }}?status=done"
       class="btn btn-sm {{ request('status') === 'done' ? 'btn-success' : 'btn-outline-success' }}">Terminées</a>
</div>

@if($tasks->isEmpty())
    <div class="alert alert-light border">Aucune tâche dans ce tableau.</div>
@else
<div class="row g-3">
    @foreach($tasks as $task)
    <div class="col-md-4">
        <div class="card h-100 task-card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="badge bg-{{ $task->getStatusBadgeClass() }}">
                        {{ $task->getStatusLabel() }}
                    </span>
                    @if($task->due_date)
                        <small class="text-muted">
                            <i class="bi bi-calendar me-1"></i>{{ $task->due_date->format('d/m/Y') }}
                        </small>
                    @endif
                </div>
                <h6 class="card-title">{{ $task->title }}</h6>
                @if($task->description)
                    <p class="card-text small text-muted">{{ Str::limit($task->description, 80) }}</p>
                @endif
                <div class="d-flex flex-wrap gap-1 mt-2">
                    @foreach($task->tags as $tag)
                        <span class="badge rounded-pill" style="background-color: {{ $tag->color }}">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <small class="text-muted">{{ $task->user->name }}</small>
                <div>
                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="d-inline"
                          onsubmit="return confirm('Supprimer cette tâche ?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection