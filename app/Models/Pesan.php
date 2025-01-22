<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * By default, Laravel will use the pluralized form of the class name (`pesans`),
     * but since your table name is `pesan`, we explicitly define it here.
     */
    protected $table = 'pesan';

    /**
     * The attributes that are mass assignable.
     *
     * Define which attributes can be mass-assigned in bulk.
     */
    protected $fillable = [
        'id_user',
        'pesan',
        'tipe', // Enum column: 'masuk' or 'keluar'
    ];

    /**
     * The attributes that should be cast.
     *
     * Automatically cast attributes to their appropriate types.
     */
    protected $casts = [
        'tipe' => 'string', // Enum is stored as a string
    ];

    /**
     * Define the relationship with the `User` model.
     * Each message belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
