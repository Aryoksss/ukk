<div>
    @if(!$hasSiswaData || !$hasPklData)
        <!-- Tab Navigation -->
        <div class="border-b border-gray-200 mt-8">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button wire:click="setActiveTab('detail-pkl')" 
                        class="{{ $activeTab === 'detail-pkl' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Detail PKL
                </button>
            </nav>
        </div>
        
        <!-- Tab Content -->
        <div class="mt-6">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if(!$hasSiswaData)
                    <div class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900">Belum Ada Data Siswa</h3>
                        <p class="mt-1 text-sm text-gray-500">Data siswa Anda belum tersedia. Silakan hubungi administrator untuk menambahkan data siswa Anda.</p>
                    </div>
                @else
                    <!-- Form untuk menambahkan data PKL -->
                    <div>
                        @if(session()->has('message'))
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                                <p>{{ session('message') }}</p>
                            </div>
                        @endif
                        
                        @if($isEditing)
                            <!-- Form Edit PKL -->
                            <div class="border-t border-gray-200 p-4 bg-gray-50 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Data PKL</h3>
                                <form wire:submit.prevent="updatePkl" class="space-y-4">
                                    <div>
                                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                                        <input wire:model.lazy="tanggal_mulai" type="date" id="tanggal_mulai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('tanggal_mulai') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                                        <input wire:model.lazy="tanggal_selesai" type="date" id="tanggal_selesai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @error('tanggal_selesai') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="industri_id" class="block text-sm font-medium text-gray-700">Industri</label>
                                        <select wire:model="industri_id" id="industri_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="">Pilih Industri</option>
                                            @foreach($daftarIndustri as $ind)
                                                <option value="{{ $ind->id }}">{{ $ind->nama }} ({{ $ind->bidang_usaha }})</option>
                                            @endforeach
                                        </select>
                                        @error('industri_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div class="flex justify-end space-x-3 pt-4">
                                        <button type="button" wire:click="cancelEdit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Batal
                                        </button>
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900">Belum Ada Data PKL</h3>
                                <p class="mt-1 text-sm text-gray-500">Isi data PKL Anda untuk melengkapi informasi PKL.</p>
                                
                                <button wire:click="startEdit" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Tambah Data PKL
                                </button>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @else
        <!-- Tab Navigation -->
        <div class="border-b border-gray-200 mt-8">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button wire:click="setActiveTab('detail-pkl')" 
                        class="{{ $activeTab === 'detail-pkl' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Detail PKL
                </button>
                <button wire:click="setActiveTab('detail-industri')" 
                        class="{{ $activeTab === 'detail-industri' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Detail Industri
                </button>
                <button wire:click="setActiveTab('detail-guru')" 
                        class="{{ $activeTab === 'detail-guru' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Detail Guru Pembimbing
                </button>
            </nav>
        </div>
        
        <!-- Tab Content -->
        <div class="mt-6">
            <!-- Detail PKL Tab -->
            <div class="{{ $activeTab === 'detail-pkl' ? 'block' : 'hidden' }}">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 bg-gray-50 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Detail PKL</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Informasi tentang PKL siswa</p>
                        </div>
                        
                        @if(session()->has('message'))
                            <div class="bg-green-100 text-green-800 text-sm rounded-lg px-4 py-2">
                                {{ session('message') }}
                            </div>
                        @endif
                        
                        @if(session()->has('error'))
                            <div class="bg-red-100 text-red-800 text-sm rounded-lg px-4 py-2">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        @if(!$hasPklData)
                        <button wire:click="startEdit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Tambah Data
                        </button>
                        @endif
                    </div>
                    
                    @if($isEditing)
                    <!-- Form Edit PKL -->
                    <div class="border-t border-gray-200 p-4 bg-gray-50">
                        <form wire:submit.prevent="updatePkl" class="space-y-4">
                            <div>
                                <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                                <input wire:model.lazy="tanggal_mulai" type="date" id="tanggal_mulai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('tanggal_mulai') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                                <input wire:model.lazy="tanggal_selesai" type="date" id="tanggal_selesai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('tanggal_selesai') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="industri_id" class="block text-sm font-medium text-gray-700">Industri</label>
                                <select wire:model="industri_id" id="industri_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Pilih Industri</option>
                                    @foreach($daftarIndustri as $ind)
                                        <option value="{{ $ind->id }}">{{ $ind->nama }} ({{ $ind->bidang_usaha }})</option>
                                    @endforeach
                                </select>
                                @error('industri_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="flex justify-end space-x-3 pt-4">
                                <button type="button" wire:click="cancelEdit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Batal
                                </button>
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                    @else
                    <!-- Detail PKL -->
                    <div class="border-t border-gray-200">
                        <dl>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Nama Siswa</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $siswa->nama ?? 'Belum ada data' }}</dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Nama Industri</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $industri->nama ?? 'Belum ada data' }}</dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Tanggal Mulai</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $pkl ? $pkl->mulai_indonesia : 'Belum ditentukan' }}</dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Tanggal Selesai</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $pkl ? $pkl->selesai_indonesia : 'Belum ditentukan' }}</dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Durasi</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $durasi ?? '0' }} hari</dd>
                            </div>
                        </dl>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Detail Industri Tab -->
            <div class="{{ $activeTab === 'detail-industri' ? 'block' : 'hidden' }}">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 bg-gray-50">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Detail Industri</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Informasi tentang tempat PKL</p>
                    </div>
                    
                    <div class="border-t border-gray-200">
                        <dl>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Nama Industri</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $industri->nama ?? 'Belum ada data' }}</dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Bidang Usaha</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $industri->bidang_usaha ?? 'Belum ada data' }}</dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $industri->alamat ?? 'Belum ada data' }}</dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Kontak</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $industri->kontak ?? 'Belum ada data' }}</dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $industri->email ?? 'Belum ada data' }}</dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Website</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    @if($industri && $industri->website)
                                        <a href="https://{{ $industri->website }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                            {{ $industri->website }}
                                        </a>
                                    @else
                                        Belum ada data
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
            
            <!-- Detail Guru Pembimbing Tab -->
            <div class="{{ $activeTab === 'detail-guru' ? 'block' : 'hidden' }}">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 bg-gray-50">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Detail Guru Pembimbing</h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Informasi tentang guru pembimbing PKL</p>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Nama Guru</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $guru->nama ?? 'Belum ada data' }}</dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">NIP</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $guru->nip ?? 'Belum ada data' }}</dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Gender</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $guru->gender ?? 'Belum ada data' }}</dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Kontak</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $guru->kontak ?? 'Belum ada data' }}</dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $guru->email ?? 'Belum ada data' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
