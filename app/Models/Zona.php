<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    public $timestamps = false;
    protected $table = 'zona';

    protected $fillable = [
        "id",
        "nombre",
        "fk_coordenadasGeograficas"
    ];
}
