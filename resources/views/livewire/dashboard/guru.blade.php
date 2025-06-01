<div>
    <x-app-layout>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="p-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg shadow-md transform transition-transform duration-300 hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v4" />
                        </svg>
                    </div>
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                        {{ __('Daftar Guru') }}
                    </h2>
                </div>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if(session()->has('message'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm rounded-md" role="alert">
                    <div class="flex">
                        <div class="py-1">
                            <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-3 sm:mb-0">Daftar Guru</h2>
                    <div class="flex w-full sm:w-auto">
                        <div class="flex items-center w-full sm:w-auto">
                            <div class="relative flex-grow sm:flex-grow-0">
                                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari guru..." 
                                       class="block w-full pr-10 pl-10 py-2.5 focus:outline-none sm:text-sm rounded-md border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                @if($search)
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <button wire:click="$set('search', '')" class="text-gray-400 hover:text-gray-600">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Loading indicator -->
                <div wire:loading wire:target="search" class="flex justify-center items-center py-4 mb-4">
                    <div class="flex items-center space-x-2 text-gray-500">
                        <svg class="animate-spin h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-sm">Mencari...</span>
                    </div>
                </div>
                
                @if(((is_object($gurus) && $gurus->isEmpty()) || (is_array($gurus) && empty($gurus))) && $search)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">Tidak ada guru yang ditemukan dengan kata kunci "{{ $search }}"</p>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="bg-white shadow-lg overflow-hidden sm:rounded-lg">
                    <ul role="list" class="divide-y divide-gray-200">
                        @forelse($gurus as $guru)
                            <li class="px-4 py-4 sm:px-6 hover:bg-gray-50 transition duration-150 ease-in-out">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <span class="text-base font-semibold text-indigo-600">{{ strtoupper(substr($guru->nama, 0, 2)) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-base font-semibold text-gray-900">{{ $guru->nama }}</div>
                                            <div class="text-sm text-gray-600">NIP: {{ $guru->nip }}</div>
                                            <div class="text-xs text-indigo-600 mt-1">{{ $guru->email ?? 'Email tidak tersedia' }}</div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col sm:flex-row sm:space-x-2">
                                        <button wire:click="edit({{ $guru->id }})" class="px-3 py-1.5 bg-indigo-500 text-white text-xs font-semibold rounded-md hover:bg-indigo-600 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75 shadow-sm">
                                            Detail
                                        </button>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="px-4 py-12 sm:px-6 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data guru</h3>
                                <p class="mt-1 text-sm text-gray-500">Belum ada data guru yang tersedia.</p>
                            </li>
                        @endforelse
                    </ul>
                    @if(is_object($gurus) && method_exists($gurus, 'links'))
                    <div class="px-4 py-4 bg-gray-50 border-t border-gray-200 sm:px-6">
                        {{ $gurus->links('livewire.pagination') }}
                    </div>
                    @endif
                </div>
                
                <!-- Modal for Guru Detail -->
                @if($showModal && $selectedGuru)
                <div class="fixed inset-0 overflow-hidden z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                        <h3 class="text-xl leading-6 font-semibold text-gray-900" id="modal-title">
                                            {{ $selectedGuru->nama }}
                                        </h3>
                                        <div class="mt-4 border-t border-gray-200 pt-4">
                                            <dl class="space-y-4">
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">NIP</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">{{ $selectedGuru->nip }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">{{ $selectedGuru->email ?? 'Belum ada data' }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">No. Telepon</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">{{ $selectedGuru->kontak ?? 'Belum ada data' }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                                                    <dd class="mt-1 text-sm text-gray-900">{{ $selectedGuru->alamat ?? 'Belum ada data' }}</dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="button" wire:click="closeModal" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Floating Action Button -->
        <div class="fixed bottom-6 right-6 flex flex-col space-y-3">
            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="p-3.5 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full shadow-xl hover:from-indigo-700 hover:to-purple-700 transition-all transform hover:scale-110 focus:outline-none group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white transform transition-transform group-hover:-translate-y-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                </svg>
            </button>
        </div>
    </x-app-layout>
    <style>
        body, html {
            overflow-y: auto;
        }
        ::-webkit-scrollbar {
            display: none;
        }
    </style>
</div>
