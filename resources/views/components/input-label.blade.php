@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-300']) }}>
    {{ $value ?? $slot }}
</label>
