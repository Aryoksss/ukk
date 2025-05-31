<?php

namespace App\Filament\Resources\PklResource\Pages;

use App\Filament\Resources\PklResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\IconPosition;
use Filament\Forms\Components\TextInput;

class ListPkls extends ListRecords
{
    protected static string $resource = PklResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Data PKL')
                ->icon('heroicon-o-plus-circle')
                ->iconPosition(IconPosition::Before),
        ];
    }
    
    protected function getTableEmptyStateHeading(): ?string
    {
        return 'Belum ada data PKL';
    }
    
    protected function getTableEmptyStateDescription(): ?string
    {
        return 'Data PKL akan muncul disini saat siswa mendaftar PKL.';
    }
    
    protected function getTableEmptyStateIcon(): ?string
    {
        return 'heroicon-o-briefcase';
    }
}
