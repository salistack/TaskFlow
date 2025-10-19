<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <span class="text-sm text-gray-500">{{ __('Welcome back,') }} {{ $user->name }}</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white px-6 py-5 shadow-sm rounded-lg border border-gray-100">
                    <p class="text-sm text-gray-500">{{ __('Total Tasks') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-gray-800">{{ $totalTasks }}</p>
                </div>

                <div class="bg-white px-6 py-5 shadow-sm rounded-lg border border-gray-100">
                    <p class="text-sm text-gray-500">{{ __('Completed') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-green-600">{{ $completedTasks }}</p>
                </div>

                <div class="bg-white px-6 py-5 shadow-sm rounded-lg border border-gray-100">
                    <p class="text-sm text-gray-500">{{ __('Pending') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-amber-500">{{ $pendingTasks }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white shadow-sm rounded-lg border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">{{ __('Upcoming Deadlines') }}</h3>
                        <a href="{{ route('tasks.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500">{{ __('View all') }}</a>
                    </div>
                    <div class="px-6 py-4">
                        @forelse ($upcomingTasks as $task)
                            <div class="py-3 @unless($loop->last) border-b border-gray-100 @endunless">
                                <div class="flex justify-between">
                                    <div>
                                        <a href="{{ route('tasks.show', $task) }}" class="text-base font-medium text-gray-800 hover:text-indigo-600">
                                            {{ $task->name }}
                                        </a>
                                        <p class="text-sm text-gray-500">{{ $task->category?->name ?? __('Uncategorized') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs font-semibold uppercase tracking-wide inline-flex items-center px-3 py-1 rounded-full {{ $task->status === 'completed' ? 'bg-green-100 text-green-700' : ($task->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700') }}">
                                            {{ __(ucwords(str_replace('_', ' ', $task->status))) }}
                                        </span>
                                        <p class="mt-2 text-sm text-gray-600">{{ __('Due') }}: {{ $task->deadline->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">{{ __('No upcoming tasks.') }}</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white shadow-sm rounded-lg border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">{{ __('Top Categories') }}</h3>
                    </div>
                    <div class="px-6 py-4">
                        @forelse ($topCategories as $category)
                            <div class="py-3 @unless($loop->last) border-b border-gray-100 @endunless">
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('categories.show', $category) }}" class="font-medium text-gray-800 hover:text-indigo-600">
                                        {{ $category->name }}
                                    </a>
                                    <span class="text-sm text-gray-500">{{ trans_choice('{0} No tasks|{1} :count task|[2,*] :count tasks', $category->tasks_count, ['count' => $category->tasks_count]) }}</span>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">{{ $category->description ?: __('No description provided.') }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">{{ __('No categories yet.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
