<x-guest-layout>
    <div class="space-y-6">
        <div class="text-center">
            <h1 class="text-2xl font-semibold text-slate-800 dark:text-white">{{ __('Welcome back') }}</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ __('Sign in to continue to your workspace.') }}</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div class="space-y-4">
                <div>
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-text-input id="email" class="mt-2 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="{{ __('name@example.com') }}" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <x-input-label for="password" :value="__('Password')" />
                        @if (Route::has('password.request'))
                            <a class="text-xs font-semibold uppercase tracking-wide text-indigo-500 transition hover:text-indigo-400" href="{{ route('password.request') }}">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>
                    <x-text-input id="password" class="mt-2 w-full" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center gap-3">
                        <input id="remember_me" type="checkbox" class="form-field h-4 w-4 rounded border border-slate-300/70 bg-white/70 text-indigo-500 focus:ring-indigo-500 dark:border-slate-700/70 dark:bg-slate-900/70" name="remember">
                        <span class="text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-xs font-semibold uppercase tracking-wide text-indigo-500 transition hover:text-indigo-400">
                            {{ __('Create account') }}
                        </a>
                    @endif
                </div>
            </div>

            <x-primary-button class="w-full justify-center">
                {{ __('Log in') }}
            </x-primary-button>
        </form>
    </div>
</x-guest-layout>
