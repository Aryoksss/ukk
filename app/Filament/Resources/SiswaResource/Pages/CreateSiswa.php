<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CreateSiswa extends CreateRecord
{
    protected static string $resource = SiswaResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    // Pastikan status_lapor_pkl tidak null sebelum create
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Jika status_lapor_pkl null, set ke default '0'
        if (!isset($data['status_lapor_pkl']) || $data['status_lapor_pkl'] === null) {
            $data['status_lapor_pkl'] = 'False';
        }
        
        // Pastikan email siswa sama dengan email user jika user_id ada
        if (isset($data['user_id']) && $data['user_id']) {
            // Cari user yang dipilih
            $user = \App\Models\User::find($data['user_id']);
            
            if ($user) {
                // Update nama dan email siswa dari user jika belum diisi
                if (empty($data['nama'])) {
                    $data['nama'] = $user->name;
                }
                
                if (empty($data['email'])) {
                    $data['email'] = $user->email;
                }
                
                // Pastikan user memiliki role 'siswa'
                if (!$user->hasRole('siswa')) {
                    $user->assignRole('siswa');
                }
            }
        }
        
        return $data;
    }
    
    protected function afterCreate(): void
    {
        $siswa = $this->record;
        
        // Jika user_id tidak ada, tapi kita punya email, coba cari atau buat user baru
        if (!$siswa->user_id && $siswa->email) {
            // Cari user dengan email yang sama
            $user = \App\Models\User::where('email', $siswa->email)->first();
            
            if (!$user) {
                // Buat user baru dengan password random yang aman
                $user = \App\Models\User::create([
                    'name' => $siswa->nama,
                    'email' => $siswa->email,
                    'password' => Hash::make(str_replace(['-', ' '], '', $siswa->nis)), // Gunakan NIS sebagai password awal
                ]);
                
                // Assign siswa role
                $user->assignRole('siswa');
            }
            
            // Hubungkan user ke siswa
            $siswa->user_id = $user->id;
            $siswa->save();
        }
    }
}
