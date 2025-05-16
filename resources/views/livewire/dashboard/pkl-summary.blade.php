<div>
    @if(!$hasSiswaData)
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900">Belum Ada Data Siswa</h3>
            <p class="mt-1 text-sm text-gray-500">Data siswa Anda belum tersedia. Silakan hubungi administrator untuk menambahkan data siswa Anda.</p>
        </div>
    </div>
    @elseif(!$hasPklData)
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900">Belum Ada Data PKL</h3>
            <p class="mt-1 text-sm text-gray-500">Data PKL Anda belum tersedia. Silakan hubungi guru pembimbing atau administrator untuk mendapatkan penempatan PKL.</p>
        </div>
    </div>
    @else
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Bagian Kiri - Status PKL -->
        <div class="lg:col-span-2 bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-700 mb-6">Status PKL</h3>
            
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0">
                    @if($statusPkl == 'Belum Mulai')
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <svg class="-ml-1 mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            {{ $statusPkl }}
                        </span>
                    @elseif($statusPkl == 'Sedang Berlangsung')
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            <svg class="-ml-1 mr-1.5 h-2 w-2 text-blue-400" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            {{ $statusPkl }}
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="-ml-1 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            {{ $statusPkl }}
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="mt-4 mb-6">
                <div class="text-sm text-gray-600 mb-2">Progress</div>
                <div class="relative pt-1">
                    <div class="flex mb-2 items-center justify-between">
                        <div>
                            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full 
                                @if($progressPercentage < 30) 
                                    text-red-600 bg-red-200
                                @elseif($progressPercentage < 70) 
                                    text-yellow-600 bg-yellow-200
                                @else 
                                    text-green-600 bg-green-200 
                                @endif">
                                {{ $progressPercentage }}%
                            </span>
                        </div>
                    </div>
                    <div class="overflow-hidden h-2.5 text-xs flex rounded-full bg-gray-200">
                        <div style="width: {{ $progressPercentage }}%" 
                             class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center rounded-full transition-all duration-500 ease-in-out
                             @if($progressPercentage < 30) 
                                 bg-red-500
                             @elseif($progressPercentage < 70) 
                                 bg-yellow-500
                             @else 
                                 bg-green-500 
                             @endif">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mt-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500 mb-1">Tanggal Mulai</div>
                    <div class="font-medium text-lg">{{ $pkl && $pkl->mulai ? \Carbon\Carbon::parse($pkl->mulai)->locale('id')->isoFormat('DD MMMM YYYY') : '-' }}</div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-sm text-gray-500 mb-1">Tanggal Selesai</div>
                    <div class="font-medium text-lg">{{ $pkl && $pkl->selesai ? \Carbon\Carbon::parse($pkl->selesai)->locale('id')->isoFormat('DD MMMM YYYY') : '-' }}</div>
                </div>
            </div>
        </div>
        
        <!-- Bagian Kanan - Info PKL -->
        <div class="lg:col-span-2 grid grid-cols-1 gap-6">
            <!-- Durasi -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <div class="flex items-center">
                    <div class="mr-4 flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-indigo-100 text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm text-gray-500">Durasi</h3>
                        <div class="flex items-baseline">
                            <span class="text-xl font-bold">{{ $durasi ?? '0' }}</span>
                            <span class="ml-1 text-gray-600">hari</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Industri -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <div class="flex items-center">
                    <div class="mr-4 flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-purple-100 text-purple-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm3 1h6v4H7V5zm8 8V7l-1-1H6L5 7v6h10z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm text-gray-500">Industri</h3>
                        <div class="font-medium truncate max-w-xs">{{ $industri->nama ?? 'Belum ditentukan' }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Pembimbing -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <div class="flex items-center">
                    <div class="mr-4 flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-md bg-green-100 text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm text-gray-500">Pembimbing</h3>
                        <div class="font-medium">{{ $guru->nama ?? 'Belum ditentukan' }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Siswa -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                <div class="flex items-center">
                    <div class="mr-4 h-12 w-12 rounded-full overflow-hidden flex-shrink-0">
                        @if($siswa && $siswa->foto)
                            @php
                                $filename = basename($siswa->foto);
                                $photoUrl = route('foto-siswa', ['filename' => $filename]);
                            @endphp
                            <img src="{{ $photoUrl }}" 
                                 alt="{{ $siswa->nama }}" 
                                 class="h-full w-full object-cover rounded-full"
                                 onerror="this.onerror=null; this.src='{{ url('/storage/images/' . $filename) }}';">
                        @else
                            <div class="h-12 w-12 bg-amber-100 rounded-full flex items-center justify-center text-amber-800 font-bold">
                                {{ $siswa ? substr($siswa->nama, 0, 1) : 'S' }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-sm text-gray-500">Siswa</h3>
                        <div class="font-medium">{{ $siswa->nama ?? 'Belum ditentukan' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @endif
</div>
