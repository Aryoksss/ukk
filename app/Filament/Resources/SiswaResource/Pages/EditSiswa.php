<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use Filament\Actions;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Hash;

class EditSiswa extends EditRecord
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('viewPkl')
                ->label('Lihat Data PKL')
                ->icon('heroicon-o-briefcase')
                ->color('info')
                ->url(fn () => $this->record->status_lapor_pkl == 'True' && $this->record->pkl 
                    ? route('filament.admin.resources.pkls.edit', ['record' => $this->record->pkl->id])
                    : '#')
                ->visible(fn () => $this->record->status_lapor_pkl == 'True' && $this->record->pkl),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
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
    
    protected function afterSave(): void
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
    
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi PKL')
                    ->description('Detail tempat PKL siswa')
                    ->schema([
                        TextEntry::make('status_lapor_pkl')
                            ->label('Status Lapor PKL')
                            ->formatStateUsing(fn ($state) => $state == 'True' ? 'Sudah Melapor' : 'Belum Melapor')
                            ->badge()
                            ->color(fn ($state) => $state == 'True' ? Color::Green : Color::Red),
                        TextEntry::make('pkl.industri.nama')
                            ->label('Tempat PKL')
                            ->placeholder('Belum terdaftar di tempat PKL'),
                        TextEntry::make('pkl.industri.guru.nama')
                            ->label('Guru Pembimbing')
                            ->placeholder('Belum ada guru pembimbing'),
                        TextEntry::make('pkl.mulai')
                            ->label('Tanggal Mulai PKL')
                            ->date()
                            ->placeholder('Belum terdaftar'),
                        TextEntry::make('pkl.selesai')
                            ->label('Tanggal Selesai PKL')
                            ->date()
                            ->placeholder('Belum terdaftar'),
                    ])
                    ->hidden(fn ($record) => $record->status_lapor_pkl == 'False'),
            ]);
    }
}
