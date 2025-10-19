@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-400 bg-indigo-50 text-start text-base font-medium text-indigo-700 transition duration-150 ease-in-out focus:outline-none focus:bg-indigo-100 focus:text-indigo-800 dark:border-indigo-500 dark:bg-indigo-500/10 dark:text-indigo-200'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-slate-500 transition duration-150 ease-in-out hover:border-slate-300 hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus:border-indigo-400 focus:bg-slate-100 focus:text-slate-700 dark:text-slate-400 dark:hover:border-slate-700 dark:hover:bg-slate-800/70 dark:hover:text-slate-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
