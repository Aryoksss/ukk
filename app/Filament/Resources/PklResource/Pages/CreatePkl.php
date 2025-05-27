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
    
    // Hide tombol "Tambah Industri Baru" yang tidak diperlukan
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $data;
    }
}
