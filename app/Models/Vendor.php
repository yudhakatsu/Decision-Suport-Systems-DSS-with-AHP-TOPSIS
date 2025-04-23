<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Vendor extends Authenticatable
{
    use HasFactory;

    protected $table = 'vendors';

    protected $fillable = [
        'username',
        'password',
        'background_vendor',
        'No_HP',
        'nilai_akhir',
    ];

    protected $hidden = [
        'password',
    ];

    protected $guarded = [];
}
