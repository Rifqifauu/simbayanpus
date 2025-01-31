<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $table = 'dokumen';
    protected $fillable = [
        'id_user',
        'dokumen',
        'keterangan', ];
        
        public function user()
        {
            return $this->belongsTo(User::class, 'id_user');
        }

}
