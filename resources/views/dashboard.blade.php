<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="p-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg shadow-md transform transition-transform duration-300 hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Dashboard PKL') }}
                </h2>
            </div>
            
            @php
                $user = Auth::user();
                $siswa = $user->siswa;
                $pkl = $siswa ? $siswa->pkl : null;
                $today = \Carbon\Carbon::today();
                
                $statusPkl = 'Belum PKL';
                if ($pkl) {
                    $startDate = \Carbon\Carbon::parse($pkl->mulai);
                    $endDate = \Carbon\Carbon::parse($pkl->selesai);
                    
                    if ($today->gte($endDate)) {
                        $statusPkl = 'Selesai';
                    } elseif ($today->gte($startDate)) {
                        $statusPkl = 'Berlangsung';
                    } else {
                        $statusPkl = 'Belum Mulai';
                    }
                }
            @endphp
            
            @if($statusPkl == 'Selesai')
            <span class="inline-flex items-center px-5 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-lg transform hover:scale-105 transition-transform">
                <span class="relative inline-flex h-3 w-3 mr-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                </span>
                PKL Selesai
            </span>
            @elseif($statusPkl == 'Berlangsung')
            <span class="inline-flex items-center px-5 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg transform hover:scale-105 transition-transform">
                <span class="relative inline-flex h-3 w-3 mr-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                </span>
                PKL Berlangsung
            </span>
            @elseif($statusPkl == 'Belum Mulai')
            <span class="inline-flex items-center px-5 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-amber-500 to-orange-600 text-white shadow-lg transform hover:scale-105 transition-transform">
                <span class="relative inline-flex h-3 w-3 mr-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                </span>
                PKL Belum Mulai
            </span>
            @else
            <span class="inline-flex items-center px-5 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-gray-500 to-gray-600 text-white shadow-lg transform hover:scale-105 transition-transform">
                <span class="relative inline-flex h-3 w-3 mr-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                </span>
                Belum PKL
            </span>
            @endif
        </div>
    </x-slot>

    @if(session('warning'))
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-amber-50 to-amber-100 p-5 sm:rounded-xl shadow-lg overflow-hidden" role="alert">
                <div class="absolute inset-0 bg-amber-500 opacity-5"></div>
                <div class="relative flex items-start">
                    <div class="flex-shrink-0 bg-amber-500 rounded-full p-2 shadow-md">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="font-bold text-amber-800">Perhatian!</p>
                        <p class="text-amber-700 mt-1">{{ session('warning') }}</p>
                    </div>
                    <button type="button" class="absolute top-4 right-4 text-amber-700 hover:text-amber-900" onclick="this.parentElement.parentElement.remove()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(!$siswa)
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-5 sm:rounded-xl shadow-lg overflow-hidden relative" role="alert">
                <div class="absolute inset-0 bg-blue-500 opacity-5"></div>
                <div class="relative flex items-start">
                    <div class="flex-shrink-0 bg-blue-500 rounded-full p-2 shadow-md">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="font-bold text-lg text-blue-800">Informasi</p>
                        <p class="text-blue-700 mt-1">Akun Anda belum memiliki data siswa. Silakan hubungi administrator untuk menambahkan data siswa Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @elseif(!$pkl)
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-5 sm:rounded-xl shadow-lg overflow-hidden relative" role="alert">
                <div class="absolute inset-0 bg-blue-500 opacity-5"></div>
                <div class="relative flex items-start">
                    <div class="flex-shrink-0 bg-blue-500 rounded-full p-2 shadow-md">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="font-bold text-lg text-blue-800">Informasi</p>
                        <p class="text-blue-700 mt-1">Anda belum memiliki data PKL. Silakan hubungi guru pembimbing atau administrator untuk mendapatkan penempatan PKL.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- User Info Card -->
            @if($siswa)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl">
                <div class="p-3.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                    <h3 class="font-semibold">Informasi Siswa</h3>
                </div>
                <div class="p-6">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/4 flex justify-center mb-4 md:mb-0">
                            @if($siswa->foto)
                            <div class="relative group">
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full opacity-50 blur-sm group-hover:opacity-75 transition duration-300"></div>
                                <img src="{{ Storage::url($siswa->foto) }}" alt="Foto Siswa" class="relative h-40 w-40 rounded-full object-cover ring-4 ring-indigo-100 shadow-lg transform transition duration-300 group-hover:scale-105">
                            </div>
                            @else
                            <div class="relative group">
                                <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full opacity-30 blur-sm group-hover:opacity-50 transition duration-300"></div>
                                <div class="relative h-40 w-40 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center ring-4 ring-indigo-100 shadow-lg transform transition duration-300 group-hover:scale-105">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="md:w-3/4 md:pl-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="bg-indigo-50 p-3 rounded-lg shadow-sm group hover:bg-indigo-100 transition duration-300">
                                    <h4 class="text-sm font-medium text-indigo-600 group-hover:text-indigo-700">Nama Lengkap</h4>
                                    <p class="text-lg font-semibold text-gray-800">{{ $siswa->nama }}</p>
                                </div>
                                <div class="bg-indigo-50 p-3 rounded-lg shadow-sm group hover:bg-indigo-100 transition duration-300">
                                    <h4 class="text-sm font-medium text-indigo-600 group-hover:text-indigo-700">NIS</h4>
                                    <p class="text-lg font-semibold text-gray-800">{{ $siswa->nis }}</p>
                                </div>
                                <div class="bg-indigo-50 p-3 rounded-lg shadow-sm group hover:bg-indigo-100 transition duration-300">
                                    <h4 class="text-sm font-medium text-indigo-600 group-hover:text-indigo-700">Rombel</h4>
                                    <p class="text-lg font-semibold text-gray-800">{{ $siswa->rombel }}</p>
                                </div>
                                <div class="bg-indigo-50 p-3 rounded-lg shadow-sm group hover:bg-indigo-100 transition duration-300">
                                    <h4 class="text-sm font-medium text-indigo-600 group-hover:text-indigo-700">Status PKL</h4>
                                    <div class="mt-1">
                                        @if($siswa->status_lapor_pkl == 'True')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 shadow-sm">
                                                <svg class="mr-1 h-2 w-2 text-green-600" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Sudah Melapor
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 shadow-sm">
                                                <svg class="mr-1 h-2 w-2 text-amber-600" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Belum Melapor
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- PKL Summary Component -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl transform transition duration-300 hover:shadow-2xl">
                <div class="p-3.5 bg-gradient-to-r from-blue-600 to-indigo-700 text-white flex justify-between items-center">
                    <h3 class="font-semibold">Ringkasan Praktik Kerja Lapangan</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="p-6">
                    <livewire:dashboard.pkl-summary />
                </div>
            </div>
            
            <!-- Detail Industri Component -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl transform transition duration-300 hover:shadow-2xl">
                <div class="p-3.5 bg-gradient-to-r from-purple-600 to-pink-700 text-white flex justify-between items-center">
                    <h3 class="font-semibold">Detail Industri</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div class="p-6">
                    <livewire:dashboard.daftar-industri />
                </div>
            </div>
            
            <!-- Detail Guru Pembimbing Component -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl transform transition duration-300 hover:shadow-2xl">
                <div class="p-3.5 bg-gradient-to-r from-green-600 to-emerald-700 text-white flex justify-between items-center">
                    <h3 class="font-semibold">Detail Guru Pembimbing</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="p-6">
                    @if($pkl && $pkl->industri && $pkl->industri->guru)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="bg-green-50 p-4 rounded-lg shadow-sm group hover:bg-green-100 transition duration-300">
                                <h4 class="text-sm font-medium text-green-700 group-hover:text-green-800">Nama Guru Pembimbing</h4>
                                <p class="text-lg font-semibold text-gray-800">{{ $pkl->industri->guru->nama ?? 'Belum ditentukan' }}</p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg shadow-sm group hover:bg-green-100 transition duration-300">
                                <h4 class="text-sm font-medium text-green-700 group-hover:text-green-800">NIP</h4>
                                <p class="text-lg font-semibold text-gray-800">{{ $pkl->industri->guru->nip ?? '-' }}</p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg shadow-sm group hover:bg-green-100 transition duration-300 md:col-span-2">
                                <h4 class="text-sm font-medium text-green-700 group-hover:text-green-800">Kontak</h4>
                                <p class="text-lg font-semibold text-gray-800">{{ $pkl->industri->guru->kontak ?? 'Tidak tersedia' }}</p>
                            </div>
                        </div>
                    @else
                        <div class="bg-green-50 p-4 rounded-lg text-center">
                            <p class="text-green-700">Data guru pembimbing belum tersedia</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Floating button for quick navigation -->
    <div class="fixed bottom-6 right-6 flex flex-col space-y-3">
        <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="p-3.5 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full shadow-xl hover:from-indigo-700 hover:to-purple-700 transition-all transform hover:scale-110 focus:outline-none group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white transform transition-transform group-hover:-translate-y-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
            </svg>
        </button>
    </div>
</x-app-layout>
