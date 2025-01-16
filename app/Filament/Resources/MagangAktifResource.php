<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use App\Filament\Resources\MagangAktifResource\Pages;
use App\Filament\Resources\MagangAktifResource\RelationManagers;
use App\Models\UserDetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MagangAktifResource extends Resource
{
    protected static ?string $model = UserDetail::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Magang Aktif';
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
            $query->where('status_pendaftaran', 'diterima')->whereDate('tgl_keluar', '>=', Carbon::today())->whereDate('tgl_masuk','<=',Carbon::today());
        }))
        ->columns([
            Tables\Columns\TextColumn::make('user.name')
                ->label('Nama Lengkap')
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
        return 'Magang Aktif';
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMagangAktifs::route('/'),
            'create' => Pages\CreateMagangAktif::route('/create'),
            'view' => Pages\ViewMagangAktif::route('/{record}'),
            'edit' => Pages\EditMagangAktif::route('/{record}/edit'),
        ];
    }
}
