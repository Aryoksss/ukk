<div class="min-h-screen flex flex-col sm:justify-center items-center pt-0 sm:pt-0 auth-background">
    <div class="mb-4 auth-card-logo">
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md px-6 py-6 bg-white/40 backdrop-blur-xl shadow-xl overflow-hidden sm:rounded-xl border border-white/20 transition-all duration-300 ease-in-out hover:shadow-2xl">
        {{ $slot }}
    </div>
    
</div>
