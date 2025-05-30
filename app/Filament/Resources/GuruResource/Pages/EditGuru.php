<?php

namespace App\Filament\Resources\GuruResource\Pages;

use App\Filament\Resources\GuruResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGuru extends EditRecord
{
    protected static string $resource = GuruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->action(function ($record) {
                // Check specifically for PKLs like in your bulk action
                if ($record->pkls()->count() > 0) {
                    \Filament\Notifications\Notification::make()
                        ->title('Gagal Menghapus')
                        ->body('Tidak dapat menghapus ' . $record->nama . '. Hapus data terkait terlebih dahulu.')
                        ->danger()
                        ->send();
                    return;
                }
                
                $record->delete();
                \Filament\Notifications\Notification::make()
                    ->title('Berhasil')
                    ->body('Data guru berhasil dihapus')
                    ->success()
                    ->send();
            })
            ->requiresConfirmation()
        ];
    }
}
