@extends('layouts.app')
@section('title', 'Tableaux')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-grid me-2"></i>Tableaux</h2>
    <a href="{{ route('boards.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Nouveau tableau
    </a>
</div>

@if($boards->isEmpty())
    <div class="alert alert-info">Aucun tableau trouvé.</div>
@else
<div class="row g-3">
    @foreach($boards as $board)
    <div class="col-md-4">
        <div class="card h-100 task-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h5 class="card-title">{{ $board->name }}</h5>
                    @if(auth()->user()->isAdmin() && $board->user_id !== auth()->id())
                        <span class="badge bg-secondary">{{ $board->user->name }}</span>
                    @endif
                </div>
                <p class="card-text text-muted small">{{ Str::limit($board->description, 100) }}</p>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <span class="badge bg-light text-dark border">
                    {{ $board->tasks_count }} tâche(s)
                </span>
                <div>
                    <a href="{{ route('boards.show', $board) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('boards.edit', $board) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-pencil"></i>
                    </a>
                    <form method="POST" action="{{ route('boards.destroy', $board) }}" class="d-inline"
                          onsubmit="return confirm('Supprimer ce tableau ?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="mt-4">{{ $boards->links() }}</div>
@endif
@endsection
