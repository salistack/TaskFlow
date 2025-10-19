<nav x-data="{ open: false }" class="relative z-20">
    <div class="border-b border-slate-200/60 bg-white/80 backdrop-blur supports-[backdrop-filter]:backdrop-blur dark:border-slate-800/60 dark:bg-slate-950/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @auth
                <div class="flex justify-end py-2 text-xs uppercase tracking-[0.3em] text-slate-400 dark:text-slate-500">
                    <span>{{ __('Logged in as') }}</span>
                    <span class="ms-2 font-semibold tracking-normal text-slate-600 dark:text-slate-200">{{ auth()->user()->name }}</span>
                    <span class="ms-2 text-indigo-500 dark:text-indigo-300">({{ auth()->user()->role }})</span>
                </div>
            @endauth

            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center gap-6">
                    <div class="shrink-0">
                        <a href="{{ route('dashboard') }}" class="flex items-center">
                            <x-application-logo class="block h-9 w-auto fill-current text-indigo-500 transition-colors duration-150 dark:text-indigo-300" />
                        </a>
                    </div>

                    <div class="hidden space-x-8 sm:flex">
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')">
                            {{ __('Tasks') }}
                        </x-nav-link>
                        <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                            {{ __('Categories') }}
                        </x-nav-link>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        @click="$store.theme.toggle()"
                        x-bind:aria-pressed="$store.theme.dark.toString()"
                        class="inline-flex items-center justify-center rounded-full border border-slate-300/60 bg-white/50 p-2 text-slate-600 transition focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 focus:ring-offset-white hover:border-indigo-400 hover:text-indigo-500 dark:border-slate-700/60 dark:bg-slate-900/50 dark:text-slate-300 dark:hover:text-indigo-300 dark:focus:ring-offset-slate-950"
                    >
                        <span class="sr-only">{{ __('Toggle theme') }}</span>
                        <svg
                            x-show="!$store.theme.dark"
                            x-cloak
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            class="h-5 w-5"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75V2m0 20v-1.75M5.303 5.303 4.06 4.06m15.88 15.88-1.243-1.243M3.75 12H2m20 0h-1.75M6.343 17.657l-1.237 1.237m13.788-13.788-1.237 1.237M12 7.5a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9Z" />
                        </svg>
                        <svg
                            x-show="$store.theme.dark"
                            x-cloak
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            class="h-5 w-5"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1 1 11.21 3a7.5 7.5 0 0 0 9.79 9.79Z" />
                        </svg>
                    </button>

                    <div class="hidden sm:flex sm:items-center sm:gap-4">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center gap-2 rounded-full border border-slate-300/60 bg-white/60 px-3 py-2 text-sm font-medium text-slate-600 transition hover:border-indigo-400 hover:text-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 focus:ring-offset-white dark:border-slate-700/60 dark:bg-slate-900/60 dark:text-slate-300 dark:hover:text-indigo-300 dark:focus:ring-offset-slate-950">
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ms-1">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 0 1 1.08 1.04l-4.25 4.25a.75.75 0 0 1-1.08 0L5.21 8.27a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <div class="-me-2 flex items-center sm:hidden">
                        <button @click="open = ! open" class="inline-flex items-center justify-center rounded-md p-2 text-slate-500 transition hover:bg-slate-200/60 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 focus:ring-offset-white dark:text-slate-400 dark:hover:bg-slate-800/70 dark:hover:text-slate-200 dark:focus:ring-offset-slate-950">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-b border-slate-200/60 bg-white/95 px-4 pb-4 pt-4 dark:border-slate-800/60 dark:bg-slate-950/90 sm:hidden">
        <div class="space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')">
                {{ __('Tasks') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                {{ __('Categories') }}
            </x-responsive-nav-link>
        </div>

        <div class="mt-4 border-t border-slate-200/60 pt-4 dark:border-slate-800/60">
            <div class="space-y-4">
                <div>
                    <div class="text-base font-medium text-slate-700 dark:text-slate-200">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-slate-500 dark:text-slate-400">{{ Auth::user()->email }}</div>
                </div>

                <button
                    type="button"
                    @click="$store.theme.toggle()"
                    x-bind:aria-pressed="$store.theme.dark.toString()"
                    class="inline-flex items-center gap-2 rounded-full border border-slate-300/60 bg-white/60 px-3 py-2 text-sm font-medium text-slate-600 transition focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 focus:ring-offset-white hover:border-indigo-400 hover:text-indigo-500 dark:border-slate-700/60 dark:bg-slate-900/60 dark:text-slate-300 dark:hover:text-indigo-300 dark:focus:ring-offset-slate-950"
                >
                    <span>{{ __('Appearance') }}</span>
                    <svg x-show="!$store.theme.dark" x-cloak xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75V2m0 20v-1.75M5.303 5.303 4.06 4.06m15.88 15.88-1.243-1.243M3.75 12H2m20 0h-1.75M6.343 17.657l-1.237 1.237m13.788-13.788-1.237 1.237M12 7.5a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9Z" />
                    </svg>
                    <svg x-show="$store.theme.dark" x-cloak xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1 1 11.21 3a7.5 7.5 0 0 0 9.79 9.79Z" />
                    </svg>
                </button>

                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
