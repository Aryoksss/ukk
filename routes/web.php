<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserHasRole;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Dashboard\DaftarIndustri;
use App\Livewire\Dashboard\Guru;
use App\Livewire\Dashboard\Siswa;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:admin|guru|siswa'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/dashboard/industri', DaftarIndustri::class)->name('industri');
    Route::get('/dashboard/siswa', Siswa::class)->name('siswa');
    Route::get('/dashboard/guru', Guru::class)->name('guru');
});

// Rute langsung untuk mengakses gambar
Route::get('/foto-siswa/{filename}', function ($filename) {
    $path = storage_path('public/img' . $filename);
    
    if (!file_exists($path)) {
        abort(404);
    }
    
    $file = file_get_contents($path);
    $type = mime_content_type($path);
    
    return response($file)
        ->header('Content-Type', $type)
        ->header('Cache-Control', 'public, max-age=86400');
})->where('filename', '.*')->name('foto-siswa');