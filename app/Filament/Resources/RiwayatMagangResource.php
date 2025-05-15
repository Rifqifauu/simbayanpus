<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RiwayatMagangResource\Pages;
use App\Filament\Resources\RiwayatMagangResource\RelationManagers;
use App\Models\UserDetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RiwayatMagangResource extends Resource
{
    protected static ?string $model = UserDetail::class;
    protected static ?string $navigationGroup = 'Data Magang';    
    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Riwayat Magang';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

public static function getPluralLabel(): ?string
{
    return 'Riwayat Peserta Magang';
}
    public static function table(Table $table): Table
    {    return $table
        ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('user.userDetail', function ($query) {
            $query->where('status_pendaftaran', 'selesai');
        }))
        ->columns([
            Tables\Columns\TextColumn::make('user.name')
                ->label('Nama')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('user.userDetail.institusi')
                ->label('Asal Institusi')
                ->sortable()
                ->searchable()
                    ->wrap(),

            Tables\Columns\TextColumn::make('user.permohonan.tgl_masuk')  // Mengakses tgl_masuk dari permohonan melalui relasi user
                ->label('Mulai Magang ')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('user.permohonan.tgl_keluar')  // Mengakses tgl_keluar dari permohonan melalui relasi user
                ->label('Selesai Magang')
                ->sortable()
                ->searchable()
        ])
            ->filters([
                //
            ])
            ->actions([
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }
    public static function getNavigationSort(): ?int
    {
        return 10;
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
            'index' => Pages\ListRiwayatMagangs::route('/'),
        ];
    }
}
