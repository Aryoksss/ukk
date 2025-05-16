<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menunggu Persetujuan') }}
        </h2>
    </x-slot>

    @if(!Auth::user()->roles->isEmpty())
    <script>
        // Redirect otomatis ke dashboard jika user sudah memiliki role
        window.location.href = "{{ route('dashboard') }}";
    </script>
    @endif

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- Header dengan ilustrasi -->
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-3xl font-bold mb-2">Menunggu Persetujuan</h2>
                            <p class="text-blue-100">Akun Anda sedang dalam proses verifikasi</p>
                        </div>
                        <div class="hidden md:block">
                            <svg class="w-24 h-24 text-white opacity-75" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 100-16 8 8 0 000 16zm1-8h4v2h-6V7h2v5z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Status card -->
                <div class="p-6">
                    <div class="flex items-center p-4 mb-6 bg-yellow-50 border-l-4 border-yellow-400 rounded-r-md">
                        <svg class="h-6 w-6 text-yellow-400 mr-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-yellow-700">
                            Akun Anda telah berhasil terdaftar dan sedang menunggu persetujuan administrator.
                        </p>
                    </div>
                    
                    <!-- Progress indicator -->
                    <div class="mb-8">
                        <div class="flex justify-between mb-2">
                            <div class="text-sm font-medium text-green-600">Pendaftaran</div>
                            <div class="text-sm font-medium text-blue-600">Persetujuan</div>
                            <div class="text-sm font-medium text-gray-400">Akses Penuh</div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 50%"></div>
                        </div>
                    </div>
                    
                    <!-- Informasi akun -->
                    <div class="bg-gray-50 rounded-xl p-6 mb-6 border border-gray-200">
                        <h3 class="text-lg font-semibold mb-4 text-gray-700 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Informasi Akun
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="flex items-center p-3 bg-white rounded-lg shadow-sm">
                                <div class="bg-blue-100 p-2 rounded-md mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 font-medium">Nama</div>
                                    <div class="font-semibold">{{ Auth::user()->name }}</div>
                                </div>
                            </div>
                            <div class="flex items-center p-3 bg-white rounded-lg shadow-sm">
                                <div class="bg-blue-100 p-2 rounded-md mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 font-medium">Email</div>
                                    <div class="font-semibold">{{ Auth::user()->email }}</div>
                                </div>
                            </div>
                            <div class="flex items-center p-3 bg-white rounded-lg shadow-sm md:col-span-2">
                                <div class="bg-yellow-100 p-2 rounded-md mr-3">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 font-medium">Status</div>
                                    <div class="font-semibold text-yellow-600">Menunggu pemberian peran</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Loading indicator -->
                    <div class="flex flex-col items-center justify-center py-4">
                        <div class="mb-4 text-center">
                            <div class="inline-block relative">
                                <div class="w-12 h-12 rounded-full border-4 border-blue-200"></div>
                                <div class="w-12 h-12 rounded-full border-t-4 border-blue-600 animate-spin absolute top-0 left-0"></div>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm">
                            Memeriksa status persetujuan setiap <span id="countdown" class="font-bold text-blue-600">15</span> detik
                        </p>
                    </div>
                    
                    <!-- Tips -->
                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-700 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Informasi Tambahan
                        </h3>
                        <ul class="space-y-2 text-gray-600">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Anda masih dapat mengakses pengaturan profil untuk mengubah informasi pribadi atau foto profil.
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Halaman akan otomatis diperbarui ketika akun Anda disetujui.
                            </li>
                        </ul>
                        <p class="mt-4 text-gray-500 text-sm italic">
                            Silakan hubungi administrator jika Anda memiliki pertanyaan atau memerlukan bantuan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto cek status role menggunakan AJAX
        let countdown = 15; // Lebih cepat dengan AJAX
        const countdownElement = document.getElementById('countdown');
        
        function checkRoleStatus() {
            fetch('{{ route("check-role-status") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.hasRole) {
                        // User sudah mendapatkan role, redirect ke dashboard
                        window.location.href = "{{ route('dashboard') }}";
                    }
                })
                .catch(error => {
                    console.error('Error checking role status:', error);
                });
        }
        
        function updateCountdown() {
            countdown--;
            countdownElement.textContent = countdown;
            
            if (countdown <= 0) {
                // Reset countdown dan cek status
                countdown = 15;
                countdownElement.textContent = countdown;
                checkRoleStatus();
            }
            
            setTimeout(updateCountdown, 1000);
        }
        
        // Mulai countdown
        setTimeout(updateCountdown, 1000);
        
        // Cek status pertama kali
        checkRoleStatus();
    </script>
</x-app-layout>
