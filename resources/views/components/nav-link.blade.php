@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-vtuber-violet text-sm font-medium leading-5 text-vtuber-violet focus:outline-none focus:border-vtuber-rose transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-kaki-700 hover:text-kaki-900 hover:border-kaki-200 focus:outline-none focus:text-kaki-900 focus:border-kaki-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
