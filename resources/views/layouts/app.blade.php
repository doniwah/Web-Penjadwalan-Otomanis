<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" style="font-family: 'Inter', sans-serif;">
        @if(Auth::check() && Auth::user()->role === 'admin')
            <!-- Admin Layout with Sidebar -->
            <x-sidebar-layout>
                <x-slot name="header">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        @yield('title', 'Dashboard')
                    </h2>
                </x-slot>

                {{ $slot }}
            </x-sidebar-layout>
        @elseif(Auth::check() && Auth::user()->role === 'mahasiswa')
            <!-- Student Layout with Sidebar -->
            <x-student-sidebar-layout>
                <x-slot name="header">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        @yield('title', 'Dashboard')
                    </h2>
                </x-slot>

                {{ $slot }}
            </x-student-sidebar-layout>
        @else
            <!-- Regular Layout without Sidebar (for Lecturer or Guest) -->
            <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow sticky top-16 z-40">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        @endif
    </body>
</html>
