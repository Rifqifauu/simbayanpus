<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;

    // Specify the table name if it's not following the convention (optional)
    protected $table = 'permohonan';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'divisi',
        'tgl_masuk',
        'tgl_keluar',
        'cv',
        'surat_pengantar',
        'proposal',
        'pedoman_magang',
        'id_user', // Foreign key to users table
    ];

    /**
     * Get the user that owns the permohonan.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user'); // The 'user_id' is the foreign key
    }
}
