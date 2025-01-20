<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserDetailResource\Pages;
use App\Filament\Resources\UserDetailResource\RelationManagers;
use App\Models\UserDetail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('user.name')  // Nama Lengkap
                    ->label('Nama Lengkap'),
                Infolists\Components\TextEntry::make('jenis_kelamin')  // Jenis Kelamin
                    ->label('Jenis Kelamin'),
                Infolists\Components\TextEntry::make('program_studi')  // Program Studi
                    ->label('Program Studi'),
                Infolists\Components\TextEntry::make('institusi')  // Institusi
                    ->label('Institusi'),
                // CV - Display a download button instead of the URL
                Infolists\Components\TextEntry::make('user.Permohonan.cv')  
                    ->label('CV')
                    ->html(fn($record) => 
                        $record->user->Permohonan->cv ? 
                        '<a href="' . route('download.cv', ['id' => $record->user->id]) . '" class="text-blue-600" target="_blank">Download CV</a>' : 
                        'No CV Available'
                    ),
                // Surat Pengantar - Display a download button instead of the URL
                Infolists\Components\TextEntry::make('user.Permohonan.surat_pengantar')  
                    ->label('Surat Pengantar')
                    ->html(fn($record) => 
                        $record->user->Permohonan->surat_pengantar ? 
                        '<a href="' . route('download.surat_pengantar', ['id' => $record->user->id]) . '" class="text-blue-600" target="_blank">Download Surat Pengantar</a>' : 
                        'No Surat Pengantar Available'
                    ),
                // Proposal - Display a download button instead of the URL
                Infolists\Components\TextEntry::make('user.Permohonan.proposal')  
                    ->label('Proposal')
                    ->html(fn($record) => 
                        $record->user->Permohonan->proposal ? 
                        '<a href="' . route('download.proposal', ['id' => $record->user->id]) . '" class="text-blue-600" target="_blank">Download Proposal</a>' : 
                        'No Proposal Available'
                    ),
                // Pedoman Magang - Display a download button instead of the URL
                Infolists\Components\TextEntry::make('user.Permohonan.pedoman_magang')  
                    ->label('Pedoman Magang')
                    ->html(fn($record) => 
                        $record->user->Permohonan->pedoman_magang ? 
                        '<a href="' . route('download.pedoman_magang', ['id' => $record->user->id]) . '" class="text-blue-600" target="_blank">Download Pedoman Magang</a>' : 
                        'No Pedoman Magang Available'
                    ),
                Infolists\Components\ImageEntry::make('foto')  // Foto Profil
                    ->label('Foto Profil'),
                Infolists\Components\TextEntry::make('user.userDetail.status_pendaftaran')  // Status Pendaftaran
                    ->label('Status Pendaftaran'),
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
