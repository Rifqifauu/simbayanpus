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
            Infolists\Components\ImageEntry::make('foto')
            ->label('')
            ->size(250)
            ->columnSpan(2), // or `columnSpan('full')`,
            Infolists\Components\TextEntry::make('user.name')
                ->label('Nama Lengkap'),
            Infolists\Components\TextEntry::make('jenis_kelamin')
                ->label('Jenis Kelamin'),
            Infolists\Components\TextEntry::make('program_studi')
                ->label('Program Studi'),
            Infolists\Components\TextEntry::make('user.email')
                ->label('Email'),
            Infolists\Components\TextEntry::make('nomor_hp')
                ->label('Nomor Hp'),
            Infolists\Components\TextEntry::make('institusi')
                ->label('Institusi'),
            Infolists\Components\TextEntry::make('user.Permohonan.cv')
                ->label('CV')
                ->formatStateUsing(function ($state, $record) {
                    if ($record->user->Permohonan->cv) {
                        return view('components.download-link', [
                            'url' => route('download.cv', ['id' => $record->user->id]),
                            'label' => 'Download CV'
                        ]);
                    }
                    return 'No CV Available';
                }),
            Infolists\Components\TextEntry::make('user.Permohonan.surat_pengantar')
                ->label('Surat Pengantar')
                ->formatStateUsing(function ($state, $record) {
                    if ($record->user->Permohonan->surat_pengantar) {
                        return view('components.download-link', [
                            'url' => route('download.surat_pengantar', ['id' => $record->user->id]),
                            'label' => 'Download Surat Pengantar'
                        ]);
                    }
                    return 'No Surat Pengantar Available';
                }),
            Infolists\Components\TextEntry::make('user.Permohonan.proposal')
                ->label('Proposal')
                ->formatStateUsing(function ($state, $record) {
                    if ($record->user->Permohonan->proposal) {
                        return view('components.download-link', [
                            'url' => route('download.proposal', ['id' => $record->user->id]),
                            'label' => 'Download Proposal'
                        ]);
                    }
                    return 'No Proposal Available';
                }),
            Infolists\Components\TextEntry::make('user.Permohonan.pedoman_magang')
                ->label('Pedoman Magang')
                ->formatStateUsing(function ($state, $record) {
                    if ($record->user->Permohonan->pedoman_magang) {
                        return view('components.download-link', [
                            'url' => route('download.pedoman_magang', ['id' => $record->user->id]),
                            'label' => 'Download Pedoman Magang'
                        ]);
                    }
                    return 'No Pedoman Magang Available';
                }),
            Infolists\Components\TextEntry::make('user.userDetail.status_pendaftaran')
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
                SelectColumn::make('user.userDetail.status_pendaftaran')
                ->label('Status Pendaftaran')
    ->options([
        'diterima' => 'Terima',
        'ditolak' => 'Tolak',
    ]) // Menyediakan URL lengkap
            ])
            ->filters([
                
            ])
            ->actions([
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
            'view' => Pages\ViewUserDetails::route('/{record}'),
            'index' => Pages\ListUserDetails::route('/'),
            'create' => Pages\CreateUserDetail::route('/create'),        ];
    }
}
