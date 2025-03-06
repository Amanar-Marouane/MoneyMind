<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .scrollbar-thin::-webkit-scrollbar {
            width: 8px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Dark mode scrollbar */
        .dark .scrollbar-thin::-webkit-scrollbar-track {
            background: #2d3748;
        }

        .dark .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #4a5568;
        }

        .dark .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #718096;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <div class="mb-4 text-white rounded-lg bg-green-500 border-l-4 border-green-700 shadow-md">
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)">
                {{ session('success') ?? '' }}</p>
        </div>
        <div class="mb-4 text-white rounded-lg bg-red-500 border-l-4 border-red-700 shadow-md">
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)">{{ session('error') ?? '' }}
            </p>
        </div>
        <div class="mb-4 text-yellow-800 bg-yellow-100 rounded-lg border-l-4 border-yellow-500 shadow-md p-4"
            x-data="{ show: {{ session('alertMessage') ? 'true' : 'false' }} }" x-show="show" x-transition>
            <div class="flex justify-between items-center">
                <p>{{ session('alertMessage') }}</p>
                <button @click="show = false" class="text-yellow-700 hover:text-yellow-900 focus:outline-none"
                    aria-label="Close">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>
