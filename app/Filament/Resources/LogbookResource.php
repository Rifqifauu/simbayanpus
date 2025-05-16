<?php

namespace App\Filament\Resources;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;


use App\Filament\Resources\LogbookResource\Pages;
use App\Filament\Resources\LogbookResource\RelationManagers;
use App\Models\Logbook;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LogbookResource extends Resource
{
    protected static ?string $model = Logbook::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Manajemen Magang';

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
          ->columns([
                Tables\Columns\TextColumn::make('user.name')
                ->label('Nama')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('tanggal')
                ->label('Tanggal')
                 ->date('d M Y')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('aktivitas')
                ->label('Aktivitas')
                ->sortable()
                ->searchable()
                  ->wrap(),
                Tables\Columns\TextColumn::make('verifikasi')
                ->label('Verifikasi')
                ->sortable()
                ->searchable()
                ->badge()
                ->color(function ($state) {
        return $state === 'disetujui' ? 'success' : 'danger';}),
                Tables\Columns\TextColumn::make('catatan_pembimbing')
                ->label('Catatan Pembimbing')
                ->sortable()
                ->searchable()
                  ->wrap(),
            ])
            ->filters([
         Tables\Filters\SelectFilter::make('id_user')
        ->label('Nama User')
        ->options(
             \App\Models\User::all()->pluck('name', 'id')->toArray()
        ),
        ])
        ->actions([
        Action::make('verifikasi')
        ->form([
                Select::make('verifikasi')
                ->label('Status Verifikasi')
                ->options([
                    'disetujui' => 'Disetujui',
                    'ditolak' => 'Ditolak',
                ])
                ->required(),
                Forms\Components\Textarea::make('catatan_pembimbing')
                ->label('Catatan Pembimbing')
                ->maxLength(500),
        ])
        ->action(function ($record, array $data) {
            $record->verifikasi = $data['verifikasi'];
            $record->catatan_pembimbing = $data['catatan_pembimbing'];
            $record->save();
            activity()
                ->causedBy(auth()->user())
                ->performedOn($record)
                ->event('proses')
                ->log('User ' . auth()->user()->name . ' menyatakan logbook milik ' . $record->user->name . ' telah ' . $data['verifikasi']);
        })
        ->color('warning')
        ->button()
        ->visible(fn ($record) => $record->verifikasi === 'pending')
        ->requiresConfirmation(),
])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
public static function getNavigationSort(): ?int
{
    return 2; // Angka kecil tampil lebih atas
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
            'index' => Pages\ListLogbooks::route('/'),
        ];
    }
}
