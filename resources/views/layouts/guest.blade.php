<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        <style>
            html, body {
                height: 100%;
                overflow: hidden;
                font-family: 'Poppins', sans-serif;
            }
            .auth-background {
                background: linear-gradient(135deg, #4c6ef5 0%, #0072ff 100%);
                background-color: #4189d64f;
                background-image: 
                    radial-gradient(at 47% 33%, hsla(217, 100%, 75%, 0.8) 0, transparent 59%), 
                    radial-gradient(at 82% 65%, hsla(218, 100%, 65%, 0.8) 0, transparent 55%);
                height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }
            @media (max-width: 640px) {
                .auth-background {
                    padding: 1rem;
                }
            }
            @media (max-height: 700px) {
                .auth-card-logo {
                    transform: scale(0.85);
                }
                .auth-card-footer {
                    margin-top: 0.5rem !important;
                }
            }
        </style>
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>

        @livewireScripts
    </body>
</html>
