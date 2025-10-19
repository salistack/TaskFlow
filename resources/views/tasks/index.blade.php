<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Tasks') }}
                </h2>
                <p class="text-sm text-gray-500">{{ __('Track and manage your assignments here.') }}</p>
            </div>
            @can('create', App\Models\Task::class)
                <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Create Task') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-4 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">{{ __('All statuses') }}</option>
                                @foreach (['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed'] as $value => $label)
                                    <option value="{{ $value }}" @selected(request('status') === $value)>{{ __($label) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">{{ __('Category') }}</label>
                            <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">{{ __('All categories') }}</option>
                                @foreach ($categories as $id => $name)
                                    <option value="{{ $id }}" @selected((string) request('category') === (string) $id)>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="inline-flex items-center px-3 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Apply Filters') }}
                            </button>
                            <a href="{{ route('tasks.index') }}" class="ml-3 text-sm text-gray-500 hover:text-gray-700">{{ __('Reset') }}</a>
                        </div>
                    </form>
                </div>

                <div class="px-6 py-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Task') }}</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Category') }}</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Assigned To') }}</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Deadline') }}</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                    <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($tasks as $task)
                                    <tr>
                                        <td class="px-3 py-4">
                                            <a href="{{ route('tasks.show', $task) }}" class="text-sm font-medium text-gray-900 hover:text-indigo-600">
                                                {{ $task->name }}
                                            </a>
                                            <p class="text-xs text-gray-500">{{ __('Created') }} {{ $task->created_at->format('M d, Y') }}</p>
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-700">{{ $task->category?->name ?? __('Uncategorized') }}</td>
                                        <td class="px-3 py-4 text-sm text-gray-700">{{ $task->assignee?->name ?? __('N/A') }}</td>
                                        <td class="px-3 py-4 text-sm text-gray-700">{{ $task->deadline->format('M d, Y') }}</td>
                                        <td class="px-3 py-4">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide {{ $task->status === 'completed' ? 'bg-green-100 text-green-700' : ($task->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700') }}">
                                                {{ __(ucwords(str_replace('_', ' ', $task->status))) }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-4 text-right text-sm">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('tasks.show', $task) }}" class="text-indigo-600 hover:text-indigo-500">{{ __('View') }}</a>
                                                @can('update', $task)
                                                    <a href="{{ route('tasks.edit', $task) }}" class="text-gray-600 hover:text-gray-500">{{ __('Edit') }}</a>
                                                @endcan
                                                @can('delete', $task)
                                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-500" onclick="return confirm('{{ __('Are you sure you want to delete this task?') }}')">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-3 py-6 text-center text-sm text-gray-500">
                                            {{ __('No tasks found.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
