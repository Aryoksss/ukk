<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wide hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 transition-all ease-in-out duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-1 active:translate-y-0 w-auto']) }}>
    {{ $slot }}
</button>
