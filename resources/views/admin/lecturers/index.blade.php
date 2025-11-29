<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lecturers Management') }}
        </h2>
    </x-slot>

    <div class="py-12 animate-fade-in">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Manage Lecturers</h1>
                <p class="text-gray-600 mt-1">Add, edit, or remove lecturers from the system</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded animate-slide-up">
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Actions -->
            <div class="mb-6">
                <a href="{{ route('lecturers.create') }}" class="btn-premium inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Lecturer
                </a>
            </div>

            <!-- Table -->
            <div class="modern-card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>NIP</th>
                                <th>Email</th>
                                <th>Max SKS</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lecturers as $lecturer)
                                <tr>
                                    <td class="font-semibold text-gray-900">{{ $lecturer->user->name }}</td>
                                    <td><span class="font-mono text-gray-700">{{ $lecturer->nip }}</span></td>
                                    <td class="text-gray-700">{{ $lecturer->user->email }}</td>
                                    <td><span class="badge bg-purple-100 text-purple-800">{{ $lecturer->max_sks }} SKS</span></td>
                                    <td>
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('lecturers.edit', $lecturer) }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('lecturers.destroy', $lecturer) }}" onsubmit="return confirm('Are you sure you want to delete this lecturer?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium transition-colors">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-gray-500 py-8">
                                        No lecturers found. Add your first lecturer to get started.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($lecturers->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $lecturers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
