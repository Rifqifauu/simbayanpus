<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

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
        protected static function booted()
        {
            static::created(function ($dokumen) {
                activity()
                    ->causedBy(auth()->user())
                    ->performedOn($dokumen)
                    ->event('created')
                    ->log('User ' . auth()->user()->name . ' membuat surat keterangan ' . $dokumen->keterangan . ' untuk ' . $dokumen->user->name);
            });
        }
}
