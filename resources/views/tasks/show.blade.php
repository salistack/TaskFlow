<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $task->name }}
                </h2>
                <p class="text-sm text-gray-500">{{ __('Task details and history.') }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('tasks.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500">{{ __('Back to tasks') }}</a>
                @can('update', $task)
                    <a href="{{ route('tasks.edit', $task) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        {{ __('Edit') }}
                    </a>
                @endcan
                @can('delete', $task)
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this task?') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md text-sm font-semibold text-white hover:bg-red-500">
                            {{ __('Delete') }}
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="rounded-md bg-green-50 border border-green-200 p-4 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg border border-gray-100">
                <div class="px-6 py-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">{{ __('Category') }}</h3>
                            <p class="mt-1 text-base text-gray-800">
                                <a href="{{ $task->category ? route('categories.show', $task->category) : '#' }}" class="hover:text-indigo-600">
                                    {{ $task->category?->name ?? __('Uncategorized') }}
                                </a>
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">{{ __('Assigned To') }}</h3>
                            <p class="mt-1 text-base text-gray-800">{{ $task->assignee?->name ?? __('N/A') }}</p>
                            <p class="text-sm text-gray-500">{{ $task->assignee?->email }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">{{ __('Assignment Date') }}</h3>
                            <p class="mt-1 text-base text-gray-800">{{ optional($task->assignment_date)->format('M d, Y h:i A') }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">{{ __('Deadline') }}</h3>
                            <p class="mt-1 text-base text-gray-800">{{ $task->deadline->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">{{ __('Status') }}</h3>
                            <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide {{ $task->status === 'completed' ? 'bg-green-100 text-green-700' : ($task->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700') }}">
                                {{ __(ucwords(str_replace('_', ' ', $task->status))) }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">{{ __('Description') }}</h3>
                        <p class="mt-2 text-base text-gray-800 whitespace-pre-line">{{ $task->description ?: __('No description provided.') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg border border-gray-100">
                <div class="px-6 py-6">
                    <h3 class="text-lg font-semibold text-gray-800">{{ __('Activity') }}</h3>
                    <p class="mt-2 text-sm text-gray-500">{{ __('Created at') }} {{ $task->created_at->format('M d, Y h:i A') }}</p>
                    <p class="mt-1 text-sm text-gray-500">{{ __('Last updated') }} {{ $task->updated_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
