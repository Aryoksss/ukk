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
            Actions\DeleteAction::make()
                ->action(function ($record) {
                    // Cek apakah siswa memiliki data PKL terkait
                    if ($record->pkl) {
                        // Batalkan penghapusan dengan pesan error
                        \Filament\Notifications\Notification::make()
                            ->title('Gagal Menghapus')
                            ->body('Tidak dapat menghapus ' . $record->nama . ' karena masih memiliki data PKL terkait. Hapus data PKL terlebih dahulu.')
                            ->danger()
                            ->send();
                        return;
                    }
                    $record->delete();
                    \Filament\Notifications\Notification::make()
                        ->title('Berhasil')
                        ->body('Data siswa berhasil dihapus')
                        ->success()
                        ->send();
                })->requiresConfirmation(),
            // Actions\Action::make('viewPkl')
            //     ->label('Lihat Data PKL')
            //     ->icon('heroicon-o-briefcase')
            //     ->color('info')
            //     ->url(fn () => $this->record->status_lapor_pkl == 'True' && $this->record->pkl 
            //         ? route('filament.admin.resources.pkls.edit', ['record' => $this->record->pkl->id])
            //         : '#')
            //     ->visible(fn () => $this->record->status_lapor_pkl == 'True' && $this->record->pkl),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
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
