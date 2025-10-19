<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TaskFlow') }}</title>

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

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="page-shell">
            <div class="grid-overlay absolute inset-0"></div>
            <div class="relative flex min-h-screen flex-col items-center justify-center px-4 py-12">
                <div class="mb-8">
                    <a href="/" class="inline-flex items-center justify-center rounded-full border border-slate-200/70 bg-white/60 p-6 shadow-lg shadow-slate-900/10 backdrop-blur transition hover:border-indigo-300 hover:shadow-glow dark:border-slate-800/70 dark:bg-slate-950/70">
                        <x-application-logo class="h-20 w-20 fill-current text-indigo-500 transition-colors duration-150 dark:text-indigo-300" />
                    </a>
                </div>

                <div class="surface-card w-full max-w-md px-8 py-10">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
