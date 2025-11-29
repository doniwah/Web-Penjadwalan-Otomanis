<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Timeslot') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('timeslots.update', $timeslot) }}">
                        @csrf
                        @method('PUT')

                        <!-- Day -->
                        <div class="mb-4">
                            <x-input-label for="day" :value="__('Day')" />
                            <select id="day" name="day" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="Monday" {{ $timeslot->day == 'Monday' ? 'selected' : '' }}>Monday</option>
                                <option value="Tuesday" {{ $timeslot->day == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                                <option value="Wednesday" {{ $timeslot->day == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                                <option value="Thursday" {{ $timeslot->day == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                                <option value="Friday" {{ $timeslot->day == 'Friday' ? 'selected' : '' }}>Friday</option>
                            </select>
                            <x-input-error :messages="$errors->get('day')" class="mt-2" />
                        </div>

                        <!-- Session -->
                        <div class="mb-4">
                            <x-input-label for="session" :value="__('Session')" />
                            <x-text-input id="session" class="block mt-1 w-full" type="number" name="session" :value="old('session', $timeslot->session)" required min="1" max="10" />
                            <x-input-error :messages="$errors->get('session')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">Session number (e.g., 1, 2, 3)</p>
                        </div>

                        <!-- Start Time -->
                        <div class="mb-4">
                            <x-input-label for="start_time" :value="__('Start Time')" />
                            <x-text-input id="start_time" class="block mt-1 w-full" type="time" name="start_time" :value="old('start_time', $timeslot->start_time)" required />
                            <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                        </div>

                        <!-- End Time -->
                        <div class="mb-4">
                            <x-input-label for="end_time" :value="__('End Time')" />
                            <x-text-input id="end_time" class="block mt-1 w-full" type="time" name="end_time" :value="old('end_time', $timeslot->end_time)" required />
                            <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Update Timeslot') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
