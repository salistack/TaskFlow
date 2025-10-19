<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500 dark:text-slate-400">{{ __('Assignments') }}</p>
                <h2 class="mt-1 text-3xl font-semibold text-slate-900 dark:text-white">{{ __('Tasks') }}</h2>
                <p class="muted-text">{{ __('Track and manage your assignments here.') }}</p>
            </div>
            @can('create', App\Models\Task::class)
                <a href="{{ route('tasks.create') }}" class="inline-flex items-center gap-2 rounded-full bg-indigo-600 px-5 py-3 text-xs font-semibold uppercase tracking-[0.3em] text-white shadow-lg shadow-indigo-600/25 transition hover:bg-indigo-500 hover:shadow-glow focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-slate-950">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>{{ __('Create Task') }}</span>
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="surface-section flex items-center gap-3 rounded-2xl px-5 py-4 text-sm text-emerald-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <div class="surface-card">
                <div class="border-b border-slate-200/60 px-6 py-5 dark:border-slate-800/60">
                    <form method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div>
                            <label for="status" class="block text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">{{ __('Status') }}</label>
                            <select name="status" id="status" class="form-field mt-2">
                                <option value="">{{ __('All statuses') }}</option>
                                @foreach (['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed'] as $value => $label)
                                    <option value="{{ $value }}" @selected(request('status') === $value)>{{ __($label) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="category" class="block text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">{{ __('Category') }}</label>
                            <select name="category" id="category" class="form-field mt-2">
                                <option value="">{{ __('All categories') }}</option>
                                @foreach ($categories as $id => $name)
                                    <option value="{{ $id }}" @selected((string) request('category') === (string) $id)>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end justify-end gap-3">
                            <button type="submit" class="inline-flex items-center gap-2 rounded-full border border-indigo-400/60 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-indigo-400 transition hover:border-indigo-300 hover:text-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 focus:ring-offset-white dark:border-indigo-400/40 dark:text-indigo-300 dark:hover:text-indigo-200 dark:focus:ring-offset-slate-950">
                                {{ __('Apply Filters') }}
                            </button>
                            <a href="{{ route('tasks.index') }}" class="text-xs font-semibold uppercase tracking-wide text-slate-400 transition hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300">{{ __('Reset') }}</a>
                        </div>
                    </form>
                </div>

                <div class="overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="table-heading">
                                <tr>
                                    <th class="px-4 py-4 text-left">{{ __('Task') }}</th>
                                    <th class="px-4 py-4 text-left">{{ __('Category') }}</th>
                                    <th class="px-4 py-4 text-left">{{ __('Assigned To') }}</th>
                                    <th class="px-4 py-4 text-left">{{ __('Deadline') }}</th>
                                    <th class="px-4 py-4 text-left">{{ __('Status') }}</th>
                                    <th class="px-4 py-4 text-right">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200/60 dark:divide-slate-800/60">
                                @forelse ($tasks as $task)
                                    <tr class="bg-white/40 transition hover:bg-indigo-50/40 dark:bg-slate-950/30 dark:hover:bg-indigo-500/10">
                                        <td class="px-4 py-4 align-top">
                                            <a href="{{ route('tasks.show', $task) }}" class="text-base font-semibold text-slate-900 transition hover:text-indigo-400 dark:text-white">
                                                {{ $task->name }}
                                            </a>
                                            <p class="muted-text mt-1">{{ __('Created') }} {{ $task->created_at->format('M d, Y') }}</p>
                                        </td>
                                        <td class="px-4 py-4 align-top text-sm text-slate-600 dark:text-slate-300">
                                            {{ $task->category?->name ?? __('Uncategorized') }}
                                        </td>
                                        <td class="px-4 py-4 align-top text-sm text-slate-600 dark:text-slate-300">
                                            {{ $task->assignee?->name ?? __('N/A') }}
                                        </td>
                                        <td class="px-4 py-4 align-top text-sm text-slate-600 dark:text-slate-300">
                                            {{ $task->deadline->format('M d, Y') }}
                                        </td>
                                        <td class="px-4 py-4 align-top">
                                            <span class="badge-soft {{ $task->status === 'completed' ? 'bg-emerald-500/10 text-emerald-400' : ($task->status === 'in_progress' ? 'bg-blue-500/10 text-blue-400' : 'bg-amber-500/10 text-amber-400') }}">
                                                {{ __(ucwords(str_replace('_', ' ', $task->status))) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 align-top text-right text-sm">
                                            <div class="flex items-center justify-end gap-3 text-xs font-semibold uppercase tracking-wide text-indigo-400">
                                                <a href="{{ route('tasks.show', $task) }}" class="transition hover:text-indigo-300">{{ __('View') }}</a>
                                                @can('update', $task)
                                                    <a href="{{ route('tasks.edit', $task) }}" class="text-slate-400 transition hover:text-slate-200">{{ __('Edit') }}</a>
                                                @endcan
                                                @can('delete', $task)
                                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this task?') }}');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-400 transition hover:text-red-300">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ __('No tasks found.') }}</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="border-t border-slate-200/60 px-6 py-5 dark:border-slate-800/60">
                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
