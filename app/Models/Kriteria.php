<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'tb_kriteria';
    protected $primaryKey = 'kode_kriteria';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_kriteria',
        'tahun',
        'nama_kriteria',
        'atribut',
    ];
}
