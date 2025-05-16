<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesanResource\Pages;
use App\Filament\Resources\PesanResource\RelationManagers;
use App\Models\Pesan;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PesanResource extends Resource
{
    protected static ?string $model = Pesan::class;
    protected static ?string $navigationGroup = 'Konten Website';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('id_user')
                ->label('User Email')
                ->options(User::pluck('email', 'id')) // Ambil email sebagai label, ID sebagai value
                ->searchable() // Tambahkan fitur pencarian jika banyak data
                ->preload(), // Memuat opsi lebih cepat
            
            Forms\Components\Textarea::make('pesan')
                ->label('Pesan')
                ->maxLength(500),
    
            Forms\Components\Hidden::make('asal')
                ->default('admin'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
                Tables\Columns\TextColumn::make('asal')
        ->label('Tipe Pesan')
    ->badge()
    ->formatStateUsing(function ($state) {
        return $state === 'admin' ? 'Pesan Keluar' : 'Pesan Masuk';
    })
    ->color(function ($state) {
        return $state === 'admin' ? 'warning' : 'success'; // Warna badge: merah untuk keluar, hijau untuk masuk
    })
    ->searchable()
    ->sortable(),
 
                Tables\Columns\TextColumn::make('user.name')  // Akses nama pengguna melalui relasi 'user'
                ->label('Nama')
                ->searchable()
                ->sortable()
                ->wrap(),   
                Tables\Columns\TextColumn::make('user.email')  // Akses nama pengguna melalui relasi 'user'
                ->label('Email')
                ->searchable()
                ->sortable(),   
                Tables\Columns\TextColumn::make('pesan')  // Akses nama pengguna melalui relasi 'user'
                ->label('Pesan')
                ->searchable()
                ->sortable()
                ->wrap(),   
                Tables\Columns\TextColumn::make('created_at')  // Akses nama pengguna melalui relasi 'user'
                ->label('Tanggal')
                ->searchable()
                ->sortable()
                ->date('d M Y'),
                 
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Penghapusan')
                    ->modalDescription('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.')
                ,
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
            'index' => Pages\ListPesans::route('/'),
        ];
    }
}
