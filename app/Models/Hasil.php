<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    use HasFactory;
    protected $fillable = [
        'lamaran_id',
        'skor',
        'status',
    ];

    public function lamaran(){
        return $this->hasOne(Lamaran::class, 'id', 'lamaran_id');
    }
}
