<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permiso_rol extends Model
{
  protected $fillable = [
      'id_permiso','nombre_rol','fecha_asignacion_permiso',
  ];
}
