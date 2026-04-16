@extends('layouts.app')
@section('title', 'Nouvelle tâche')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-plus-square me-2"></i>Créer une tâche
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tableau <span class="text-danger">*</span></label>
                        <select name="board_id" class="form-select @error('board_id') is-invalid @enderror" required>
                            <option value="">-- Choisir un tableau --</option>
                            @foreach($boards as $board)
                                <option value="{{ $board->id }}"
                                    {{ old('board_id', $selectedBoardId) == $board->id ? 'selected' : '' }}>
                                    {{ $board->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('board_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Titre <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Statut <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="todo"        {{ old('status') === 'todo' ? 'selected' : '' }}>À faire</option>
                                <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>En cours</option>
                                <option value="done"        {{ old('status') === 'done' ? 'selected' : '' }}>Terminé</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Date d'échéance</label>
                            <input type="date" name="due_date"
                                   class="form-control @error('due_date') is-invalid @enderror"
                                   value="{{ old('due_date') }}"
                                   min="{{ date('Y-m-d') }}">
                            @error('due_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tags</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox"
                                       name="tags[]" value="{{ $tag->id }}"
                                       id="tag_{{ $tag->id }}"
                                       {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="tag_{{ $tag->id }}">
                                    <span class="badge rounded-pill" style="background-color: {{ $tag->color }}">
                                        {{ $tag->name }}
                                    </span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-1"></i>Créer la tâche
                        </button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection