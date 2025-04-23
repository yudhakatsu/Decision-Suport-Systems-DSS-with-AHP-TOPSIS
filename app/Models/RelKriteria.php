<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelKriteria extends Model
{
    use HasFactory;

    protected $table = 'rel_kriteria';

    protected $fillable = [
        'tahun',
        'ID1',
        'ID2',
        'nilai',
    ];
}
