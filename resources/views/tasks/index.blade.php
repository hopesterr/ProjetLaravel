@extends('layouts.app')
@section('title', 'Toutes les tâches')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-check2-square me-2"></i>Tâches</h2>
    <a href="{{ route('tasks.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i>Nouvelle tâche
    </a>
</div>

{{-- Filtres --}}
<div class="mb-3 d-flex gap-2 flex-wrap">
    <a href="{{ route('tasks.index') }}"
       class="btn btn-sm {{ !request('status') ? 'btn-dark' : 'btn-outline-dark' }}">Tous</a>
    <a href="{{ route('tasks.index') }}?status=todo"
       class="btn btn-sm {{ request('status') === 'todo' ? 'btn-secondary' : 'btn-outline-secondary' }}">À faire</a>
    <a href="{{ route('tasks.index') }}?status=in_progress"
       class="btn btn-sm {{ request('status') === 'in_progress' ? 'btn-warning' : 'btn-outline-warning' }}">En cours</a>
    <a href="{{ route('tasks.index') }}?status=done"
       class="btn btn-sm {{ request('status') === 'done' ? 'btn-success' : 'btn-outline-success' }}">Terminées</a>
</div>

@if($tasks->isEmpty())
    <div class="alert alert-info">Aucune tâche trouvée.</div>
@else
<div class="table-responsive">
    <table class="table table-hover align-middle bg-white shadow-sm rounded">
        <thead class="table-light">
            <tr>
                <th>Titre</th>
                <th>Tableau</th>
                <th>Statut</th>
                <th>Tags</th>
                <th>Échéance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td><a href="{{ route('tasks.show', $task) }}" class="fw-semibold text-decoration-none">{{ $task->title }}</a></td>
                <td><a href="{{ route('boards.show', $task->board) }}">{{ $task->board->name }}</a></td>
                <td>
                    <span class="badge bg-{{ $task->getStatusBadgeClass() }}">
                        {{ $task->getStatusLabel() }}
                    </span>
                </td>
                <td>
                    @foreach($task->tags as $tag)
                        <span class="badge rounded-pill me-1" style="background-color: {{ $tag->color }}">{{ $tag->name }}</span>
                    @endforeach
                </td>
                <td>{{ $task->due_date ? $task->due_date->format('d/m/Y') : '—' }}</td>
                <td>
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="d-inline"
                          onsubmit="return confirm('Supprimer ?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $tasks->links() }}</div>
@endif
@endsection