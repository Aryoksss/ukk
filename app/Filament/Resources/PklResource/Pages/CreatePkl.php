<?php

namespace App\Filament\Resources\PklResource\Pages;

use App\Filament\Resources\PklResource;
use App\Models\Siswa;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;

class CreatePkl extends CreateRecord
{
    protected static string $resource = PklResource::class;
    
    // Override afterCreate to update siswa status
    protected function afterCreate(): void
    {
        // Get the created PKL record
        $record = $this->record;
        
        // Update siswa status to "Sudah Melapor"
        $updated = Siswa::where('id', $record->siswa_id)
            ->update(['status_lapor_pkl' => 'True']);
            
        if ($updated) {
            // Siswa ditemukan dan status berhasil diperbarui
            $siswa = Siswa::find($record->siswa_id);
            
            Notification::make()
                ->title('Status siswa berhasil diperbarui')
                ->body("Status {$siswa->nama} telah diubah menjadi 'Sudah Melapor PKL'")
                ->success()
                ->send();
        }
    }
    
    // Hide tombol "Tambah Industri Baru" yang tidak diperlukan
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $data;
    }
}
