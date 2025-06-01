<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuruResource\Pages;
use App\Models\Guru;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class GuruResource extends Resource
{
    protected static ?string $model = Guru::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    
    protected static ?string $navigationLabel = 'Guru';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                ->schema([

                    Forms\Components\Grid::make(2) // form dibagi jadi 2 kolom per baris
                        ->schema([
                            Forms\Components\TextInput::make('nama')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(2),
                            
                            Forms\Components\TextInput::make('nip')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255),
                            
                            Forms\Components\Select::make('gender')
                                ->options([
                                    'L' => 'Laki-laki',
                                    'P' => 'Perempuan',
                                ])
                                ->native(false)
                                ->required(),
                            
                            Forms\Components\TextInput::make('alamat')
                                ->maxLength(255),
                            
                            Forms\Components\TextInput::make('kontak')
                                ->maxLength(255),
                            
                            Forms\Components\TextInput::make('email')
                                ->email()
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255)
                                ->columnSpan(2),
                        ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                ->formatStateUsing(fn ($state) => DB::select("select getGenderCode(?) AS gender", [$state])[0]->gender)
                    ->searchable()
                    ->label('Jenis Kelamin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kontak')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
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
                    ->body(". $record->nama .  berhasil dihapus")
                    ->success()
                    ->send();
            })
            ->requiresConfirmation()
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                        foreach ($records as $record) {
                            if ($record->pkls()->count() > 0) {
                                \Filament\Notifications\Notification::make()
                                    ->title('Gagal Menghapus')
                                    ->body('Tidak dapat menghapus ' . $record->nama . '. Hapus data terkait terlebih dahulu.')
                                    ->danger()
                                    ->send();
                                return;
                            }
                        }
                        $records->each->delete();
                        \Filament\Notifications\Notification::make()
                            ->title('Berhasil')
                            ->body(" $record->nama .  berhasil dihapus")
                            ->success()
                            ->send();
                    })->requiresConfirmation()
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getNavigationGroup(): ?string
    {
        return 'Kelola PKL';
    }
    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
    public static function getNavigationBadge(): ?string
    {
        // Menghitung jumlah guru yang ada
        $count = Guru::count();
        
        // Menampilkan badge dengan jumlah guru
        return $count > 0 ? (string) $count : null;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGurus::route('/'),
            'create' => Pages\CreateGuru::route('/create'),
            'edit' => Pages\EditGuru::route('/{record}/edit'),
        ];
    }
}
