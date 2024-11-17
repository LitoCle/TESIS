<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delito extends Model
{
    public $timestamps = false;
    protected $table = 'delitos'; //Nombre de la tabla de base de datos
}
