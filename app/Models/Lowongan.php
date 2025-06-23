<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'perusahaan',
        'lokasi',
        'periode',
        'deskripsi',
        'kualifikasi',
        'batch_soal_id',
        'selesai'
    ];

    public function lamarans()
    {
        return $this->hasMany(Lamaran::class);
    }
    
}
