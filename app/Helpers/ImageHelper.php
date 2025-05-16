<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Menghasilkan URL dengan port yang benar untuk gambar yang disimpan di disk public
     *
     * @param string|null $path Path relatif ke file dalam disk storage/app/public
     * @return string|null URL lengkap dengan port yang benar, atau null jika path kosong
     */
    public static function getImageUrl(?string $path): ?string
    {
        if (empty($path)) {
            return null;
        }
        
        // Gunakan route khusus untuk melayani gambar
        return route('foto-siswa', ['filename' => basename($path)]);
    }
    
    /**
     * Menghasilkan URL default untuk gambar yang tidak ada
     *
     * @return string URL gambar default
     */
    public static function getDefaultImageUrl(): string
    {
        return url('images/default-user.png');
    }
} 