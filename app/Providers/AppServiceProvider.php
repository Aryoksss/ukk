<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Spatie\Permission\Events\RoleAssigned;
use App\Models\User;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gunakan pendekatan sederhana untuk URL
        if (app()->environment('local')) {
            URL::forceScheme('http');
        }
        
        // Set Carbon locale ke Indonesia
        Carbon::setLocale('id');
        
        // Mendengarkan event saat role diberikan kepada user
        Event::listen(function (RoleAssigned $event) {
            $user = $event->model;
            $role = $event->role;
            
            // Jika role yang diberikan adalah 'siswa'
            if ($role->name === 'siswa' && $user instanceof User) {
                // Cek apakah user sudah memiliki data siswa
                if (!$user->siswa) {
                    // Buat data siswa baru dengan menggunakan nama dan email dari user
                    Siswa::create([
                        'nama' => $user->name,
                        'email' => $user->email,
                        'user_id' => $user->id,
                        'status_lapor_pkl' => '0', // Nilai 0 untuk "Belum Melapor"
                    ]);
                }
            }
        });
    }
}
