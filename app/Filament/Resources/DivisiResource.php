<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DivisiResource\Pages;
use App\Models\Divisi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class DivisiResource extends Resource
{
    protected static ?string $model = Divisi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Divisi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_divisi')
                    ->label('Nama Divisi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->maxLength(500),
                Forms\Components\TextInput::make('kuota')
                    ->label('Kuota')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->default(1),
            ]);
    }

    public static function getPluralLabel(): string
    {
        return 'Divisi';  
    }
    public static function shouldRegisterNavigation(): bool
    {
        // Pastikan hanya Super Admin yang dapat mengakses resource ini
        return Auth::user() && Auth::user()->role === 'super admin';
    }
    public static function getslug(): string
    {
        return 'divisi';  // Ubah ini ke label plural yang diinginkan
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_divisi')
                    ->label('Nama Divisi')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(50),
                Tables\Columns\TextColumn::make('kuota')
                    ->label('Kuota')
                    ->sortable(),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            // Tambahkan relasi jika diperlukan
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDivisis::route('/'),
        ];
    }
}
