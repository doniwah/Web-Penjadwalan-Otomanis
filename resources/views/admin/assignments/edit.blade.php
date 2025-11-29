<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Teaching Assignment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('assignments.update', $teachingAssignment) }}">
                        @csrf
                        @method('PUT')

                        <!-- Course -->
                        <div class="mb-4">
                            <x-input-label for="course_id" :value="__('Course')" />
                            <select id="course_id" name="course_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ $teachingAssignment->course_id == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }} ({{ $course->code }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                        </div>

                        <!-- Lecturer 1 (Pengampu 1) -->
                        <div class="mb-4">
                            <x-input-label for="lecturer_id_1" :value="__('Lecturer 1 (Pengampu 1)')" />
                            <select id="lecturer_id_1" name="lecturer_id_1" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Lecturer 1</option>
                                @foreach($lecturers as $lecturer)
                                    <option value="{{ $lecturer->id }}" {{ $teachingAssignment->lecturer_id_1 == $lecturer->id ? 'selected' : '' }}>
                                        {{ $lecturer->user->name }} ({{ $lecturer->nip }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('lecturer_id_1')" class="mt-2" />
                        </div>

                        <!-- Lecturer 2 (Pengampu 2) - Optional -->
                        <div class="mb-4">
                            <x-input-label for="lecturer_id_2" :value="__('Lecturer 2 (Pengampu 2) - Optional')" />
                            <select id="lecturer_id_2" name="lecturer_id_2" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">None (Single Lecturer)</option>
                                @foreach($lecturers as $lecturer)
                                    <option value="{{ $lecturer->id }}" {{ $teachingAssignment->lecturer_id_2 == $lecturer->id ? 'selected' : '' }}>
                                        {{ $lecturer->user->name }} ({{ $lecturer->nip }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('lecturer_id_2')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">Leave empty if only one lecturer teaches this course</p>
                        </div>

                        <!-- Class Name -->
                        <div class="mb-4">
                            <x-input-label for="class_name" :value="__('Class Name')" />
                            <x-text-input id="class_name" class="block mt-1 w-full" type="text" name="class_name" :value="old('class_name', $teachingAssignment->class_name)" required placeholder="e.g., A, B, C" />
                            <x-input-error :messages="$errors->get('class_name')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">Nama kelas, contoh: A, B, C</p>
                        </div>

                        <!-- Prodi (Program Studi) -->
                        <div class="mb-4">
                            <x-input-label for="prodi" :value="__('Program Studi')" />
                            <select id="prodi" name="prodi" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Prodi</option>
                                <option value="Teknik Informatika" {{ $teachingAssignment->prodi == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                                <option value="Sistem Informasi" {{ $teachingAssignment->prodi == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                                <option value="Teknologi Informasi" {{ $teachingAssignment->prodi == 'Teknologi Informasi' ? 'selected' : '' }}>Teknologi Informasi</option>
                                <option value="Ilmu Komputer" {{ $teachingAssignment->prodi == 'Ilmu Komputer' ? 'selected' : '' }}>Ilmu Komputer</option>
                            </select>
                            <x-input-error :messages="$errors->get('prodi')" class="mt-2" />
                        </div>

                        <!-- Semester -->
                        <div class="mb-4">
                            <x-input-label for="semester" :value="__('Semester')" />
                            <select id="semester" name="semester" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Semester</option>
                                @for($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}" {{ $teachingAssignment->semester == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                                @endfor
                            </select>
                            <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Update Assignment') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
