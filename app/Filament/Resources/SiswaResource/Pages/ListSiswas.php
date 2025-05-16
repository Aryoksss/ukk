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
            Actions\Action::make('search')
                ->label('Cari')
                ->icon('heroicon-o-magnifying-glass')
                ->iconPosition(IconPosition::Before)
                ->form([
                    TextInput::make('search')
                        ->label('Cari Siswa')
                        ->placeholder('Masukkan nama, NIS, dll')
                        ->autoFocus()
                        ->autofocus(),
                ])
                ->action(function (array $data): void {
                    $this->tableFilters['tableSearch'] = $data['search'];
                    $this->resetTableFiltersForm();
                })
                ->color('gray')
                ->outlined(),
                
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
