<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Spatie\Permission\Events\RoleAssigned;
use App\Models\User;
use App\Models\Siswa;
use Spatie\Permission\Models\Role;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        // Mendengarkan event saat user baru mendaftar
        Event::listen(Registered::class, function ($event) {
            $user = $event->user;
            
            // Cari role siswa
            $siswaRole = Role::where('name', 'siswa')->first();
            
            if ($siswaRole) {
                // Berikan role siswa ke user baru
                $user->assignRole($siswaRole);
                
                // Data siswa akan otomatis dibuat melalui event RoleAssigned
            }
        });
        
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
    
    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
} 