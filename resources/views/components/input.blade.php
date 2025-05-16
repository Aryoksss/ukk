@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm w-full px-3 py-2 text-gray-700 transition-all duration-300 ease-in-out hover:border-blue-400 focus:shadow-md']) !!}>
