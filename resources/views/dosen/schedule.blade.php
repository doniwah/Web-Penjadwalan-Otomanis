<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Mengajar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="modern-card">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Jadwal Mengajar Anda</h3>
                    
                    @if($schedules->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="table-modern">
                                <thead>
                                    <tr>
                                        <th>Hari</th>
                                        <th>Waktu</th>
                                        <th>Mata Kuliah</th>
                                        <th>Kelas</th>
                                        <th>Ruangan</th>
                                        <th>Tipe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($schedules as $schedule)
                                        <tr>
                                            <td class="font-semibold">{{ $schedule->timeslot->day }}</td>
                                            <td class="font-mono text-sm">{{ $schedule->timeslot->start_time }} - {{ $schedule->timeslot->end_time }}</td>
                                            <td>
                                                <div class="font-semibold text-gray-900">{{ $schedule->course->name }}</div>
                                                <div class="text-sm text-gray-600">{{ $schedule->course->code }}</div>
                                            </td>
                                            <td><span class="badge bg-blue-100 text-blue-800">{{ $schedule->class_name }}</span></td>
                                            <td class="text-gray-700">{{ $schedule->room->name }}</td>
                                            <td>
                                                @if($schedule->course->is_lab)
                                                    <span class="badge bg-orange-100 text-orange-800">Lab</span>
                                                @else
                                                    <span class="badge bg-green-100 text-green-800">Teori</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-gray-600">Belum ada jadwal mengajar yang tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
