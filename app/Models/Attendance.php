<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';
    protected $fillable = [
        'id_user',
        'tanggal',
        'waktu_masuk',
        'waktu_keluar',
        'waktu_status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
