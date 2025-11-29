<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        @if($user->role === 'mahasiswa' && $user->student)
            <!-- Student-specific fields -->
            <div class="border-t border-gray-200 pt-6 mt-6">
                <h3 class="text-md font-medium text-gray-900 mb-4">Data Mahasiswa</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Class Name -->
                    <div>
                        <x-input-label for="class_name" :value="__('Kelas')" />
                        <select id="class_name" name="class_name" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Pilih Kelas</option>
                            <option value="A" {{ old('class_name', $user->student->class_name) == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('class_name', $user->student->class_name) == 'B' ? 'selected' : '' }}>B</option>
                            <option value="C" {{ old('class_name', $user->student->class_name) == 'C' ? 'selected' : '' }}>C</option>
                            <option value="D" {{ old('class_name', $user->student->class_name) == 'D' ? 'selected' : '' }}>D</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('class_name')" />
                    </div>

                    <!-- Prodi -->
                    <div>
                        <x-input-label for="prodi" :value="__('Program Studi')" />
                        <select id="prodi" name="prodi" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Pilih Prodi</option>
                            <option value="Teknik Sipil" {{ old('prodi', $user->student->prodi) == 'Teknik Sipil' ? 'selected' : '' }}>Teknik Sipil</option>
                            <option value="Teknik Industri" {{ old('prodi', $user->student->prodi) == 'Teknik Industri' ? 'selected' : '' }}>Teknik Industri</option>
                            <option value="Informatika" {{ old('prodi', $user->student->prodi) == 'Informatika' ? 'selected' : '' }}>Informatika</option>
                            <option value="Teknik Mesin" {{ old('prodi', $user->student->prodi) == 'Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('prodi')" />
                    </div>

                    <!-- Semester -->
                    <div>
                        <x-input-label for="semester" :value="__('Semester')" />
                        <select id="semester" name="semester" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Pilih Semester</option>
                            @for($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}" {{ old('semester', $user->student->semester) == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                            @endfor
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('semester')" />
                    </div>
                </div>

                <p class="text-xs text-gray-500 mt-2">
                    <strong>Penting:</strong> Data kelas, prodi, dan semester digunakan untuk menampilkan jadwal kuliah Anda.
                </p>
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
