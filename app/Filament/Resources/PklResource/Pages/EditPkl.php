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
    
    // Make sure the siswa's status_lapor_pkl stays as 'True' (Sudah Melapor) after editing a PKL record.
    protected function afterSave(): void
    {
        // Make sure siswa status is "Sudah Melapor"
        $updated = Siswa::where('id', $this->record->siswa_id)
            ->update(['status_lapor_pkl' => 'True']);
            
        // Jika siswa telah diperbarui dan sebelumnya belum melapor
        $siswa = Siswa::find($this->record->siswa_id);
        if ($siswa) {
            Notification::make()
                ->title('Status siswa tetap "Sudah Melapor"')
                ->body("Status {$siswa->nama} dipertahankan sebagai 'Sudah Melapor PKL'")
                ->success()
                ->send();
        }
    }
    
    // Override form untuk menampilkan siswa yang sudah dipilih dan yang belum melapor PKL
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Data diisi dengan nilai yang ada di database
        $pkl = $this->record;
        
        // Cek industri ID dan isi guru_info jika ada
        if ($pkl->industri && $pkl->industri->guru) {
            $data['guru_info'] = $pkl->industri->guru->nama;
        } else {
            $data['guru_info'] = 'Belum ada guru pembimbing';
        }
        
        return $data;
    }
    
    // Ensure siswa_id is preserved when saving
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Ensure siswa_id is preserved from the record
        if (!isset($data['siswa_id'])) {
            $data['siswa_id'] = $this->record->siswa_id;
        }
        
        return $data;
    }
}
