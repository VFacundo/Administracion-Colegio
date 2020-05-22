<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
  protected $fillable = [
      'id','nombre_permiso', 'funcionalidad_permiso', 'estado_permiso','descripcion_permiso',
  ];
}
