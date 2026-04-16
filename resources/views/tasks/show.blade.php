@extends('layouts.app')
@section('title', $task->title)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-semibold"><i class="bi bi-card-text me-2"></i>Détail de la tâche</span>
                <span class="badge bg-{{ $task->getStatusBadgeClass() }} fs-6">
                    {{ $task->getStatusLabel() }}
                </span>
            </div>
            <div class="card-body">
                <h4>{{ $task->title }}</h4>

                <div class="mb-3 text-muted small">
                    <i class="bi bi-grid me-1"></i>
                    <a href="{{ route('boards.show', $task->board) }}">{{ $task->board->name }}</a>
                    &nbsp;|&nbsp;
                    <i class="bi bi-person me-1"></i>{{ $task->user->name }}
                    @if($task->due_date)
                        &nbsp;|&nbsp;
                        <i class="bi bi-calendar me-1"></i>{{ $task->due_date->format('d/m/Y') }}
                    @endif
                </div>

                @if($task->description)
                    <p class="mb-3">{{ $task->description }}</p>
                @else
                    <p class="text-muted fst-italic mb-3">Aucune description.</p>
                @endif

                @if($task->tags->count())
                    <div class="mb-3">
                        <strong>Tags :</strong>
                        @foreach($task->tags as $tag)
                            <span class="badge rounded-pill ms-1" style="background-color: {{ $tag->color }}">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="card-footer d-flex gap-2">
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-primary">
                    <i class="bi bi-pencil me-1"></i>Modifier
                </a>
                <a href="{{ route('boards.show', $task->board) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Retour au tableau
                </a>
                <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="ms-auto"
                      onsubmit="return confirm('Supprimer cette tâche ?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger">
                        <i class="bi bi-trash me-1"></i>Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection