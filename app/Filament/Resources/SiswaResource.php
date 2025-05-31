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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    
    protected static ?string $navigationLabel = 'Siswa';

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
                    
                    Forms\Components\TextInput::make('nis')
                    ->label('NIS')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                    
                    Forms\Components\Select::make('rombel')
                    ->label('Rombel')
                    ->native(false)
                    ->options([
                        'A' => 'SIJA A',
                        'B' => 'SIJA B',
                    ])
                    ->required(),
                    
                    Forms\Components\Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->native(false)
                    ->options([
                        'L' => 'Laki-Laki',
                        'P' => 'Perempuan',
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
                    ->columnSpan(2),
                    
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
                    ->helperText('Format: JPG, PNG. Ukuran maks: 2MB. Rasio 1:1.')
                    ->columnSpan(2),
                ])
            ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nis')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rombel')
                    ->label('Rombel')
                    ->formatStateUsing(fn ($state) => DB::select("select getRombelCode(?) AS rombel", [$state])[0]->rombel)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender')
                    ->formatStateUsing(fn ($state) => DB::select("select getGenderCode(?) AS gender", [$state])[0]->gender)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('kontak')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status_lapor_pkl')
                    ->label('Status PKL')
                    ->formatStateUsing(fn ($state) => $state ? 'Aktif' : 'Tidak Aktif') 
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                    // ->description(fn ($record) => $record->pkl ? 'Di ' . $record->pkl?->industri?->nama : null),
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
               Tables\Filters\TernaryFilter::make('status_lapor_pkl') 
                    ->trueLabel('Aktif') 
                    ->falseLabel('Nonaktif'), 

                Filter::make('has_foto')
                    ->label('Status Foto')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('foto'))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->action(function ($record) {
                        static::deleteSiswa($record);
                    })
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    // collection $records: daftar semua baris (record) yang dipilih oleh user
                    // Filament mengirim data yang DIPILIH dalam bentuk Collection, bukan array biasa
                    ->action(function (\Illuminate\Support\Collection $records) {

                        // kan ini bulkAction ya, aksi massal, ini tu yang checkbox itu, jadi bisa multiple select
                        // makannya kita menggunakan Collection seperti di atas, kita bisa milih banyak
                        // $records: sebuah koleksi data (biasanya array atau Collection), misalnya semua siswa yang dipilih user di tabel
                        // as $record: setiap item tunggal dari koleksi tersebut akan ditampung ke variabel $record
                        foreach ($records as $record) {
                            // memanggil method deleteSiswa() untuk tiap data siswa yang dipilih
                            static::deleteSiswa($record);
                        }
                    }),
            ]);
    }

    // fungsi inilah yang dijalankan ketika tombol hapus diklik
    protected static function deleteSiswa($record) 
    {
        if ($record->pkl()->exists()) {
            \Filament\Notifications\Notification::make()
            // $record->pkl() = mengambil relasi pkl yang terkait dengan siswa tersebut (berdasarkan hasMany di model siswa)
            // ->exists() = Mengecek apakah ada data pkls yang masih menggunakan merk ini.
            // jika ada, pkl yang menggunakan siswa ini, penghapusan dibatalkan, dan muncul notifikasi error.
                ->title('Gagal menghapus ' . $record->nama . '!')
                ->body('Siswa ini masih digunakan dalam PKL. Hapus PKL terkait terlebih dahulu.')
                ->danger() // merah
                ->send();
            return;
        }

        // jika siswa tidak digunakan dalam PKL, maka datanya     akan dihapus
        $record->delete();

        \Filament\Notifications\Notification::make()
            ->title('Siswa dihapus!')
            ->body('Siswa berhasil dihapus.')
            ->success() // hijau
            ->send();
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
