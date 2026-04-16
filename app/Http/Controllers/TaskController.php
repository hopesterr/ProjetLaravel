<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Board;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $tasks = $user->isAdmin()
            ? Task::with('board', 'user', 'tags')
                ->when($request->status, fn($q, $s) => $q->where('status', $s))
                ->latest()->paginate(15)
            : Task::where('user_id', $user->id)
                ->with('board', 'tags')
                ->when($request->status, fn($q, $s) => $q->where('status', $s))
                ->latest()->paginate(15);

        return view('tasks.index', compact('tasks'));
    }

    public function create(Request $request)
    {
        $user = $request->user();

        $boards = $user->isAdmin()
            ? Board::orderBy('name')->get()
            : Board::where('user_id', $user->id)->orderBy('name')->get();

        $tags = Tag::orderBy('name')->get();

        $selectedBoardId = $request->query('board_id');

        return view('tasks.create', compact('boards', 'tags', 'selectedBoardId'));
    }

    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        $tagIds = $data['tags'] ?? [];
        unset($data['tags']);

        $task = $request->user()->tasks()->create($data);
        $task->tags()->sync($tagIds);

        return redirect()->route('boards.show', $task->board_id)
            ->with('success', 'Tâche créée avec succès.');
    }

    public function show(Request $request, Task $task)
    {
        $this->authorizeTask($task, $request->user());

        $task->load('board', 'user', 'tags');

        return view('tasks.show', compact('task'));
    }

    public function edit(Request $request, Task $task)
    {
        $this->authorizeTask($task, $request->user());

        $user = $request->user();

        $boards = $user->isAdmin()
            ? Board::orderBy('name')->get()
            : Board::where('user_id', $user->id)->orderBy('name')->get();

        $tags = Tag::orderBy('name')->get();

        return view('tasks.edit', compact('task', 'boards', 'tags'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorizeTask($task, $request->user());

        $data = $request->validated();
        $tagIds = $data['tags'] ?? [];
        unset($data['tags']);

        $task->update($data);
        $task->tags()->sync($tagIds);

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Tâche mise à jour.');
    }

    public function destroy(Request $request, Task $task)
    {
        $this->authorizeTask($task, $request->user());

        $boardId = $task->board_id;
        $task->delete();

        return redirect()->route('boards.show', $boardId)
            ->with('success', 'Tâche supprimée.');
    }

    private function authorizeTask(Task $task, $user): void
    {
        if (! $user->isAdmin() && $task->user_id !== $user->id) {
            abort(403, 'Accès non autorisé.');
        }
    }
}