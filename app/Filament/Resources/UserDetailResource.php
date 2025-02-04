<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserDetailResource\Pages;
use App\Filament\Resources\UserDetailResource\RelationManagers;
use App\Models\UserDetail;
use App\Models\Pesan;
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
use Filament\Notifications\Notification;

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
            ->height(250)
            ->columnSpan(2),
            Infolists\Components\TextEntry::make('user.permohonan.tgl_masuk')
                ->label('Mulai Magang') 
                ->badge()
                ->color('primary'),
            Infolists\Components\TextEntry::make('user.permohonan.tgl_keluar')
                ->label('Selesai Magang')
                ->badge()
                ->color('primary'),
            Infolists\Components\TextEntry::make('nik')
            ->label('NIK'),
            Infolists\Components\TextEntry::make('user.name')
                ->label('Nama Lengkap'),
            Infolists\Components\TextEntry::make('jenis_kelamin')
                ->label('Jenis Kelamin'),
            Infolists\Components\TextEntry::make('agama')
                ->label('Agama'),
            Infolists\Components\TextEntry::make('alamat')
                ->label('Alamat KTP'),
            Infolists\Components\TextEntry::make('domisili')
                ->label('Alamat Domisili'),
            Infolists\Components\TextEntry::make('user.email')
                ->label('Email'),
                Infolists\Components\TextEntry::make('medsos')
                ->label('Media Sosial'),
            Infolists\Components\TextEntry::make('nomor_hp')
                ->label('Nomor Hp'),
                Infolists\Components\TextEntry::make('nim')
                ->label('NIM/NIS/NIP'),
                Infolists\Components\TextEntry::make('program_studi')
                ->label('Program Studi'),
            Infolists\Components\TextEntry::make('institusi')
                ->label('Institusi'),
            Infolists\Components\TextEntry::make('user.Permohonan.cv')
                ->label('CV')
                ->formatStateUsing(function ($state, $record) {
                    if ($record->user->Permohonan->cv) {
                        return view('components.download-link', [
                            'url' => route('view.cv', ['id' => $record->user->id]),
                            'label' => 'View CV'
                        ]);
                    }
                    return 'No CV Available';
                }),
            Infolists\Components\TextEntry::make('user.Permohonan.surat_pengantar')
                ->label('Surat Pengantar')
                ->formatStateUsing(function ($state, $record) {
                    if ($record->user->Permohonan->surat_pengantar) {
                        return view('components.download-link', [
                            'url' => route('view.surat_pengantar', ['id' => $record->user->id]),
                            'label' => 'View Surat Pengantar'
                        ]);
                    }
                    return 'No Surat Pengantar Available';
                }),
            Infolists\Components\TextEntry::make('user.Permohonan.proposal')
                ->label('Proposal')
                ->formatStateUsing(function ($state, $record) {
                    if ($record->user->Permohonan->proposal) {
                        return view('components.download-link', [
                            'url' => route('view.proposal', ['id' => $record->user->id]),
                            'label' => 'View Proposal'
                        ]);
                    }
                    return 'No Proposal Available';
                }),
            Infolists\Components\TextEntry::make('user.Permohonan.pedoman_magang')
                ->label('Pedoman Magang')
                ->formatStateUsing(function ($state, $record) {
                    if ($record->user->Permohonan->pedoman_magang) {
                        return view('components.download-link', [
                            'url' => route('view.pedoman_magang', ['id' => $record->user->id]),
                            'label' => 'View Pedoman Magang'
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
                    
       // Menyediakan URL lengkap
            ])
            ->filters([
                
            ])
            ->actions([
                Tables\Actions\Action::make('kirimPesan')
                    ->label('Ubah Status')
                    ->icon('heroicon-s-pencil-square')
                    ->form([
                        Forms\Components\Textarea::make('pesan')
                            ->label('Isi Pesan')
                            ->required(),
                        Forms\Components\Select::make('status_pendaftaran')
                            ->label('Status Pendaftaran')
                            ->options([
                                'ditolak' => 'Ditolak',
                                'diterima' => 'Diterima',
                            ])
                            ->required(),
                    ])
                    ->action(function (UserDetail $record, array $data) {
                        // Create new message
                        Pesan::create([
                            'id_user' => $record->id_user, // Get the user_id from UserDetail
                            'pesan' => $data['pesan'],
                            'tipe' => 'masuk',
                            'tanggal' => now(),
                        ]);
                        UserDetail::where('id_user', $record->id_user)->update([
                            'status_pendaftaran' => $data['status_pendaftaran'],
                        ]);

                        // Show success notification
                        Notification::make()
                            ->success()
                            ->title('Status Berhasil Diubah')
                            ->send();
                    })
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
