<?php

namespace App\Filament\Resources\IndustriResource\Pages;

use App\Filament\Resources\IndustriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIndustri extends EditRecord
{
    protected static string $resource = IndustriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->action(function ($record) {
                // Cek apakah industri memiliki data PKL terkait
                if ($record->pkls()->count() > 0) {
                // Batalkan penghapusan dengan pesan error yang user-friendly
                \Filament\Notifications\Notification::make()
                    ->title('Gagal Menghapus')
                    ->body('Tidak dapat menghapus ' . $record->nama . 'ini karena masih memiliki data PKL terkait. Hapus data PKL terlebih dahulu.')
                    ->danger()
                    ->send();
                return;
                }
                $record->delete();
                \Filament\Notifications\Notification::make()
                ->title('Berhasil')
                ->body('Data industri berhasil dihapus')
                ->success()
                ->send();
            })->requiresConfirmation(),
        ];
    }
}
