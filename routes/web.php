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


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->get('/check-role-status', function () {
    return response()->json([
        'hasRole' => !Auth::user()->roles->isEmpty(),
    ]);
})->name('check-role-status');

// Rute untuk halaman menunggu persetujuan
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->get('/waiting-approval', function () {
    // Jika user sudah memiliki role, redirect ke dashboard
    if (Auth::check() && !Auth::user()->roles->isEmpty()) {
        return redirect()->route('dashboard');
    }
    
    return view('waiting-approval');
})->name('waiting-approval');

// Rute untuk dashboard dan halaman lain yang memerlukan role
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    CheckUserHasRole::class,
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/dashboard/industri', DaftarIndustri::class)->name('industri');
    Route::get('/dashboard/guru', Guru::class)->name('guru');
    Route::get('/dashboard/siswa', Siswa::class)->name('siswa');
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
