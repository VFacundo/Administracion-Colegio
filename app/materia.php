<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class materia extends Model
{
    protected $fillable = [
       'id','nombre','carga_horaria','fecha_creacion','programa_materia','estado_materia','curso_correspondiente',
    ];
}
