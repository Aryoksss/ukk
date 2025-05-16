<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PklResource\Pages;
use App\Models\Pkl;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Validation\Rule;

class PklResource extends Resource
{
    protected static ?string $model = Pkl::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    
    protected static ?string $navigationLabel = 'PKL';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Display siswa info in edit mode
                Forms\Components\Placeholder::make('siswa_display')
                    ->label('Siswa')
                    ->content(fn ($livewire) => $livewire instanceof Pages\EditPkl 
                        ? $livewire->getRecord()->siswa->nama
                        : '')
                    ->visible(fn ($livewire) => $livewire instanceof Pages\EditPkl),
                
                Forms\Components\Select::make('siswa_id')
                    ->relationship(
                        'siswa', 
                        'nama',
                        fn ($query) => $query->where('status_lapor_pkl', 'False') // Hanya tampilkan siswa yang belum melapor PKL
                            ->orWhereHas('pkl', fn ($q) => $q->where('id', request()->route('record')))
                    )
                    ->searchable()
                    ->preload()
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->label('Pilih Siswa')
                    ->helperText('Hanya menampilkan siswa yang belum melapor PKL atau siswa pada PKL ini')
                    ->afterStateUpdated(fn (Forms\Set $set) => $set('siswa_info', null))
                    ->hidden(fn ($livewire) => $livewire instanceof Pages\EditPkl),
                    
                Forms\Components\Placeholder::make('siswa_info')
                    ->label('Status Siswa')
                    ->hidden(fn (Forms\Get $get, $livewire) => !$get('siswa_id') && !($livewire instanceof Pages\EditPkl))
                    ->content(function (Forms\Get $get, $livewire): string {
                        // Jika dalam mode edit, ambil siswa dari record
                        if ($livewire instanceof Pages\EditPkl) {
                            $siswa = $livewire->getRecord()->siswa;
                            if ($siswa) {
                                return $siswa->status_lapor_pkl === 'True' 
                                    ? 'Siswa ini sudah tercatat mengikuti PKL. Status akan tetap dipertahankan.'
                                    : 'Status siswa akan otomatis diubah menjadi "Sudah Melapor PKL" saat data disimpan.';
                            }
                        }
                        
                        // Mode create
                        $siswaId = $get('siswa_id');
                        if (!$siswaId) return 'Pilih siswa terlebih dahulu';
                        
                        $siswa = \App\Models\Siswa::find($siswaId);
                        if (!$siswa) return 'Siswa tidak ditemukan';
                        
                        // Status akan diperbarui otomatis saat PKL disimpan
                        if ($siswa->status_lapor_pkl === 'True') {
                            return 'Siswa ini sudah tercatat mengikuti PKL. Status akan tetap dipertahankan.';
                        } else {
                            return 'Status siswa akan otomatis diubah menjadi "Sudah Melapor PKL" saat data disimpan.';
                        }
                    }),
                Forms\Components\Select::make('industri_id')
                    ->relationship('industri', 'nama')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Pilih Industri')
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                        if ($state) {
                            $industri = \App\Models\Industri::with('guru')->find($state);
                            if ($industri && $industri->guru) {
                                $set('guru_info', $industri->guru->nama);
                            } else {
                                $set('guru_info', 'Belum ada guru pembimbing');
                            }
                        }
                    }),
                    
                Forms\Components\Placeholder::make('guru_info')
                    ->label('Guru Pembimbing')
                    ->content(function (Forms\Get $get, ?string $state): string {
                        if (!empty($state)) {
                            return $state;
                        }
                        
                        $industriId = $get('industri_id');
                        if (!$industriId) {
                            return 'Pilih industri terlebih dahulu';
                        }
                        
                        $industri = \App\Models\Industri::with('guru')->find($industriId);
                        if (!$industri) {
                            return 'Industri tidak ditemukan';
                        }
                        
                        if ($industri->guru) {
                            return $industri->guru->nama;
                        }
                        
                        return 'Belum ada guru pembimbing untuk industri ini';
                    }),
                Forms\Components\DatePicker::make('mulai')
                    ->label('Tanggal Mulai PKL')
                    ->required(),
                Forms\Components\DatePicker::make('selesai')
                    ->label('Tanggal Selesai PKL')
                    ->required()
                    ->afterOrEqual('mulai')
                    ->minDate(fn (Forms\Get $get) => $get('mulai')),
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
            ->searchPlaceholder('Cari data PKL...')
            ->deferLoading()
            ->columns([
                Tables\Columns\TextColumn::make('siswa.nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('siswa.nis')
                    ->label('NIS')
                    ->searchable(),
                Tables\Columns\TextColumn::make('industri.nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('industri.guru.nama')
                    ->label('Guru Pembimbing')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mulai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('selesai')
                    ->date()
                    ->sortable(),
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
                SelectFilter::make('industri')
                    ->relationship('industri', 'nama')
                    ->label('Filter berdasarkan industri')
                    ->indicator('Industri')
                    ->preload()
                    ->searchable(),
                Filter::make('mulai')
                    ->form([
                        Forms\Components\DatePicker::make('mulai_dari')
                            ->label('Mulai Dari'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when(
                            $data['mulai_dari'],
                            fn ($query) => $query->whereDate('mulai', '>=', $data['mulai_dari']),
                        );
                    }),
                Filter::make('selesai')
                    ->form([
                        Forms\Components\DatePicker::make('selesai_sebelum')
                            ->label('Selesai Sebelum'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when(
                            $data['selesai_sebelum'],
                            fn ($query) => $query->whereDate('selesai', '<=', $data['selesai_sebelum']),
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->after(function($record) {
                        // Saat PKL dihapus, ubah status siswa menjadi Belum Melapor
                        Siswa::where('id', $record->siswa_id)
                            ->update(['status_lapor_pkl' => 'False']);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function($records) {
                            // Saat beberapa PKL dihapus, ubah status semua siswa terkait menjadi Belum Melapor
                            foreach ($records as $record) {
                                Siswa::where('id', $record->siswa_id)
                                    ->update(['status_lapor_pkl' => 'False']);
                            }
                        }),
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
            'index' => Pages\ListPkls::route('/'),
            'create' => Pages\CreatePkl::route('/create'),
            'edit' => Pages\EditPkl::route('/{record}/edit'),
        ];
    }
}
