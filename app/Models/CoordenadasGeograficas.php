<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoordenadasGeograficas extends Model
{
    public $timestamps = false;
    protected $table = 'coordenadas_geograficas';

    protected $guarded = [
    ];
}
