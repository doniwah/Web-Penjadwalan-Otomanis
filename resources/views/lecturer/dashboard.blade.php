<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lecturer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-primary min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Preferences Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6 border border-blue-50">
                <h3 class="text-lg font-bold mb-4 text-dark flex items-center">
                    <svg class="w-5 h-5 mr-2 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    Teaching Preferences
                </h3>
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                <form action="{{ route('lecturer.preferences.update') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Preferred Days</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                                <label class="inline-flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 transition cursor-pointer">
                                    <input type="checkbox" name="preferred_days[]" value="{{ $day }}" class="form-checkbox h-5 w-5 text-accent rounded focus:ring-accent"
                                        {{ in_array($day, $lecturer->preferred_days ?? []) ? 'checked' : '' }}>
                                    <span class="ml-2 text-gray-700 font-medium">{{ $day }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="bg-accent hover:bg-dark text-white font-bold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Save Preferences
                    </button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold mb-4 text-dark">My Schedule</h3>
                @if($schedules->isEmpty())
                    <p class="text-gray-500">No schedule found.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($schedules as $schedule)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $schedule->course->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $schedule->course->code }} - Class {{ $schedule->class_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $schedule->room->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $schedule->timeslot->day }} {{ \Carbon\Carbon::parse($schedule->timeslot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->timeslot->end_time)->format('H:i') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
