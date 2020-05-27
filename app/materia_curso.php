<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class materia_curso extends Model
{
    protected $fillable = [
       'id_curso','id_materia','horario_materia',
    ];
}
