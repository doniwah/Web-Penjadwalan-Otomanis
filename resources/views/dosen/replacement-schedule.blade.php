<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengajuan Jadwal Pengganti') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header with Add Button -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Pengajuan Jadwal Pengganti</h3>
                    <p class="text-gray-600 mt-1">Ajukan perubahan jadwal mengajar Anda</p>
                </div>
                <a href="{{ route('dosen.replacement-schedule.create') }}" class="btn-premium inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajukan Jadwal Pengganti
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-lg mb-6" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="modern-card">
                <div class="p-6">
                    @if($replacements->count() > 0)
                        <div class="space-y-4">
                            @foreach($replacements as $replacement)
                                <div class="p-4 border rounded-lg {{ $replacement->status === 'approved' ? 'bg-green-50 border-green-200' : ($replacement->status === 'rejected' ? 'bg-red-50 border-red-200' : 'bg-gray-50 border-gray-200') }}">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900 text-lg">{{ $replacement->schedule->course->name }}</h4>
                                            <p class="text-sm text-gray-600 mt-1">{{ $replacement->schedule->course->code }}</p>
                                            
                                            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <!-- Original Schedule -->
                                                <div class="bg-white p-3 rounded border">
                                                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Jadwal Asli</p>
                                                    <div class="space-y-1 text-sm">
                                                        <p><strong>Tanggal:</strong> {{ $replacement->original_date->format('d M Y') }}</p>
                                                        <p><strong>Waktu:</strong> {{ $replacement->originalTimeslot->start_time }} - {{ $replacement->originalTimeslot->end_time }}</p>
                                                        <p><strong>Ruangan:</strong> {{ $replacement->originalRoom->name }}</p>
                                                    </div>
                                                </div>

                                                <!-- Replacement Schedule -->
                                                <div class="bg-white p-3 rounded border border-purple-300">
                                                    <p class="text-xs font-semibold text-purple-600 uppercase mb-2">Jadwal Pengganti</p>
                                                    <div class="space-y-1 text-sm">
                                                        <p><strong>Tanggal:</strong> {{ $replacement->replacement_date->format('d M Y') }}</p>
                                                        <p><strong>Waktu:</strong> {{ $replacement->replacementTimeslot->start_time }} - {{ $replacement->replacementTimeslot->end_time }}</p>
                                                        <p><strong>Ruangan:</strong> {{ $replacement->replacementRoom->name }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-3">
                                                <p class="text-sm"><strong>Alasan:</strong> {{ $replacement->reason }}</p>
                                            </div>

                                            @if($replacement->admin_notes)
                                                <div class="mt-3 p-3 bg-blue-50 rounded border border-blue-200">
                                                    <p class="text-sm"><strong>Catatan Admin:</strong> {{ $replacement->admin_notes }}</p>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="ml-4">
                                            @if($replacement->status === 'pending')
                                                <span class="badge bg-yellow-100 text-yellow-800">Menunggu</span>
                                            @elseif($replacement->status === 'approved')
                                                <span class="badge bg-green-100 text-green-800">Disetujui</span>
                                            @else
                                                <span class="badge bg-red-100 text-red-800">Ditolak</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Pengajuan</h3>
                            <p class="text-gray-600 mb-4">Anda belum mengajukan jadwal pengganti</p>
                            <a href="{{ route('dosen.replacement-schedule.create') }}" class="btn-premium inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Ajukan Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
