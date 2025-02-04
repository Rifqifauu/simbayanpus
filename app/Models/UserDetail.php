<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'id_user',
        'panggilan',
        'nim',
        'nik',
        'institusi',
        'program_studi',
        'medsos',
        'nomor_hp',
        'jenis_kelamin',
        'alamat',
        'status_pendaftaran',
        'foto',
        'agama',
        'domisili',
        'updated_at',
'created_at'
            ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
