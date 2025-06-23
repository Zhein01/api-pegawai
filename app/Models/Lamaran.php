<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lowongan_id',
        'nama',
        'email',
        'telepon',
        'pendidikan',
        'cv',
        'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    

    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id');
    }

    protected $table = 'lamarans';

}
