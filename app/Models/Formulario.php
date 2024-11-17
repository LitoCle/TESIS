<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ObjetoRobado extends Model
{
    public $timestamps = false;
    protected $table = 'objeto_robado'; // Nombre de la tabla en la base de datos
}
