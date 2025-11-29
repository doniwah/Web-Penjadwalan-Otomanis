<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Dosen') }}
        </h2>
    </x-slot>

    <div class="py-12 animate-fade-in">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="modern-card mb-6 bg-gradient-to-r from-purple-500 to-purple-600 text-white">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                    @if($lecturer)
                        <p class="text-purple-100">NIP: {{ $lecturer->nip }}</p>
                    @endif
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="modern-card bg-white">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Jadwal Hari Ini</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $todaySchedules->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modern-card bg-white">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Total Kelas Mengajar</p>
                                <p class="text-2xl font-bold text-gray-900">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modern-card bg-white">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Notifikasi</p>
                                <p class="text-2xl font-bold text-gray-900">0</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Schedule -->
            @if($todaySchedules->count() > 0)
                <div class="modern-card mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">📅 Jadwal Mengajar Hari Ini - {{ now()->format('l, d F Y') }}</h3>
                        <div class="space-y-3">
                            @foreach($todaySchedules as $schedule)
                                <div class="p-4 bg-gradient-to-r from-purple-50 to-blue-50 rounded-lg border border-purple-200">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900 text-lg">{{ $schedule->course->name }}</h4>
                                            <p class="text-sm text-gray-600 mt-1">
                                                <span class="font-mono">{{ $schedule->course->code }}</span>
                                                <span class="ml-2 badge bg-blue-100 text-blue-800">Kelas {{ $schedule->class_name }}</span>
                                                @if($schedule->course->is_lab)
                                                    <span class="ml-2 badge bg-orange-100 text-orange-800">Lab</span>
                                                @else
                                                    <span class="ml-2 badge bg-green-100 text-green-800">Teori</span>
                                                @endif
                                            </p>
                                            <div class="mt-2 flex flex-wrap gap-3 text-sm text-gray-700">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    {{ $schedule->timeslot->start_time }} - {{ $schedule->timeslot->end_time }}
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                    </svg>
                                                    {{ $schedule->room->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="modern-card mb-6">
                    <div class="p-6 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak Ada Jadwal Mengajar Hari Ini</h3>
                        <p class="text-gray-600">Anda tidak memiliki jadwal mengajar untuk hari ini.</p>
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="modern-card">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Menu Cepat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('dosen.schedule') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">Lihat Jadwal</p>
                                <p class="text-sm text-gray-600">Jadwal mengajar lengkap</p>
                            </div>
                        </a>

                        <a href="{{ route('dosen.replacement-schedule') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">Pengajuan Jadwal Pengganti</p>
                                <p class="text-sm text-gray-600">Ajukan perubahan jadwal</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
