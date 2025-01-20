<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermohonanResource\Pages;
use App\Models\Permohonan;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;

class PermohonanResource extends Resource
{
    protected static ?string $model = Permohonan::class;
protected static ?string $navigationGroup = 'Permohonan';
protected static ?string $navigationIcon = 'heroicon-o-document';
protected static ?string $navigationLabel = 'Masuk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
              
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('user.userDetail', function ($query) {
                $query->where('status_pendaftaran', 'pending');
            }))
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('divisi')
                    ->label('Divisi')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('tgl_masuk')
                    ->label('Tanggal Masuk')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('tgl_keluar')
                    ->label('Tanggal Keluar')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->sortable()
                    ->dateTime(),
            ])
            ->actions([
                Action::make('prosesPendaftaran')
                    ->label('Proses Pendaftaran')
                    ->action(function ($record) {
                        $userDetail = $record->user->userDetail;
                        if ($userDetail) {
                            $userDetail->status_pendaftaran = 'diproses';
                            $userDetail->save();
                        }
                    })
                    ->icon('heroicon-o-pencil')
                    ->color('success'),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermohonans::route('/'),
            'create' => Pages\CreatePermohonan::route('/create'),
            'edit' => Pages\EditPermohonan::route('/{record}/edit'),
        ];
    }
}