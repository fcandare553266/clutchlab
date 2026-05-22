<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Join Clutch Lab</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden bg-gray-900">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('bg-gym.jpg') }}" class="w-full h-full object-cover opacity-40" alt="Gym Background">
                <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-900/80 to-blue-900/20"></div>
            </div>

            <!-- Branding Logo -->
            <div class="z-10 mb-4">
                <a href="/">
                    <span class="text-4xl font-black italic tracking-tighter text-blue-500 uppercase">CLUTCH<span class="text-white">LAB</span></span>
                </a>
            </div>

            <!-- Form Container -->
            <div class="z-10 w-full sm:max-w-md mt-6 px-8 py-10 bg-gray-900/80 backdrop-blur-lg border border-white/10 shadow-2xl overflow-hidden sm:rounded-3xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>