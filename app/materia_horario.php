<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class materia_horario extends Model
{
    protected $fillable = [
       'id','id_horario','id_materia_curso',
    ];
}
