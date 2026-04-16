<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            $boards     = Board::withCount('tasks')->latest()->get();
            $totalTasks = Task::count();
            $tasksDone  = Task::where('status', 'done')->count();
            $tasksInProgress = Task::where('status', 'in_progress')->count();
        } else {
            $boards     = Board::where('user_id', $user->id)->withCount('tasks')->latest()->get();
            $totalTasks = Task::where('user_id', $user->id)->count();
            $tasksDone  = Task::where('user_id', $user->id)->where('status', 'done')->count();
            $tasksInProgress = Task::where('user_id', $user->id)->where('status', 'in_progress')->count();
        }

        return view('dashboard', compact('boards', 'totalTasks', 'tasksDone', 'tasksInProgress'));
    }
}