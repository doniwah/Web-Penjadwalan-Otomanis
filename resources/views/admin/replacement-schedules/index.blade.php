<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Jadwal Pengganti') }}
        </h2>
    </x-slot>

    <div class="py-12 animate-fade-in">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="modern-card overflow-hidden">
                <div class="p-8">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">Pengajuan Jadwal Pengganti</h3>
                        <p class="text-gray-600 mt-1">Kelola pengajuan perubahan jadwal dari dosen</p>
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

                    <!-- Filter Tabs -->
                    <div class="mb-6 border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8">
                            <a href="?status=all" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ request('status', 'all') === 'all' ? 'border-blue-500 text-blue-600' : '' }}">
                                Semua
                            </a>
                            <a href="?status=pending" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ request('status') === 'pending' ? 'border-yellow-500 text-yellow-600' : '' }}">
                                Menunggu
                            </a>
                            <a href="?status=approved" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ request('status') === 'approved' ? 'border-green-500 text-green-600' : '' }}">
                                Disetujui
                            </a>
                            <a href="?status=rejected" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ request('status') === 'rejected' ? 'border-red-500 text-red-600' : '' }}">
                                Ditolak
                            </a>
                        </nav>
                    </div>

                    @if($replacements->count() > 0)
                        <div class="space-y-4">
                            @foreach($replacements as $replacement)
                                <div class="border rounded-lg p-6 {{ $replacement->status === 'approved' ? 'bg-green-50 border-green-200' : ($replacement->status === 'rejected' ? 'bg-red-50 border-red-200' : 'bg-white') }}">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h4 class="font-semibold text-gray-900 text-lg">{{ $replacement->schedule->course->name }}</h4>
                                            <p class="text-sm text-gray-600">Dosen: {{ $replacement->lecturer->user->name }}</p>
                                            <p class="text-xs text-gray-500">Diajukan: {{ $replacement->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                        <div>
                                            @if($replacement->status === 'pending')
                                                <span class="badge bg-yellow-100 text-yellow-800">Menunggu</span>
                                            @elseif($replacement->status === 'approved')
                                                <span class="badge bg-green-100 text-green-800">Disetujui</span>
                                            @else
                                                <span class="badge bg-red-100 text-red-800">Ditolak</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <!-- Original Schedule -->
                                        <div class="bg-white p-4 rounded border">
                                            <p class="text-xs font-semibold text-gray-500 uppercase mb-3">Jadwal Asli</p>
                                            <div class="space-y-2 text-sm">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <span>{{ $replacement->original_date->format('d M Y') }}</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span>{{ $replacement->originalTimeslot->start_time }} - {{ $replacement->originalTimeslot->end_time }}</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                    </svg>
                                                    <span>{{ $replacement->originalRoom->name }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Replacement Schedule -->
                                        <div class="bg-purple-50 p-4 rounded border border-purple-300">
                                            <p class="text-xs font-semibold text-purple-600 uppercase mb-3">Jadwal Pengganti</p>
                                            <div class="space-y-2 text-sm">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <span>{{ $replacement->replacement_date->format('d M Y') }}</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span>{{ $replacement->replacementTimeslot->start_time }} - {{ $replacement->replacementTimeslot->end_time }}</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                    </svg>
                                                    <span>{{ $replacement->replacementRoom->name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4 p-3 bg-blue-50 rounded">
                                        <p class="text-sm"><strong>Alasan:</strong> {{ $replacement->reason }}</p>
                                    </div>

                                    @if($replacement->admin_notes)
                                        <div class="mb-4 p-3 bg-gray-100 rounded">
                                            <p class="text-sm"><strong>Catatan Admin:</strong> {{ $replacement->admin_notes }}</p>
                                        </div>
                                    @endif

                                    @if($replacement->status === 'pending')
                                        <div class="flex items-center space-x-3 pt-4 border-t">
                                            <!-- Approve Form -->
                                            <form action="{{ route('admin.replacement-schedules.approve', $replacement) }}" method="POST" class="flex-1">
                                                @csrf
                                                <div class="flex items-center space-x-2">
                                                    <input type="text" name="admin_notes" placeholder="Catatan (opsional)" class="flex-1 border-gray-300 rounded-md shadow-sm text-sm">
                                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                                                        Setujui
                                                    </button>
                                                </div>
                                            </form>

                                            <!-- Reject Form -->
                                            <form action="{{ route('admin.replacement-schedules.reject', $replacement) }}" method="POST" class="flex-1">
                                                @csrf
                                                <div class="flex items-center space-x-2">
                                                    <input type="text" name="admin_notes" placeholder="Alasan penolakan (wajib)" required class="flex-1 border-gray-300 rounded-md shadow-sm text-sm">
                                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                                                        Tolak
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $replacements->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                            </svg>
                            <p class="text-gray-600">Tidak ada pengajuan jadwal pengganti</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
