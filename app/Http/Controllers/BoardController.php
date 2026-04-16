<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $boards = $user->isAdmin()
            ? Board::with('user')->withCount('tasks')->latest()->paginate(10)
            : Board::where('user_id', $user->id)->withCount('tasks')->latest()->paginate(10);

        return view('boards.index', compact('boards'));
    }

    public function create()
    {
        return view('boards.create');
    }

    public function store(StoreBoardRequest $request)
    {
        $request->user()->boards()->create($request->validated());

        return redirect()->route('boards.index')
            ->with('success', 'Tableau créé avec succès.');
    }

    public function show(Request $request, Board $board)
    {
        $this->authorizeBoard($board, $request->user());

        $tasks = $board->tasks()
            ->with('tags', 'user')
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->latest()
            ->get();

        return view('boards.show', compact('board', 'tasks'));
    }

    public function edit(Request $request, Board $board)
    {
        $this->authorizeBoard($board, $request->user());

        return view('boards.edit', compact('board'));
    }

    public function update(UpdateBoardRequest $request, Board $board)
    {
        $this->authorizeBoard($board, $request->user());

        $board->update($request->validated());

        return redirect()->route('boards.show', $board)
            ->with('success', 'Tableau mis à jour.');
    }

    public function destroy(Request $request, Board $board)
    {
        $this->authorizeBoard($board, $request->user());

        $board->delete();

        return redirect()->route('boards.index')
            ->with('success', 'Tableau supprimé.');
    }

    private function authorizeBoard(Board $board, $user): void
    {
        if (! $user->isAdmin() && $board->user_id !== $user->id) {
            abort(403, 'Accès non autorisé.');
        }
    }
}