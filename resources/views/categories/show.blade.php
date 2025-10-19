<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $category->name }}
                </h2>
                <p class="text-sm text-gray-500">{{ __('Overview of tasks in this category.') }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('categories.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500">{{ __('Back to categories') }}</a>
                @can('update', $category)
                    <a href="{{ route('categories.edit', $category) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">{{ __('Edit') }}</a>
                @endcan
                @can('delete', $category)
                    <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('{{ __('Are you sure you want to delete this category?') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md text-sm font-semibold text-white hover:bg-red-500">{{ __('Delete') }}</button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="rounded-md bg-green-50 border border-green-200 p-4 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg border border-gray-100">
                <div class="px-6 py-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">{{ __('Status') }}</h3>
                            <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide {{ $category->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
                                {{ __(ucfirst($category->status)) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">{{ __('Total Tasks') }}</h3>
                            <p class="mt-1 text-base text-gray-800">{{ $category->tasks->count() }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">{{ __('Last Updated') }}</h3>
                            <p class="mt-1 text-base text-gray-800">{{ $category->updated_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">{{ __('Description') }}</h3>
                        <p class="mt-2 text-base text-gray-800 whitespace-pre-line">{{ $category->description ?: __('No description provided.') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">{{ __('Tasks') }}</h3>
                    <a href="{{ route('tasks.index', ['category' => $category->id]) }}" class="text-sm text-indigo-600 hover:text-indigo-500">{{ __('View all tasks') }}</a>
                </div>
                <div class="px-6 py-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Task') }}</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Assigned To') }}</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Deadline') }}</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                    <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($category->tasks as $task)
                                    <tr>
                                        <td class="px-3 py-4">
                                            <a href="{{ route('tasks.show', $task) }}" class="text-sm font-medium text-gray-900 hover:text-indigo-600">{{ $task->name }}</a>
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-700">{{ $task->assignee?->name ?? __('N/A') }}</td>
                                        <td class="px-3 py-4 text-sm text-gray-700">{{ $task->deadline->format('M d, Y') }}</td>
                                        <td class="px-3 py-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide {{ $task->status === 'completed' ? 'bg-green-100 text-green-700' : ($task->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700') }}">
                                                {{ __(ucwords(str_replace('_', ' ', $task->status))) }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-4 text-right text-sm">
                                            <a href="{{ route('tasks.show', $task) }}" class="text-indigo-600 hover:text-indigo-500">{{ __('View') }}</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-3 py-6 text-center text-sm text-gray-500">{{ __('No tasks in this category yet.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
