@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-2 border-b-2 border-indigo-100 text-sm font-medium leading-5 text-white hover:text-white focus:outline-none focus:border-white transition duration-150 ease-in-out'
            : 'inline-flex items-center px-3 py-2 border-b-2 border-transparent text-sm font-medium leading-5 text-white opacity-80 hover:text-white hover:opacity-100 hover:border-indigo-100 focus:outline-none focus:text-white focus:border-indigo-100 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
