<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-slate-100">
                {{ __('Create Category') }}
            </h2>
            <a href="{{ route('categories.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-300 dark:hover:text-indigo-200">{{ __('Back to categories') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="surface-card">
                <form method="POST" action="{{ route('categories.store') }}" class="px-6 py-6 space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-300">{{ __('Category Name') }}</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus class="form-field">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-slate-300">{{ __('Description') }}</label>
                        <textarea id="description" name="description" rows="4" class="form-field">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-slate-300">{{ __('Status') }}</label>
                        <select id="status" name="status" required class="form-field">
                            @foreach (['active' => 'Active', 'inactive' => 'Inactive'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', 'active') === $value)>{{ __($label) }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-slate-900 dark:text-slate-200 dark:border-slate-700 dark:hover:bg-slate-800">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Save Category') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
