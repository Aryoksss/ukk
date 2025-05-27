<?php

namespace App\Filament\Resources\PklResource\Pages;

use App\Filament\Resources\PklResource;
use App\Models\Siswa;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditPkl extends EditRecord
{
    protected static string $resource = PklResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->after(function($record) {
                    // Saat PKL dihapus, ubah status siswa menjadi Belum Melapor
                    Siswa::where('id', $record->siswa_id)
                        ->update(['status_lapor_pkl' => 'False']);
                    
                    $siswa = Siswa::find($record->siswa_id);
                    if ($siswa) {
                        Notification::make()
                            ->title('Status siswa diperbarui')
                            ->body("Status {$siswa->nama} telah diubah menjadi 'Belum Melapor PKL'")
                            ->success()
                            ->send();
                    }
                }),
        ];
    }
}
