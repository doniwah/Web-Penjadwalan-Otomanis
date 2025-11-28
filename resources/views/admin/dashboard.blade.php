<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-primary min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <div class="text-4xl font-bold text-accent">{{ $lecturersCount }}</div>
                    <div class="text-gray-600">Lecturers</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <div class="text-4xl font-bold text-accent">{{ $studentsCount }}</div>
                    <div class="text-gray-600">Students</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <div class="text-4xl font-bold text-accent">{{ $coursesCount }}</div>
                    <div class="text-gray-600">Courses</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <div class="text-4xl font-bold text-accent">{{ $roomsCount }}</div>
                    <div class="text-gray-600">Rooms</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-dark">Quick Actions</h3>
                <div class="flex space-x-4">
                    <a href="{{ url('/generate-schedule') }}" class="bg-accent hover:bg-dark text-white font-bold py-2 px-4 rounded transition duration-300">
                        Generate Schedule
                    </a>
                    <a href="{{ url('/schedules') }}" class="bg-white border border-accent text-accent hover:bg-primary font-bold py-2 px-4 rounded transition duration-300">
                        View Schedules
                    </a>
                    <form action="{{ route('schedule.publish') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-300">
                            Publish Schedule
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
