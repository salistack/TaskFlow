<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TaskFlow') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <script>
            (() => {
                try {
                    const storedTheme = localStorage.getItem('theme');
                    const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                    const useDark = storedTheme === 'dark' || (!storedTheme && prefersDark);

                    document.documentElement.classList.toggle('dark', useDark);
                    document.documentElement.style.colorScheme = useDark ? 'dark' : 'light';
                } catch (error) {
                    console.error('Theme initialisation failed', error);
                }
            })();
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="page-shell relative overflow-hidden">
            <div class="absolute inset-0 grid-overlay"></div>

            <div class="relative z-10 min-h-screen flex flex-col">
                @include('layouts.navigation')

                @isset($header)
                    <header class="border-b border-slate-200/60 bg-white/70 backdrop-blur dark:border-slate-800/60 dark:bg-slate-950/50">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="flex-1">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
