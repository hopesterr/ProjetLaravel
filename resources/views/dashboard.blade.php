@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h2>
    <a href="{{ route('boards.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Nouveau tableau
    </a>
</div>

{{-- Statistiques --}}
<div class="row g-3 mb-4">
    <div class="col-sm-4">
        <div class="card text-bg-primary h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-2 fw-bold">{{ $boards->count() }}</div>
                    <div>Tableaux</div>
                </div>
                <i class="bi bi-grid fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card text-bg-warning h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-2 fw-bold">{{ $tasksInProgress }}</div>
                    <div>En cours</div>
                </div>
                <i class="bi bi-arrow-repeat fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card text-bg-success h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-2 fw-bold">{{ $tasksDone }}</div>
                    <div>Terminées</div>
                </div>
                <i class="bi bi-check-all fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

{{-- Liste des tableaux --}}
<h5 class="mb-3">Mes tableaux récents</h5>
@if($boards->isEmpty())
    <div class="alert alert-info">Aucun tableau pour l'instant.
        <a href="{{ route('boards.create') }}">Créez-en un !</a>
    </div>
@else
<div class="row g-3">
    @foreach($boards as $board)
    <div class="col-md-4">
        <div class="card h-100 task-card">
            <div class="card-body">
                <h5 class="card-title">{{ $board->name }}</h5>
                <p class="card-text text-muted small">{{ Str::limit($board->description, 80) }}</p>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <span class="badge bg-secondary">
                    <i class="bi bi-check2-square me-1"></i>{{ $board->tasks_count }} tâches
                </span>
                <a href="{{ route('boards.show', $board) }}" class="btn btn-sm btn-outline-primary">
                    Voir <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection