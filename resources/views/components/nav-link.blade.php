@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center border-b-2 border-indigo-400 px-1 pt-1 text-sm font-semibold leading-5 text-slate-800 transition duration-150 ease-in-out focus:outline-none focus:border-indigo-500 dark:text-slate-100'
            : 'inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium leading-5 text-slate-500 transition duration-150 ease-in-out hover:border-slate-300 hover:text-slate-700 focus:outline-none focus:border-indigo-400 focus:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 dark:hover:border-slate-700';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
