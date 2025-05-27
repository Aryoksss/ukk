<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IndustriResource\Pages;
use App\Filament\Resources\IndustriResource\RelationManagers;
use App\Models\Industri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IndustriResource extends Resource
{
    protected static ?string $model = Industri::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    
    protected static ?string $navigationLabel = 'Industri';
    
    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Industri')
                    ->description('Detail industri tempat PKL')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('bidang_usaha')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('alamat')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('kontak')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('website')
                            ->maxLength(255)
                            ->helperText('Contoh: example.com'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(10)
            ->searchable()
            ->persistSearchInSession()
            ->searchDebounce(500)
            ->searchPlaceholder('Cari industri...')
            ->deferLoading()
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bidang_usaha')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kontak')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('website')
                    ->url(fn (Industri $record): string => $record->website ? "https://{$record->website}" : '#')
                    ->openUrlInNewTab()
                    ->label('Website'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Data Industri')
                    ->modalDescription('Apakah Anda yakin ingin menghapus data industri ini? Data yang sudah dihapus tidak dapat dikembalikan.')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->modalCancelActionLabel('Batal')
                    ->successNotificationTitle('Data industri berhasil dihapus')
                    ->before(function ($record) {
                        // Cek apakah industri memiliki data PKL
                        if ($record->pkls()->count() > 0) {
                            // Batalkan penghapusan dengan pesan error yang user-friendly
                            $this->halt('Tidak dapat menghapus industri ini karena masih memiliki data PKL terkait. Hapus data PKL terlebih dahulu.');
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Data Industri')
                        ->modalDescription('Apakah Anda yakin ingin menghapus semua data industri yang dipilih? Data yang sudah dihapus tidak dapat dikembalikan.')
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->modalCancelActionLabel('Batal')
                        ->successNotificationTitle('Data industri berhasil dihapus')
                        ->before(function ($records) {
                            // Cek setiap industri apakah memiliki data PKL
                            foreach ($records as $record) {
                                if ($record->pkls()->count() > 0) {
                                    // Batalkan penghapusan dengan pesan error yang user-friendly
                                    $this->halt('Tidak dapat menghapus beberapa industri karena masih memiliki data PKL terkait. Hapus data PKL terlebih dahulu.');
                                }
                            }
                        }),
                ]),
            ])
            ->defaultSort('nama')
            ->persistFiltersInSession()
            ->searchable();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['nama', 'bidang_usaha', 'alamat', 'email'];
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIndustris::route('/'),
            'create' => Pages\CreateIndustri::route('/create'),
            'edit' => Pages\EditIndustri::route('/{record}/edit'),
        ];
    }
}
