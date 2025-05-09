<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    protected $table = 'logbook';
    protected $fillable = [
        'id_user',
        'tanggal',
        'aktivitas',
        'verifikasi',
        'catatan_pembimbing',
        'created_at',
        'updated_at',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
