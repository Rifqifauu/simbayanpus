<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';

    protected $fillable = [
        'id_user',
        'rencana_kerja',
        'kehadiran',
        'disiplin_dan_etika',
        'keaktifan_kreativitas',
        'kecermatan',
        'tanggung_jawab',
        'huruf_mutu',
    ];

    // Relasi ke User (asumsinya penilaian milik satu user)
    public function user()
    {
        return $this->belongsTo(User::class,'id_user');
    }

    // Accessor untuk nilai rata-rata (opsional)
    public function getRataRataAttribute()
    {
        $nilai = [
            $this->rencana_kerja,
            $this->kehadiran,
            $this->disiplin_dan_etika,
            $this->keaktifan_kreativitas,
            $this->kecermatan,
            $this->tanggung_jawab,
        ];

        return round(array_sum($nilai) / count($nilai), 2);
    }
}
