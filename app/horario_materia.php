<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class horario_materia extends Model
{
     protected $fillable = [
       'id','hora_inicio','hora_fin','dia_semana',
    ];
}
