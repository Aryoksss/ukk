<div class="flex flex-col justify-center items-center">
    @if ($url)
        <img src="{{ $url }}" alt="{{ $alt ?? 'Foto Siswa' }}" class="max-w-full max-h-[60vh] rounded-lg shadow-lg">
        
        <!-- Tombol Alternatif -->
        <div class="mt-4">
            <a href="{{ route('foto-siswa', ['filename' => basename($path)]) }}" 
               target="_blank" 
               class="inline-flex items-center justify-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                Buka di Tab Baru
            </a>
        </div>
    @else
        <div class="p-8 text-center text-gray-500 bg-gray-100 rounded-lg">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="text-lg font-medium">Belum ada foto</p>
            <p class="text-sm mt-1">Silakan upload foto siswa melalui halaman edit</p>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const image = document.querySelector('img');
        if (image) {
            image.onerror = function() {
                console.error('Error loading image:', this.src);
                
                // Jika gambar tidak dapat dimuat, coba gunakan URL alternatif
                const filename = this.src.split('/').pop();
                const alternativeUrl = window.location.origin + '/foto-siswa/' + filename;
                
                console.log('Mencoba URL alternatif:', alternativeUrl);
                this.src = alternativeUrl;
            }
        }
    });
</script>
@endpush 