<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gradient-vtuber border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest text-shadow-sm shadow-black/50 drop-shadow-neon hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-vtuber-violet focus:ring-offset-2 active:opacity-80 transition-all ease-in-out duration-300']) }}>
    {{ $slot }}
</button>
