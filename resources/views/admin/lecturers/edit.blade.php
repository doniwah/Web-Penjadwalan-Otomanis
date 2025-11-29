<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Lecturer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('lecturers.update', $lecturer) }}">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Full Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $lecturer->user->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- NIP -->
                        <div class="mb-4">
                            <x-input-label for="nip" :value="__('NIP (Nomor Induk Pegawai)')" />
                            <x-text-input id="nip" class="block mt-1 w-full" type="text" name="nip" :value="old('nip', $lecturer->nip)" required />
                            <x-input-error :messages="$errors->get('nip')" class="mt-2" />
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $lecturer->user->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password (Optional) -->
                        <div class="mb-4">
                            <x-input-label for="password" :value="__('New Password (Optional)')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">Leave blank to keep current password</p>
                        </div>

                        <!-- Password Confirmation -->
                        <div class="mb-4">
                            <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                        </div>

                        <!-- Max SKS -->
                        <div class="mb-4">
                            <x-input-label for="max_sks" :value="__('Max SKS')" />
                            <x-text-input id="max_sks" class="block mt-1 w-full" type="number" name="max_sks" :value="old('max_sks', $lecturer->max_sks)" min="1" max="24" />
                            <x-input-error :messages="$errors->get('max_sks')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1">Maximum teaching load</p>
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <a href="{{ route('lecturers.index') }}" class="bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update Lecturer') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
