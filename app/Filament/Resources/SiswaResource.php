<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Filament\Resources\SiswaResource\RelationManagers;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Storage;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    
    protected static ?string $navigationLabel = 'Siswa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Akun User')
                    ->relationship(
                        name: 'user',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (\Illuminate\Database\Eloquent\Builder $query) => 
                            $query->whereDoesntHave('siswa', function ($query) use ($form) {
                                // Jangan tampilkan user yang sudah memiliki siswa kecuali user dari record yang sedang diedit
                                $query->where('id', '!=', $form->getRecord()?->id ?? 0);
                            })
                    )
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if (!empty($state)) {
                            $user = \App\Models\User::find($state);
                            if ($user) {
                                $set('nama', $user->name);
                                $set('email', $user->email);
                            }
                        } else {
                            $set('nama', null);
                            $set('email', null);
                        }
                    }),
                Forms\Components\Placeholder::make('user_info')
                    ->label('Info User')
                    ->content(fn ($get, $record) => $record && $record->user_id ? 'User terhubung dengan: ' . 
                        (\App\Models\User::find($record->user_id)->name ?? 'Tidak ditemukan') : 'Belum terhubung dengan user manapun')
                    ->visible(fn ($get) => $get('user_id') !== null)
                    ->hidden(true),
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Siswa')
                    ->required()
                    ->maxLength(255)
                    ->disabled(fn ($get) => $get('user_id') !== null)
                    ->dehydrated(true),
                Forms\Components\TextInput::make('nis')
                    ->label('NIS')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\Select::make('rombel')
                    ->label('Rombel')
                    ->options([
                        'SIJA A' => 'SIJA A',
                        'SIJA B' => 'SIJA B',
                    ])
                    ->required(),
                Forms\Components\Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-Laki' => 'Laki-Laki',
                        'Perempuan' => 'Perempuan',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('alamat')
                    ->label('Alamat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kontak')
                    ->label('Kontak')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->disabled(fn ($get) => $get('user_id') !== null)
                    ->dehydrated(true),
                Forms\Components\FileUpload::make('foto')
                    ->label('Foto Siswa')
                    ->image()
                    ->disk('public')
                    ->directory('images')
                    ->visibility('public')
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->imageResizeTargetWidth('300')
                    ->imageResizeTargetHeight('300')
                    ->imageEditor()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                    ->maxSize(2048)
                    ->helperText('Format: JPG, PNG. Ukuran maks: 2MB. Rasio 1:1.'),
                Forms\Components\Select::make('status_lapor_pkl')
                    ->label('Status Lapor PKL')
                    ->options([
                        'False' => 'Belum Melapor',
                        'True' => 'Sudah Melapor',
                    ])
                    ->default('False')
                    ->disabled(fn ($record) => $record && $record->pkl !== null)
                    ->dehydrated(true)
                    ->afterStateHydrated(function ($component, $state, $record) {
                        // Otomatis ubah status menjadi 'True' jika siswa memiliki data PKL
                        if ($record && $record->pkl !== null) {
                            $component->state('True');
                            
                            // Update database jika berbeda
                            if ($record->status_lapor_pkl !== 'True') {
                                $record->status_lapor_pkl = 'True';
                                $record->save();
                            }
                        }
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular()
                    ->height(40)
                    ->width(40)
                    ->getStateUsing(function ($record) {
                        // Jika foto ada, gunakan rute foto-siswa
                        if ($record && $record->foto) {
                            return route('foto-siswa', ['filename' => basename($record->foto)]);
                        }
                        return null;
                    })
                    ->defaultImageUrl(function () {
                        // Gunakan salah satu gambar yang sudah ada
                        return url('images/01JV54444HP2KCAWFPWNQSE9KP.jpg');
                    })
                    ->extraCellAttributes(['class' => 'flex justify-center'])
                    ->extraImgAttributes(['class' => 'object-cover rounded-full hover:scale-150 transition-transform duration-300'])
                    ->action(function ($record) {
                        if (!$record->foto) {
                            // Jika tidak ada foto
                            return;
                        }
                        
                        // Ekstrak filename dari path lengkap
                        $filename = basename($record->foto);
                        
                        // Gunakan rute khusus foto-siswa
                        $publicPath = route('foto-siswa', ['filename' => $filename]);
                        
                        // Tampilkan foto dalam modal
                        Tables\Actions\Action::make('view-image')
                            ->modalHeading('Foto ' . $record->nama)
                            ->modalContent(
                                view('filament.components.view-image', [
                                    'url' => $publicPath,
                                    'alt' => $record->nama,
                                    'path' => $record->foto,
                                ])
                            )
                            ->modalWidth('md')
                            ->modalAlignment('center')
                            ->openModal();
                    }),
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nis')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Akun User')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->badge()
                    ->color('success')
                    ->default('Tidak ada'),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('kontak')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_lapor_pkl')
                    ->label('Status PKL')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'True' => 'Sudah Melapor',
                        'False' => 'Belum Melapor',
                        default => 'Belum Diatur',
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'True' => 'success',
                        'False' => 'danger',
                        default => 'warning',
                    })
                    ->description(fn ($record) => $record->pkl ? 'Di ' . $record->pkl?->industri?->nama : null),
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
                SelectFilter::make('status_lapor_pkl')
                    ->label('Status Lapor PKL')
                    ->options([
                        'True' => 'Sudah Melapor',
                        'False' => 'Belum Melapor',
                    ]),
                Filter::make('has_foto')
                    ->label('Status Foto')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('foto'))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
