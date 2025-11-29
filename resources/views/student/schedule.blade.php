<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Kuliah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="modern-card">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Jadwal Kuliah Anda</h3>
                            @if($student && $student->class_name)
                                <p class="text-sm text-gray-600 mt-1">Kelas: <span class="font-medium">{{ $student->class_name }}</span> | Prodi: <span class="font-medium">{{ $student->prodi }}</span> | Semester: <span class="font-medium">{{ $student->semester }}</span></p>
                            @endif
                        </div>
                    </div>

                    @if(!$student || !$student->class_name)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-yellow-800">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Silakan lengkapi informasi profil Anda (Kelas, Prodi, Semester) untuk melihat jadwal kuliah.
                            </p>
                        </div>
                    @elseif($schedules->isEmpty())
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-blue-800">
                                <i class="fas fa-info-circle mr-2"></i>
                                Belum ada jadwal yang tersedia untuk kelas Anda. Silakan hubungi admin.
                            </p>
                        </div>
                    @else
                        <!-- Schedule Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-blue-50 to-blue-100">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                            Waktu
                                        </th>
                                        @foreach($days as $day)
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                {{ $day }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($timeslots->unique(function($slot) { return $slot->start_time . '-' . $slot->end_time; }) as $timeslot)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ date('H:i', strtotime($timeslot->start_time)) }} - {{ date('H:i', strtotime($timeslot->end_time)) }}
                                            </td>
                                            @foreach($days as $day)
                                                <td class="px-4 py-3 text-sm">
                                                    @php
                                                        $daySchedule = $schedules->filter(function($schedule) use ($day, $timeslot) {
                                                            return $schedule->timeslot->day === $day && 
                                                                   $schedule->timeslot->start_time === $timeslot->start_time &&
                                                                   $schedule->timeslot->end_time === $timeslot->end_time;
                                                        })->first();
                                                    @endphp
                                                    
                                                    @if($daySchedule)
                                                        <div class="bg-blue-50 border-l-4 border-blue-500 p-3 rounded hover:shadow-md transition-shadow">
                                                            <div class="font-semibold text-gray-900 mb-1">
                                                                {{ $daySchedule->course->name }}
                                                            </div>
                                                            <div class="text-xs text-gray-600 space-y-1">
                                                                <div>
                                                                    <i class="fas fa-chalkboard-teacher mr-1"></i>
                                                                    {{ $daySchedule->lecturer1->user->name ?? '-' }}
                                                                    @if($daySchedule->lecturer2)
                                                                        , {{ $daySchedule->lecturer2->user->name }}
                                                                    @endif
                                                                </div>
                                                                <div>
                                                                    <i class="fas fa-door-open mr-1"></i>
                                                                    {{ $daySchedule->room->name }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="text-gray-400 text-center">-</div>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Legend -->
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Keterangan:</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-2 text-xs text-gray-600">
                                <div><i class="fas fa-chalkboard-teacher mr-2 text-blue-600"></i>Dosen Pengampu</div>
                                <div><i class="fas fa-door-open mr-2 text-blue-600"></i>Ruangan</div>
                                <div><i class="fas fa-clock mr-2 text-blue-600"></i>Waktu Kuliah</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
