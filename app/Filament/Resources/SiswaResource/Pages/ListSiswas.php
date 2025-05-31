<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\IconPosition;
use Filament\Forms\Components\TextInput;

class ListSiswas extends ListRecords
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Siswa Baru')
                ->icon('heroicon-o-plus-circle')
                ->iconPosition(IconPosition::Before),
        ];
    }
    
    protected function getTableEmptyStateHeading(): ?string
    {
        return 'Belum ada data siswa';
    }
    
    protected function getTableEmptyStateDescription(): ?string
    {
        return 'Data siswa akan muncul disini saat Anda menambahkannya.';
    }
    
    protected function getTableEmptyStateIcon(): ?string
    {
        return 'heroicon-o-user-group';
    }
}
