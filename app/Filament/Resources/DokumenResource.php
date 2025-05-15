<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DokumenResource\Pages;
use App\Filament\Resources\DokumenResource\RelationManagers;
use App\Models\Dokumen;
use Filament\Forms;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DokumenResource extends Resource
{
    protected static ?string $model = Dokumen::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Manajemen Magang';
    protected static ?string $navigationLabel = 'Penerbitan Surat';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Select::make('id_user')
                ->label('Nama Pengguna')
                ->relationship('user', 'name') // relasi dengan model User dan kolom 'name'
                ->searchable()
                ->preload()
                ->required(),
    
            Forms\Components\Select::make('keterangan')
                ->label('Keterangan')
                ->options([
                    'diterima' => 'Diterima',
                    'selesai' => 'Selesai',
                ])
                ->searchable()
                ->preload()
                ->required(),
    
            Forms\Components\FileUpload::make('dokumen')
                ->disk('public')
                ->directory('')
                ->visibility('public')
                ->required(),
        ]);
    }
    public static function getNavigationSort(): ?int
{
    return 1; // Angka kecil tampil lebih atas
}
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                ->label('Nama Lengkap')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                ->label('Email')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('keterangan')
                ->label('Keterangan')
                ->formatStateUsing(function ($record) {
                    return $record->keterangan;
                })
                ->sortable()
                ->searchable(),            
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Penghapusan')
                    ->modalDescription('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.')
                    ->after(function ($record) {
                        activity()
                            ->causedBy(auth()->user()) // User yang melakukan
                            ->performedOn($record) // Data yang dihapus
                            ->event('deleted') // Event yang terjadi
                            ->log('User ' . auth()->user()->name . ' menghapus dokumen milik ' . $record->user->name);
                    }),
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
            'index' => Pages\ListDokumens::route('/'),
        ];
    }
}
