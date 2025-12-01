<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Class Schedules') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-primary min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="grid grid-cols-6 gap-2 border-b-2 border-gray-200 pb-4 mb-4">
                    <div class="font-bold text-center text-gray-500">Time / Day</div>
                    @foreach($days as $day)
                        <div class="font-bold text-center text-accent">{{ $day }}</div>
                    @endforeach
                </div>

                <div class="space-y-4">
                    @foreach($timeslots as $timeslot)
                        <div class="grid grid-cols-6 gap-2 border-b border-gray-100 pb-2">
                            <div class="text-sm text-gray-500 text-center flex items-center justify-center">
                                {{ \Carbon\Carbon::parse($timeslot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($timeslot->end_time)->format('H:i') }}
                            </div>
                            
                            @foreach($days as $day)
                                @php
                                    $class = $schedules->first(function($s) use ($day, $timeslot) {
                                        return $s->timeslot->day === $day && $s->timeslot->id === $timeslot->id;
                                    });
                                @endphp

                                <div class="min-h-[100px] p-2 rounded-lg transition duration-300 {{ $class ? 'bg-blue-50 border border-blue-200' : 'bg-gray-50' }}">
                                    @if($class)
                                        <a href="{{ route('schedules.show', $class->id) }}" class="block h-full hover:bg-blue-100 hover:shadow-lg transition-all p-2 rounded">
                                            <div class="font-bold text-sm text-dark">{{ $class->course->name }}</div>
                                            <div class="text-xs text-gray-600 mb-1">{{ $class->course->code }} - {{ $class->class_name }}</div>
                                            <div class="flex items-center text-xs text-accent mt-1">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                {{ $class->lecturer->user->name }}
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1 bg-white inline-block px-2 py-0.5 rounded border border-gray-200 shadow-sm">
                                                {{ $class->room->name }}
                                            </div>
                                            <div class="mt-2 text-xs text-blue-600 font-medium">
                                                <i class="fas fa-arrow-right mr-1"></i>
                                                Lihat Detail
                                            </div>
                                        </a>
                                    @else
                                        <div class="h-full flex items-center justify-center">
                                            <span class="text-gray-300 text-xs">-</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
