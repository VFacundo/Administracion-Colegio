<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class programa_materia extends Model
{
     protected $fillable = [
       'id','nombre_archivo','localizacion_archivo','fecha_subida','vigente_desde','vigente_hasta',
    ];
}
