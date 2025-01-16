<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use App\Filament\Resources\MagangSelesaiResource\Pages;
use App\Filament\Resources\MagangSelesaiResource\RelationManagers;
use App\Models\UserDetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MagangSelesaiResource extends Resource
{
    protected static ?string $model = UserDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Magang Selesai';
    protected static ?string $navigationGroup = 'Data Magang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('user.Permohonan', function ($query) {
            $query->where('status_pendaftaran', 'diterima')->whereDate('tgl_keluar', '<=', Carbon::today());
        }))
        ->columns([
            Tables\Columns\TextColumn::make('user.name')
                ->label('User')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('user.userDetail.institusi')
                ->label('Asal Institusi')
                ->sortable()
                ->searchable(),

            // Tables\Columns\TextColumn::make('user.permohonan.divisi')  // Mengakses divisi dari permohonan melalui relasi user
            //     ->label('Divisi')
            //     ->sortable()
            //     ->searchable(),

            Tables\Columns\TextColumn::make('user.permohonan.tgl_masuk')  // Mengakses tgl_masuk dari permohonan melalui relasi user
                ->label('Tanggal Masuk')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('user.permohonan.tgl_keluar')  // Mengakses tgl_keluar dari permohonan melalui relasi user
                ->label('Tanggal Keluar')
                ->sortable()
                ->searchable(),

            Tables\Columns\ImageColumn::make('foto')
                  ->height(100)
                  ->width(80)
                , // Menyediakan URL lengkap
        ])
        ->actions([ /* Your actions */ ])
        ->bulkActions([ /* Your bulk actions */ ]);
}

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPluralLabel(): ?string
    {
        return 'Magang Selesai';
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMagangSelesais::route('/'),
            'create' => Pages\CreateMagangSelesai::route('/create'),
            'view' => Pages\ViewMagangSelesai::route('/{record}'),
            'edit' => Pages\EditMagangSelesai::route('/{record}/edit'),
        ];
    }
}
