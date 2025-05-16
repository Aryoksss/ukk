<?php

namespace App;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class PreregisteredUserValidator
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Validasi untuk pendaftaran user.
     * Tidak lagi memeriksa apakah email sudah terdaftar di admin.
     *
     * @param  array  $input
     * @return void
     */
    public static function validate(array $input): void
    {
        // Tidak ada validasi khusus, semua user diizinkan mendaftar
        // Admin akan memberikan role setelah user mendaftar
    }
}
