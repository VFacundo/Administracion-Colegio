<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = [
       'id','legajo','nombre_persona','apellido_persona','tipo_documento','dni_persona','cuil_persona','domicilio','fecha_nacimiento','numero_telefono',
    ];
}
