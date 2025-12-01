<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Jadwal') }}
            </h2>
            <a href="{{ route('schedules.index') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar Jadwal
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-primary min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Course Header Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6">
                    <h3 class="text-2xl font-bold text-white mb-2">{{ $schedule->course->name }}</h3>
                    <p class="text-blue-100 text-lg">{{ $schedule->course->code }}</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-3 rounded-lg mr-4">
                                <i class="fas fa-users text-blue-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Kelas</p>
                                <p class="font-semibold text-gray-900">{{ $schedule->class_name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-green-100 p-3 rounded-lg mr-4">
                                <i class="fas fa-flask text-green-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Tipe Mata Kuliah</p>
                                <p class="font-semibold text-gray-900">
                                    @if($schedule->course->is_lab)
                                        <span class="text-green-600">Praktikum</span>
                                    @else
                                        <span class="text-blue-600">Teori</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="bg-purple-100 p-3 rounded-lg mr-4">
                                <i class="fas fa-hashtag text-purple-600 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Schedule ID</p>
                                <p class="font-semibold text-gray-900">#{{ $schedule->id }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Schedule Details Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                        Waktu & Tempat
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Day and Time -->
                        <div class="flex items-start">
                            <div class="bg-blue-50 p-3 rounded-lg mr-4">
                                <i class="fas fa-clock text-blue-600 text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-600">Hari & Waktu</p>
                                <p class="font-semibold text-gray-900 text-lg">
                                    {{ $schedule->timeslot->day }}
                                </p>
                                <p class="text-gray-700 mt-1">
                                    {{ date('H:i', strtotime($schedule->timeslot->start_time)) }} - 
                                    {{ date('H:i', strtotime($schedule->timeslot->end_time)) }}
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Sesi: {{ $schedule->timeslot->session ?? '-' }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Durasi: 
                                    @php
                                        $start = strtotime($schedule->timeslot->start_time);
                                        $end = strtotime($schedule->timeslot->end_time);
                                        $duration = ($end - $start) / 3600;
                                    @endphp
                                    {{ $duration }} jam
                                </p>
                            </div>
                        </div>

                        <!-- Room -->
                        <div class="flex items-start">
                            <div class="bg-purple-50 p-3 rounded-lg mr-4">
                                <i class="fas fa-door-open text-purple-600 text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-600">Ruangan</p>
                                <p class="font-semibold text-gray-900 text-lg">{{ $schedule->room->name }}</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Kapasitas: {{ $schedule->room->capacity }} orang
                                </p>
                                <p class="text-sm text-gray-500">
                                    Tipe: 
                                    @if($schedule->room->is_lab ?? false)
                                        Laboratorium
                                    @else
                                        Ruang Kelas
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lecturers Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-chalkboard-teacher text-blue-600 mr-2"></i>
                        Dosen Pengampu
                    </h4>
                    <div class="space-y-4">
                        <!-- Lecturer 1 -->
                        @if($schedule->lecturer1)
                            <div class="flex items-start bg-gray-50 p-4 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="bg-blue-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-user-tie text-blue-600 text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900 text-lg">{{ $schedule->lecturer1->user->name }}</p>
                                    <p class="text-sm text-gray-600">NIDN: {{ $schedule->lecturer1->nidn ?? '-' }}</p>
                                    @if($schedule->lecturer1->user->email)
                                        <p class="text-sm text-gray-500 mt-1">
                                            <i class="fas fa-envelope mr-1"></i>
                                            {{ $schedule->lecturer1->user->email }}
                                        </p>
                                    @endif
                                </div>
                                <span class="bg-blue-600 text-white text-xs px-3 py-1 rounded-full">Dosen 1</span>
                            </div>
                        @endif

                        <!-- Lecturer 2 -->
                        @if($schedule->lecturer2)
                            <div class="flex items-start bg-gray-50 p-4 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="bg-green-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-user-tie text-green-600 text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900 text-lg">{{ $schedule->lecturer2->user->name }}</p>
                                    <p class="text-sm text-gray-600">NIDN: {{ $schedule->lecturer2->nidn ?? '-' }}</p>
                                    @if($schedule->lecturer2->user->email)
                                        <p class="text-sm text-gray-500 mt-1">
                                            <i class="fas fa-envelope mr-1"></i>
                                            {{ $schedule->lecturer2->user->email }}
                                        </p>
                                    @endif
                                </div>
                                <span class="bg-green-600 text-white text-xs px-3 py-1 rounded-full">Dosen 2</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Teaching Assignment Info -->
            @if($schedule->teachingAssignment)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-clipboard-list text-blue-600 mr-2"></i>
                        Informasi Teaching Assignment
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">Program Studi</p>
                            <p class="font-semibold text-gray-900">{{ $schedule->teachingAssignment->prodi ?? '-' }}</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">Semester</p>
                            <p class="font-semibold text-gray-900">{{ $schedule->teachingAssignment->semester ?? '-' }}</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">Jumlah Mahasiswa</p>
                            <p class="font-semibold text-gray-900">{{ $schedule->teachingAssignment->students_count ?? '-' }} orang</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Metadata -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        Metadata
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Dibuat pada:</span>
                            <span class="font-medium text-gray-900">{{ $schedule->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-200">
                            <span class="text-gray-600">Terakhir diupdate:</span>
                            <span class="font-medium text-gray-900">{{ $schedule->updated_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3">
                <a href="{{ route('schedules.index') }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors text-center">
                    <i class="fas fa-calendar mr-2"></i>
                    Kembali ke Daftar Jadwal
                </a>
                <button onclick="window.print()" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                    <i class="fas fa-print mr-2"></i>
                    Cetak
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
