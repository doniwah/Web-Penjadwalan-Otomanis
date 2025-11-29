<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Timeslots') }}
        </h2>
    </x-slot>

    <div class="py-12 animate-fade-in">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="modern-card overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Time Slots</h3>
                            <p class="text-gray-600 mt-1">Manage available class schedules</p>
                        </div>
                        <a href="{{ route('timeslots.create') }}" class="btn-premium inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Timeslot
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-lg mb-6 animate-slide-up" role="alert">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="table-modern">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Session</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Duration</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($timeslots as $timeslot)
                                    <tr>
                                        <td>
                                            <span class="badge bg-indigo-100 text-indigo-800 font-semibold">{{ $timeslot->day }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-blue-100 text-blue-800">Sesi {{ $timeslot->session }}</span>
                                        </td>
                                        <td class="font-mono text-gray-700">{{ $timeslot->start_time }}</td>
                                        <td class="font-mono text-gray-700">{{ $timeslot->end_time }}</td>
                                        <td>
                                            <span class="text-gray-600">
                                                {{ \Carbon\Carbon::parse($timeslot->start_time)->diffInMinutes(\Carbon\Carbon::parse($timeslot->end_time)) }} mins
                                            </span>
                                        </td>
                                        <td>
                                            <div class="flex items-center space-x-3">
                                                <a href="{{ route('timeslots.edit', $timeslot) }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                                    Edit
                                                </a>
                                                <form action="{{ route('timeslots.destroy', $timeslot) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition-colors" onclick="return confirm('Are you sure?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6">
                        {{ $timeslots->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
