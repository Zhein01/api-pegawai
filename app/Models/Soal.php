<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;
    protected $fillable = [
        'batch_soal_id',
        'soal',
        'pil1',
        'pil2',
        'pil3',
        'pil4',
        'jawaban'
    ];
}
