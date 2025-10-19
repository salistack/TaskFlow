<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500 dark:text-slate-400">{{ __('Overview') }}</p>
                <h2 class="mt-1 text-3xl font-semibold text-slate-900 dark:text-white">{{ __('Dashboard') }}</h2>
            </div>
            <div class="surface-section flex items-center gap-3 rounded-full px-4 py-2 text-sm text-slate-600 dark:text-slate-300">
                <span>{{ __('Welcome back,') }}</span>
                <span class="font-semibold text-indigo-500 dark:text-indigo-300">{{ $user->name }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto space-y-8 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="surface-card px-6 py-6">
                    <p class="muted-text">{{ __('Total Tasks') }}</p>
                    <p class="mt-3 text-4xl font-semibold text-slate-900 dark:text-white">{{ $totalTasks }}</p>
                </div>

                <div class="surface-card px-6 py-6">
                    <p class="muted-text">{{ __('Completed') }}</p>
                    <p class="mt-3 text-4xl font-semibold text-emerald-500">{{ $completedTasks }}</p>
                </div>

                <div class="surface-card px-6 py-6">
                    <p class="muted-text">{{ __('Pending') }}</p>
                    <p class="mt-3 text-4xl font-semibold text-amber-400">{{ $pendingTasks }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <div class="surface-card">
                    <div class="flex items-center justify-between border-b border-slate-200/60 px-6 py-5 dark:border-slate-800/60">
                        <h3 class="card-title">{{ __('Upcoming Deadlines') }}</h3>
                        <a href="{{ route('tasks.index') }}" class="text-sm font-semibold uppercase tracking-wide text-indigo-400 transition hover:text-indigo-300">{{ __('View all') }}</a>
                    </div>
                    <div class="px-6 py-5 space-y-5">
                        @forelse ($upcomingTasks as $task)
                            <div class="space-y-2">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <a href="{{ route('tasks.show', $task) }}" class="text-lg font-semibold text-slate-900 transition hover:text-indigo-400 dark:text-white">
                                            {{ $task->name }}
                                        </a>
                                        <p class="muted-text">
                                            {{ $task->category?->name ?? __('Uncategorized') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <span class="badge-soft {{ $task->status === 'completed' ? 'bg-emerald-500/10 text-emerald-400' : ($task->status === 'in_progress' ? 'bg-blue-500/10 text-blue-400' : 'bg-amber-500/10 text-amber-400') }}">
                                            {{ __(ucwords(str_replace('_', ' ', $task->status))) }}
                                        </span>
                                        <p class="muted-text mt-2">{{ __('Due') }}: {{ $task->deadline->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="muted-text">{{ __('No upcoming tasks.') }}</p>
                        @endforelse
                    </div>
                </div>

                <div class="surface-card">
                    <div class="border-b border-slate-200/60 px-6 py-5 dark:border-slate-800/60">
                        <h3 class="card-title">{{ __('Top Categories') }}</h3>
                    </div>
                    <div class="px-6 py-5 space-y-5">
                        @forelse ($topCategories as $category)
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('categories.show', $category) }}" class="text-base font-semibold text-slate-900 transition hover:text-indigo-400 dark:text-white">
                                        {{ $category->name }}
                                    </a>
                                    <span class="text-sm font-medium text-indigo-400">{{ trans_choice('{0} No tasks|{1} :count task|[2,*] :count tasks', $category->tasks_count, ['count' => $category->tasks_count]) }}</span>
                                </div>
                                <p class="muted-text">{{ $category->description ?: __('No description provided.') }}</p>
                            </div>
                        @empty
                            <p class="muted-text">{{ __('No categories yet.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
