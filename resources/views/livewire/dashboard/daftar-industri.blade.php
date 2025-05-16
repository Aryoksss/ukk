<div>
    <div class="mt-10">
        @if(session()->has('message'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('message') }}</p>
            </div>
        @endif
        
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-2 sm:mb-0">Daftar Industri</h2>
            <div class="flex w-full sm:w-auto">
                <div class="flex items-center w-full sm:w-auto">
                    <div class="relative flex-grow sm:flex-grow-0">
                        <input wire:model.debounce.300ms="search" wire:keydown.enter="searchIndustri" id="search-industri" type="text" placeholder="Cari industri..." 
                            class="block w-full pr-10 pl-3 py-2 focus:outline-none sm:text-sm rounded-l-md border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <button 
                        wire:click="searchIndustri"
                        class="inline-flex items-center px-3 py-2 border border-l-0 border-gray-300 text-sm font-medium rounded-r-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <button wire:click="toggleIndustriForm" class="ml-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                    + Tambah
                </button>
            </div>
        </div>
        
        <!-- Form Tambah Industri -->
        @if($showIndustriForm)
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6 p-4">
            <div class="mb-4 border-b border-gray-200 pb-3">
                <h3 class="text-lg font-medium text-gray-900">Tambah Industri Baru</h3>
                <p class="mt-1 text-sm text-gray-500">Lengkapi informasi di bawah untuk menambahkan industri baru</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama_industri" class="block text-sm font-medium text-gray-700">Nama Industri</label>
                    <input wire:model="nama_industri" type="text" id="nama_industri" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('nama_industri') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label for="bidang_usaha" class="block text-sm font-medium text-gray-700">Bidang Usaha</label>
                    <input wire:model="bidang_usaha" type="text" id="bidang_usaha" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('bidang_usaha') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label for="alamat_industri" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <input wire:model="alamat_industri" type="text" id="alamat_industri" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('alamat_industri') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label for="kontak_industri" class="block text-sm font-medium text-gray-700">Kontak</label>
                    <input wire:model="kontak_industri" type="text" id="kontak_industri" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('kontak_industri') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label for="email_industri" class="block text-sm font-medium text-gray-700">Email</label>
                    <input wire:model="email_industri" type="email" id="email_industri" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('email_industri') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label for="website_industri" class="block text-sm font-medium text-gray-700">Website</label>
                    <input wire:model="website_industri" type="text" id="website_industri" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('website_industri') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                
                <div class="md:col-span-2">
                    <label for="guru_id" class="block text-sm font-medium text-gray-700">Guru Pembimbing</label>
                    <select wire:model="guru_id" id="guru_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">-- Pilih Guru Pembimbing --</option>
                        @foreach($daftarGuru as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->nama }} {{ $guru->nip ? '('.$guru->nip.')' : '' }}</option>
                        @endforeach
                    </select>
                    @error('guru_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" wire:click="toggleIndustriForm" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Batal
                </button>
                <button type="button" wire:click="createIndustri" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Simpan Industri
                </button>
            </div>
        </div>
        @endif
        
        <!-- Daftar Industri -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <ul role="list" class="divide-y divide-gray-200">
                @forelse ($industris as $industri)
                    <li class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-500">{{ strtoupper(substr($industri->nama, 0, 2)) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $industri->nama }}</div>
                                    <div class="text-sm text-gray-500">{{ $industri->bidang_usaha }}</div>
                                    @if($industri->guru)
                                        <div class="text-xs text-indigo-600">Pembimbing: {{ $industri->guru->nama }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:space-x-2">
                                <button wire:click="showIndustriDetail({{ $industri->id }})" class="text-sm text-blue-600 hover:text-blue-900">Detail</button>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-4 sm:px-6 text-center text-gray-500">
                        Tidak ada data industri
                    </li>
                @endforelse
            </ul>
            
            <!-- Pagination -->
            <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6">
                {{ $industris->links() }}
            </div>
        </div>
        
        <!-- Modal Detail Industri -->
        @if($showDetail && $selectedIndustri)
        <div class="fixed inset-0 overflow-y-auto z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    {{ $selectedIndustri->nama }}
                                </h3>
                                <div class="mt-4 border-t border-gray-200">
                                    <dl>
                                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">Bidang Usaha</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $selectedIndustri->bidang_usaha }}</dd>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $selectedIndustri->alamat ?? 'Belum ada data' }}</dd>
                                        </div>
                                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">Kontak</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $selectedIndustri->kontak ?? 'Belum ada data' }}</dd>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $selectedIndustri->email ?? 'Belum ada data' }}</dd>
                                        </div>
                                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">Website</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                @if($selectedIndustri->website)
                                                    <a href="https://{{ $selectedIndustri->website }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                                        {{ $selectedIndustri->website }}
                                                    </a>
                                                @else
                                                    Belum ada data
                                                @endif
                                            </dd>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">Guru Pembimbing</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                @if($selectedIndustri->guru)
                                                    <div>
                                                        <span class="font-medium">{{ $selectedIndustri->guru->nama }}</span>
                                                        @if($selectedIndustri->guru->nip)
                                                            <span class="text-gray-500">({{ $selectedIndustri->guru->nip }})</span>
                                                        @endif
                                                    </div>
                                                    @if($selectedIndustri->guru->kontak)
                                                        <div class="text-sm text-gray-500 mt-1">
                                                            Kontak: {{ $selectedIndustri->guru->kontak }}
                                                        </div>
                                                    @endif
                                                @else
                                                    Belum ada guru pembimbing
                                                @endif
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" wire:click="closeDetail" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
