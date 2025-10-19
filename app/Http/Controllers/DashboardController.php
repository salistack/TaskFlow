<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $totalTasks = Task::forUser($user)->count();
        $completedTasks = Task::forUser($user)->where('status', 'completed')->count();
        $pendingTasks = Task::forUser($user)->where('status', 'pending')->count();

        $upcomingTasks = Task::with('category')
            ->forUser($user)
            ->whereDate('deadline', '>=', now()->toDateString())
            ->orderBy('deadline')
            ->limit(5)
            ->get();

        $topCategories = Category::withCount(['tasks' => fn ($query) => $query->forUser($user)])
            ->orderByDesc('tasks_count')
            ->limit(5)
            ->get();

        return view('dashboard', [
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'pendingTasks' => $pendingTasks,
            'upcomingTasks' => $upcomingTasks,
            'topCategories' => $topCategories,
            'user' => $user,
        ]);
    }
}
