@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-300 text-start text-base font-medium text-white bg-indigo-700/50 focus:outline-none focus:text-white focus:bg-indigo-700/70 focus:border-white transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-white hover:text-white hover:bg-indigo-700/30 hover:border-indigo-300 focus:outline-none focus:text-white focus:bg-indigo-700/30 focus:border-indigo-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
