<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 rounded-full bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-white shadow-md shadow-indigo-600/30 transition duration-150 ease-in-out hover:bg-indigo-500 hover:shadow-glow focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2 focus:ring-offset-white active:bg-indigo-700 dark:focus:ring-offset-slate-950']) }}>
    {{ $slot }}
</button>
