<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SiJadu - Sistem Informasi Jadwal Kuliah</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased font-sans text-gray-900 bg-white">

    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md fixed w-full z-50 top-0 start-0 border-b border-gray-100">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="self-center text-2xl font-bold whitespace-nowrap text-accent">SiJadu</span>
            </a>
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="text-white bg-accent hover:bg-dark focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center transition duration-300">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-accent hover:text-white border border-accent hover:bg-accent focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-2 transition duration-300">Log
                            in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="text-white bg-accent hover:bg-dark focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center transition duration-300">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-b from-primary to-white pt-32 pb-20">
        <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
            <div class="mr-auto place-self-center lg:col-span-7">
                <h1
                    class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl text-dark">
                    Jadwal Kuliah Otomatis
                </h1>
                <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl">
                    SiJadu merupakan sistem penjadwalan kuliah otomatis untuk Dosen dan Mahasiswa di Universitas
                    Sarjanawiyata Tamansiswa.
                </p>
                <a href="{{ route('login') }}"
                    class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-accent hover:bg-dark focus:ring-4 focus:ring-blue-300 transition duration-300">
                    Mulai Sekarang
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
            <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                <!-- Placeholder for Hero Image -->
                <div
                    class="w-full h-96 bg-white rounded-lg shadow-xl flex items-center justify-center border border-gray-100 overflow-hidden relative">
                    <div class="absolute inset-0 bg-pattern opacity-10"></div>
                    <div class="p-8 text-center">
                        <div
                            class="w-16 h-16 bg-accent rounded-full mx-auto mb-4 flex items-center justify-center text-white text-2xl font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0h18M5.25 12h13.5h-13.5zm0 4.5h13.5h-13.5z" />
                            </svg>
                        </div>
                        <p class="text-gray-400 font-medium">Smart Scheduling System</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-white py-20">
        <div class="max-w-screen-xl px-4 mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold tracking-tight text-dark sm:text-4xl">Fitur Unggulan</h2>
                <p class="mt-4 text-lg text-gray-500">Solusi lengkap untuk manajemen jadwal akademik kampus Anda.</p>
            </div>
            <div class="grid gap-8 md:grid-cols-3">
                <!-- Feature 1 -->
                <div
                    class="p-6 bg-primary rounded-xl shadow-sm hover:shadow-md transition duration-300 border border-blue-100">
                    <div
                        class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mb-4 text-accent shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-dark mb-2">Algoritma Genetika</h3>
                    <p class="text-gray-600">Penyusunan jadwal otomatis yang cerdas, meminimalkan bentrok dan
                        memaksimalkan preferensi dosen.</p>
                </div>
                <!-- Feature 2 -->
                <div
                    class="p-6 bg-primary rounded-xl shadow-sm hover:shadow-md transition duration-300 border border-blue-100">
                    <div
                        class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mb-4 text-accent shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-dark mb-2">Real-time Notification</h3>
                    <p class="text-gray-600">Dapatkan notifikasi langsung via email saat jadwal terbaru dipublikasikan
                        oleh admin.</p>
                </div>
                <!-- Feature 3 -->
                <div
                    class="p-6 bg-primary rounded-xl shadow-sm hover:shadow-md transition duration-300 border border-blue-100">
                    <div
                        class="w-12 h-12 bg-white rounded-lg flex items-center justify-center mb-4 text-accent shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-dark mb-2">Manajemen Lengkap</h3>
                    <p class="text-gray-600">Kelola data Dosen, Mahasiswa, Ruangan, dan Mata Kuliah dalam satu dashboard
                        yang terintegrasi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100">
        <div class="max-w-screen-xl px-4 py-8 mx-auto text-center">
            <span class="text-2xl font-bold text-accent">SiJadu</span>
            <p class="my-4 text-gray-500">Sistem Informasi Jadwal Kuliah Otomatis</p>
            <span class="text-sm text-gray-400">© 2025 SiJadu. All Rights Reserved.</span>
        </div>
    </footer>

</body>

</html>
