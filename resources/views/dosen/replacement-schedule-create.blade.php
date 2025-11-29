<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Jadwal Pengganti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="modern-card">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Form Pengajuan Jadwal Pengganti</h3>

                    <form method="POST" action="{{ route('dosen.replacement-schedule.store') }}">
                        @csrf

                        <!-- Select Schedule -->
                        <div class="mb-4">
                            <label for="schedule_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Jadwal</label>
                            <select id="schedule_id" name="schedule_id" required class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Pilih Jadwal --</option>
                                @foreach($schedules as $schedule)
                                    <option value="{{ $schedule->id }}" 
                                            data-timeslot="{{ $schedule->timeslot_id }}"
                                            data-room="{{ $schedule->room_id }}">
                                        {{ $schedule->course->name }} - {{ $schedule->timeslot->day }} ({{ $schedule->timeslot->start_time }} - {{ $schedule->timeslot->end_time }}) - {{ $schedule->room->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('schedule_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Original Date -->
                            <div class="mb-4">
                                <label for="original_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Asli</label>
                                <input type="date" id="original_date" name="original_date" required class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @error('original_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Replacement Date -->
                            <div class="mb-4">
                                <label for="replacement_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengganti</label>
                                <input type="date" id="replacement_date" name="replacement_date" required class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @error('replacement_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Original Timeslot (Hidden, auto-filled) -->
                        <input type="hidden" id="original_timeslot_id" name="original_timeslot_id">

                        <!-- Replacement Timeslot -->
                        <div class="mb-4">
                            <label for="replacement_timeslot_id" class="block text-sm font-medium text-gray-700 mb-2">Waktu Pengganti</label>
                            <select id="replacement_timeslot_id" name="replacement_timeslot_id" required class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Pilih Waktu --</option>
                                @foreach($timeslots as $timeslot)
                                    <option value="{{ $timeslot->id }}">{{ $timeslot->day }} - {{ $timeslot->start_time }} - {{ $timeslot->end_time }}</option>
                                @endforeach
                            </select>
                            @error('replacement_timeslot_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Original Room (Hidden, auto-filled) -->
                        <input type="hidden" id="original_room_id" name="original_room_id">

                        <!-- Replacement Room -->
                        <div class="mb-4">
                            <label for="replacement_room_id" class="block text-sm font-medium text-gray-700 mb-2">Ruangan Pengganti</label>
                            <select id="replacement_room_id" name="replacement_room_id" required class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }} (Kapasitas: {{ $room->capacity }})</option>
                                @endforeach
                            </select>
                            @error('replacement_room_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Reason -->
                        <div class="mb-6">
                            <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">Alasan Pengajuan</label>
                            <textarea id="reason" name="reason" rows="4" required class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Jelaskan alasan pengajuan jadwal pengganti..."></textarea>
                            @error('reason')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('dosen.replacement-schedule') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                                Batal
                            </a>
                            <button type="submit" class="btn-premium">
                                Ajukan Jadwal Pengganti
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-fill original timeslot and room when schedule is selected
        document.getElementById('schedule_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const timeslotId = selectedOption.getAttribute('data-timeslot');
            const roomId = selectedOption.getAttribute('data-room');
            
            document.getElementById('original_timeslot_id').value = timeslotId || '';
            document.getElementById('original_room_id').value = roomId || '';
        });
    </script>
</x-app-layout>
