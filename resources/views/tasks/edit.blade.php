<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Task') }}
            </h2>
            <a href="{{ route('tasks.show', $task) }}" class="text-sm text-indigo-600 hover:text-indigo-500">{{ __('Back to task') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="surface-card">
                <form method="POST" action="{{ route('tasks.update', $task) }}" class="px-6 py-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-300">{{ __('Task Name') }}</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $task->name) }}" required autofocus class="form-field">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-slate-300">{{ __('Description') }}</label>
                        <textarea id="description" name="description" rows="4" class="form-field">{{ old('description', $task->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300">{{ __('Category') }}</label>
                            <select id="category_id" name="category_id" required class="form-field">
                                @foreach ($categories as $id => $name)
                                    <option value="{{ $id }}" @selected(old('category_id', $task->category_id) == $id)>{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">{{ __('Assigned User') }}</label>
                            @if (auth()->user()->isAdmin())
                                <select name="user_id" required class="form-field">
                                    @foreach ($assignees as $id => $name)
                                        <option value="{{ $id }}" @selected(old('user_id', $task->user_id) == $id)>{{ $name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                <p class="mt-1 text-sm text-gray-600">{{ auth()->user()->name }}</p>
                            @endif
                            @error('user_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="deadline" class="block text-sm font-medium text-gray-700 dark:text-slate-300">{{ __('Deadline') }}</label>
                            <input type="date" id="deadline" name="deadline" value="{{ old('deadline', optional($task->deadline)->format('Y-m-d')) }}" required class="form-field">
                            @error('deadline')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-slate-300">{{ __('Status') }}</label>
                            <select id="status" name="status" required class="form-field">
                                @foreach (['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed'] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('status', $task->status) === $value)>{{ __($label) }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('tasks.show', $task) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Update Task') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
