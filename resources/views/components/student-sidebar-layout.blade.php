<!-- Student Sidebar Layout Component -->
@props(['header' => null])

<div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
         class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-green-900 to-green-800 text-white transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0">
        
        <!-- Logo -->
        <div class="flex items-center justify-between h-16 px-6 bg-green-950">
            <a href="{{ route('student.dashboard') }}" class="text-2xl font-bold">
                SiJadu
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="mt-6 px-3 overflow-y-auto" style="height: calc(100vh - 180px);">
            <!-- Dashboard -->
            <a href="{{ route('student.dashboard') }}" 
               class="flex items-center px-4 py-3 mb-2 rounded-lg transition-colors {{ request()->routeIs('student.dashboard') ? 'bg-green-700 text-white' : 'text-green-100 hover:bg-green-700' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <!-- Schedule Section -->
            <div class="mt-6 mb-2">
                <p class="px-4 text-xs font-semibold text-green-300 uppercase tracking-wider">Jadwal</p>
            </div>

            <!-- View Schedule -->
            <a href="{{ route('student.schedule') }}" 
               class="flex items-center px-4 py-3 mb-2 rounded-lg transition-colors {{ request()->routeIs('student.schedule') ? 'bg-green-700 text-white' : 'text-green-100 hover:bg-green-700' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Lihat Jadwal
            </a>

            <!-- Replacement Schedule -->
            <a href="{{ route('student.replacement-schedule') }}" 
               class="flex items-center px-4 py-3 mb-2 rounded-lg transition-colors {{ request()->routeIs('student.replacement-schedule') ? 'bg-green-700 text-white' : 'text-green-100 hover:bg-green-700' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                </svg>
                Jadwal Pengganti
            </a>

            <!-- Settings Section -->
            <div class="mt-6 mb-2">
                <p class="px-4 text-xs font-semibold text-green-300 uppercase tracking-wider">Pengaturan</p>
            </div>

            <!-- Notification Settings -->
            <a href="{{ route('student.notifications') }}" 
               class="flex items-center px-4 py-3 mb-2 rounded-lg transition-colors {{ request()->routeIs('student.notifications') ? 'bg-green-700 text-white' : 'text-green-100 hover:bg-green-700' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                Pengaturan Notifikasi
            </a>
        </nav>

        <!-- User Info at Bottom -->
        <div class="absolute bottom-0 w-full p-4 bg-green-950">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center">
                    <span class="text-white font-semibold text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-green-300">Mahasiswa</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Bar -->
        <header class="bg-white shadow-sm z-10">
            <div class="flex items-center justify-between h-16 px-6">
                <!-- Mobile menu button -->
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div class="flex-1 lg:ml-0 ml-4">
                    @if(isset($header))
                        {{ $header }}
                    @endif
                </div>

                <!-- User Dropdown -->
                <div class="relative" x-data="{ dropdownOpen: false }">
                    <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                        <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="dropdownOpen" 
                         @click.away="dropdownOpen = false"
                         x-transition
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
            {{ $slot }}
        </main>
    </div>

    <!-- Overlay for mobile -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"></div>
</div>
