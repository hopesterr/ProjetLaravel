@extends('layouts.app')
@section('title', 'Modifier la tâche')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-pencil-square me-2"></i>Modifier : {{ $task->title }}
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('tasks.update', $task) }}">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tableau</label>
                        <select name="board_id" class="form-select" required>
                            @foreach($boards as $board)
                                <option value="{{ $board->id }}"
                                    {{ old('board_id', $task->board_id) == $board->id ? 'selected' : '' }}>
                                    {{ $board->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Titre <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $task->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $task->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Statut <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="todo"        {{ old('status', $task->status) === 'todo' ? 'selected' : '' }}>À faire</option>
                                <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>En cours</option>
                                <option value="done"        {{ old('status', $task->status) === 'done' ? 'selected' : '' }}>Terminé</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Date d'échéance</label>
                            <input type="date" name="due_date"
                                   class="form-control @error('due_date') is-invalid @enderror"
                                   value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
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
                                       {{ in_array($tag->id, old('tags', $task->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
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
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Enregistrer
                        </button>
                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection