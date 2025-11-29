<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Teaching Assignment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('assignments.store') }}">
                        @csrf

                        <!-- Course -->
                        <div class="mb-4">
                            <x-input-label for="course_id" :value="__('Course')" />
                            <select id="course_id" name="course_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }} ({{ $course->code }})</option>
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
                                    <option value="{{ $lecturer->id }}">{{ $lecturer->user->name }} ({{ $lecturer->nip }})</option>
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
                                    <option value="{{ $lecturer->id }}">{{ $lecturer->user->name }} ({{ $lecturer->nip }})</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('lecturer_id_2')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">Leave empty if only one lecturer teaches this course</p>
                        </div>

                        <!-- Class Name -->
                        <div class="mb-4">
                            <x-input-label for="class_name" :value="__('Class Name')" />
                            <x-text-input id="class_name" class="block mt-1 w-full" type="text" name="class_name" :value="old('class_name')" required placeholder="e.g., A, B, C" />
                            <x-input-error :messages="$errors->get('class_name')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">Nama kelas, contoh: A, B, C</p>
                        </div>

                        <!-- Prodi (Program Studi) -->
                        <div class="mb-4">
                            <x-input-label for="prodi" :value="__('Program Studi')" />
                            <select id="prodi" name="prodi" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Prodi</option>
                                <option value="SIPIL">SIPIL</option>
                                <option value="INDUSTRI">INDUSTRI</option>
                                <option value="INFORMATIKA">INFORMATIKA</option>
                                <option value="MESIN">MESIN</option>
                            </select>
                            <x-input-error :messages="$errors->get('prodi')" class="mt-2" />
                        </div>

                        <!-- Semester -->
                        <div class="mb-4">
                            <x-input-label for="semester" :value="__('Semester')" />
                            <select id="semester" name="semester" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Semester</option>
                                <option value="1">Semester 1</option>
                                <option value="2">Semester 2</option>
                                <option value="3">Semester 3</option>
                                <option value="4">Semester 4</option>
                                <option value="5">Semester 5</option>
                                <option value="6">Semester 6</option>
                                <option value="7">Semester 7</option>
                                <option value="8">Semester 8</option>
                            </select>
                            <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Create Assignment') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
