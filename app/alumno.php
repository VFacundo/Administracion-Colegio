<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class alumno extends Model
{
    protected $fillable = [
       'id','legajo_alumno','persona_asociada','id_calendario', 'persona_tutor','fecha_baja',
    ];
}
