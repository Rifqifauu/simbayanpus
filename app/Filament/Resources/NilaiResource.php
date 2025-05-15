<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NilaiResource\Pages;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class NilaiResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = 'Manajemen Magang';
    protected static ?string $navigationLabel = 'Nilai Magang';
    protected static ?string $slug = 'nilai';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
            Select::make('id_user')
    ->label('Peserta')
    ->options(function () {
        return User::whereHas('permohonan', function ($query) {
            $query->whereDate('tgl_keluar', '<', Carbon::now());
        })->pluck('name', 'id');
    })
    ->searchable()
    ->label('Peserta')
    ->required(),


                TextInput::make('rencana_kerja')
                    ->label('Rencana Kerja')
                    ->numeric()->minValue(0)->maxValue(100)->required(),

                TextInput::make('kehadiran')
                    ->numeric()->minValue(0)->maxValue(100)->required(),

                TextInput::make('disiplin_dan_etika')
                    ->label('Disiplin & Etika')
                    ->numeric()->minValue(0)->maxValue(100)->required(),

                TextInput::make('keaktifan_kreativitas')
                    ->label('Keaktifan & Kreativitas')
                    ->numeric()->minValue(0)->maxValue(100)->required(),

                TextInput::make('kecermatan')
                    ->numeric()->minValue(0)->maxValue(100)->required(),

                TextInput::make('tanggung_jawab')
                    ->label('Tanggung Jawab')
                    ->numeric()->minValue(0)->maxValue(100)->required(),

                TextInput::make('huruf_mutu')
                    ->label('Huruf Mutu')
                    ->maxLength(2)
                    ->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Nama Peserta')->searchable(),
                TextColumn::make('rencana_kerja')->sortable(),
                TextColumn::make('kehadiran')->sortable(),
                TextColumn::make('disiplin_dan_etika')->label('Disiplin')->sortable(),
                TextColumn::make('keaktifan_kreativitas')->label('Kreativitas')->sortable(),
                TextColumn::make('kecermatan')->sortable(),
                TextColumn::make('tanggung_jawab')->label('Tanggung Jawab')->sortable(),
                TextColumn::make('rata_rata')
                    ->label('Rerata')
                    ->getStateUsing(fn($record) => $record->rata_rata)
                    ->sortable(),

                TextColumn::make('huruf_mutu')->label('Huruf')->sortable(),
            ])
            ->defaultSort('id_user')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
public static function getNavigationSort(): ?int
{
    return 4; // Angka kecil tampil lebih atas
}
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNilais::route('/'),
            'edit' => Pages\EditNilai::route('/{record}/edit'),
        ];
    }
}
