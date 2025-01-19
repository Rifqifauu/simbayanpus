<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserDetailResource\Pages;
use App\Filament\Resources\UserDetailResource\RelationManagers;
use App\Models\UserDetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserDetailResource extends Resource
{
    protected static ?string $model = UserDetail::class;

    protected static ?string $navigationGroup ='Permohonan';
    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationLabel = 'Dalam Proses';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id_user')
                ->label('Nama Lengkap')
                ->options(\App\Models\User::all()->pluck('name', 'id'))
                ->required(),
                Forms\Components\TextInput::make('panggilan')
                    ->label('Nama Panggilan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nik')
                    ->label('NIK')
                    ->required()
                    ->maxLength(50)
                    ->helperText('Nomor Induk Keluarga'),
                    Forms\Components\TextInput::make('nim')
                    ->label('NIM')
                    ->required()
                    ->maxLength(50)
                    ->helperText('Nomor Induk Mahasiswa'),
                Forms\Components\TextInput::make('institusi')
                    ->label('Institusi')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('program_studi')
                    ->label('Program Studi')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('medsos')
                    ->label('Media Sosial')
                    ->maxLength(255)
                    ->url()
                    ->helperText('URL media sosial (opsional)'),
    
                Forms\Components\FileUpload::make('foto')
                    ->label('Foto Profil')
                    ->image()
                    ->required()
                    ->rules('nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240') // Increase the max size to 10 MB
                    ->helperText('Unggah foto profil yang sesuai.')
            ]);
            
    }
    
    public static function getPluralLabel(): string
    {
        return 'Detail Pemohon';  
    }
    public static function table(Table $table): Table
    {
        return $table
        ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('user.userDetail', function ($query) {
            $query->where('status_pendaftaran', 'diproses');
        }))
            ->columns([
                Tables\Columns\TextColumn::make('user.name')  // Akses nama pengguna melalui relasi 'user'
                ->label('Nama Lengkap')
                ->searchable()
                ->sortable(),            
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('program_studi')
                    ->label('Program Studi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('institusi')
                    ->label('Institusi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.Permohonan.cv')
                    ->label('CV')
                    ->searchable()
                    ->url(fn($record) => route('download.cv', ['id' => $record->user->id]), true),
                
                    Tables\Columns\TextColumn::make('user.Permohonan.surat_pengantar')
                    ->label('Surat Pengantar')
                    ->searchable()
                    ->url(fn($record) => route('download.surat_pengantar', ['id' => $record->user->id]), true),
                
                    Tables\Columns\TextColumn::make('user.Permohonan.proposal')
                    ->label('Proposal')
                    ->searchable()
                    ->url(fn($record) => route('download.proposal', ['id' => $record->user->id]), true),
                
                    Tables\Columns\TextColumn::make('user.Permohonan.pedoman_magang')
                    ->label('Pedoman Magang')
                    ->searchable()
                    ->url(fn($record) => route('download.pedoman_magang', ['id' => $record->user->id]), true),
                Tables\Columns\ImageColumn::make('foto')
                ->url(fn ($record) => asset('storage/' . $record->foto))
                ->size(100),
                SelectColumn::make('user.userDetail.status_pendaftaran')
    ->options([
        'diterima' => 'Terima',
        'ditolak' => 'Tolak',
    ]) // Menyediakan URL lengkap
            ])
            ->filters([
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListUserDetails::route('/'),
            'create' => Pages\CreateUserDetail::route('/create'),
            'edit' => Pages\EditUserDetail::route('/{record}/edit'),
        ];
    }
}
