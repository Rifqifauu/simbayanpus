<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Filament\Resources\AttendanceResource\RelationManagers;
use App\Models\Attendance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Manajemen Magang';
    protected static ?string $navigationLabel = 'Daftar Hadir';

 public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Select::make('id_user')
                ->label('Nama')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),

            Forms\Components\DatePicker::make('tanggal')
                ->label('Tanggal')
                ->required(),

            Forms\Components\TimePicker::make('waktu_masuk')
                ->label('Waktu Masuk')
                ->seconds(false)
                ->nullable(),
             

            Forms\Components\TimePicker::make('waktu_keluar')
                ->label('Waktu Keluar')
                ->seconds(false)
                 ->nullable(),

            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'hadir' => 'Hadir',
                    'izin' => 'Izin',
                    'sakit' => 'Sakit',
                    'alpha' => 'Alpha',
                ])
                ->required(),
        ]);
}
public static function getNavigationSort(): ?int
{
    return 3; // Angka kecil tampil lebih atas
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
                Tables\Columns\TextColumn::make('waktu_masuk')
                ->label('Waktu Masuk')
->date('H:i')
                ->sortable()
                ->searchable()
                  ->wrap(),
                Tables\Columns\TextColumn::make('waktu_keluar')
                ->label('Waktu Keluar')
                ->date('H:i')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->sortable()
                ->searchable()
                ->badge()
                ->color(function ($state) {
    return match ($state) {
        'alpha' => 'danger',
        'hadir' => 'success',
        'izin' => 'warning',
       'sakit' => 'info',
    };
}),
            ])
            ->filters([
                Filter::make('tanggal')
    ->form([
        DatePicker::make('tanggal')->label('Tanggal'),
    ])
    ->query(function ($query, array $data) {
        return $query
            ->when($data['tanggal'], fn ($q) => $q->whereDate('tanggal', $data['tanggal']));
    })
    ->label('Filter Tanggal'),
             Tables\Filters\SelectFilter::make('id_user')
            ->label('Nama User')
            ->options(
             \App\Models\User::all()->pluck('name', 'id')->toArray()
        ),
        ])
            ->actions([
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
             ->defaultSort('tanggal', 'desc');;
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
            'index' => Pages\ListAttendances::route('/'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
