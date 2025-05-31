<?php

namespace App\Filament\Resources\IndustriResource\Pages;

use App\Filament\Resources\IndustriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\IconPosition;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Filament\Forms\Components\TextInput;

class ListIndustris extends ListRecords
{
    protected static string $resource = IndustriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Industri Baru')
                ->icon('heroicon-o-plus-circle')
                ->iconPosition(IconPosition::Before),
        ];
    }
    
    protected function getTableEmptyStateHeading(): ?string
    {
        return 'Belum ada data industri';
    }
    
    protected function getTableEmptyStateDescription(): ?string
    {
        return 'Data industri akan muncul disini saat Anda menambahkannya.';
    }
    
    protected function getTableEmptyStateIcon(): ?string
    {
        return 'heroicon-o-building-office';
    }
    
    protected function getTableRecordsPerPageSelectOptions(): array 
    {
        return [10, 25, 50, 100];
    }
    
    // Menambahkan opsi pencarian lebih lanjut
    public function getTableFilters(): array
    {
        return [
            Filter::make('search')
                ->form([
                    \Filament\Forms\Components\TextInput::make('nama')
                        ->label('Nama Industri')
                        ->placeholder('Cari berdasarkan nama'),
                    \Filament\Forms\Components\TextInput::make('bidang_usaha')
                        ->label('Bidang Usaha')
                        ->placeholder('Cari berdasarkan bidang usaha'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['nama'],
                            fn (Builder $query, $nama): Builder => 
                                $query->where('nama', 'like', "%{$nama}%")
                        )
                        ->when(
                            $data['bidang_usaha'],
                            fn (Builder $query, $bidangUsaha): Builder => 
                                $query->where('bidang_usaha', 'like', "%{$bidangUsaha}%")
                        );
                })
                ->indicateUsing(function (array $data): array {
                    $indicators = [];
                    
                    if ($data['nama'] ?? null) {
                        $indicators['nama'] = 'Nama: ' . $data['nama'];
                    }
                    
                    if ($data['bidang_usaha'] ?? null) {
                        $indicators['bidang_usaha'] = 'Bidang: ' . $data['bidang_usaha'];
                    }
                    
                    return $indicators;
                }),
            SelectFilter::make('guru_id')
                ->relationship('guru', 'nama')
                ->label('Guru Pembimbing')
                ->searchable()
                ->preload(),
        ];
    }
}
