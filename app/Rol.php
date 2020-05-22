<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
  protected $fillable = [
      'nombre_rol','descripcion_rol', 'estado', 'estado_rol',
  ];
}
