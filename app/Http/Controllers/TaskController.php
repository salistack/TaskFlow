<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $tasks = Task::with(['category', 'assignee'])
            ->forUser($user)
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('category'), fn ($query) => $query->where('category_id', $request->integer('category')))
            ->orderBy('deadline')
            ->paginate(10)
            ->appends($request->only('status', 'category'));

        $categories = Category::orderBy('name')->pluck('name', 'id');

    return view('tasks.index', compact('tasks', 'categories'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Task::class);

        [$categories, $assignees] = $this->formLookups($request->user());

        return view('tasks.create', compact('categories', 'assignees'));
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(TaskStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Task::class);

        $data = $this->preparePayload($request->validated(), $request->user());

        $task = Task::create($data);

        return redirect()
            ->route('tasks.show', $task)
            ->with('status', 'Task created successfully.');
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task): View
    {
        $this->authorize('view', $task);

        $task->load(['category', 'assignee']);

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Request $request, Task $task): View
    {
        $this->authorize('update', $task);

        [$categories, $assignees] = $this->formLookups($request->user());

        return view('tasks.edit', compact('task', 'categories', 'assignees'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(TaskUpdateRequest $request, Task $task): RedirectResponse
    {
        $this->authorize('update', $task);

        $data = $this->preparePayload($request->validated(), $request->user(), $task);

        $task->update($data);

        return redirect()
            ->route('tasks.show', $task)
            ->with('status', 'Task updated successfully.');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('status', 'Task deleted successfully.');
    }

    /**
     * Gather dropdown data for forms based on the current user.
     */
    private function formLookups(User $user): array
    {
        $categories = Category::orderBy('name')->pluck('name', 'id');

        $assignees = $user->isAdmin()
            ? User::orderBy('name')->pluck('name', 'id')
            : User::whereKey($user->getKey())->pluck('name', 'id');

        return [$categories, $assignees];
    }

    /**
     * Prepare payload for create/update ensuring role constraints are enforced.
     */
    private function preparePayload(array $data, User $actor, ?Task $task = null): array
    {
        if (! $actor->isAdmin()) {
            $data['user_id'] = $actor->getKey();
        }

        if (! $task) {
            $data['assignment_date'] = now();
        }

        return $data;
    }
}
