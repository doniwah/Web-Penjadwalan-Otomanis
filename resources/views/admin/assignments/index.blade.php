<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teaching Assignments') }}
        </h2>
    </x-slot>

    <div class="py-12 animate-fade-in">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="modern-card overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Teaching Assignments</h3>
                            <p class="text-gray-600 mt-1">Manage course-lecturer assignments</p>
                        </div>
                        <a href="{{ route('assignments.create') }}" class="btn-premium inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Assignment
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
                                    <th>Course</th>
                                    <th>Lecturer(s)</th>
                                    <th>Class</th>
                                    <th>Prodi</th>
                                    <th>Semester</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignments as $assignment)
                                    <tr>
                                        <td>
                                            <div class="font-semibold text-gray-900">{{ $assignment->course->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $assignment->course->code }}</div>
                                        </td>
                                        <td>
                                            <div class="text-gray-700">
                                                <div class="flex items-center mb-1">
                                                    <span class="badge bg-blue-100 text-blue-800 mr-1">Pengampu 1</span>
                                                    {{ $assignment->lecturer1->user->name }}
                                                </div>
                                                @if($assignment->lecturer_id_2)
                                                    <div class="flex items-center">
                                                        <span class="badge bg-green-100 text-green-800 mr-1">Pengampu 2</span>
                                                        {{ $assignment->lecturer2->user->name }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td><span class="badge bg-blue-100 text-blue-800">{{ $assignment->class_name }}</span></td>
                                        <td class="text-gray-700">{{ $assignment->prodi }}</td>
                                        <td class="text-gray-700">Semester {{ $assignment->semester }}</td>
                                        <td>
                                            <div class="flex items-center space-x-3">
                                                <a href="{{ route('assignments.edit', $assignment) }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                                    Edit
                                                </a>
                                                <form action="{{ route('assignments.destroy', $assignment) }}" method="POST" class="inline">
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
                        {{ $assignments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
