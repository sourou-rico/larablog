<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <!-- Header -->
    <header class="bg-white dark:bg-gray-800 shadow">
        <nav class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <x-application-logo class="w-10 h-10 fill-current text-gray-500" />
                        <span class="ml-2 text-xl font-semibold text-gray-700 dark:text-gray-200">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-sm text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="container mx-auto px-6 py-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                {{ $slot }}
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 shadow mt-8">
        <div class="container mx-auto px-6 py-4">
            <div class="flex flex-col items-center">
                <div class="flex items-center">
                    <x-application-logo class="w-8 h-8 fill-current text-gray-500" />
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-200">{{ config('app.name', 'Laravel') }}</span>
                </div>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    © {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>

</html>
