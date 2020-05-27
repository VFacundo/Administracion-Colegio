<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol_usuario extends Model
{
  protected $fillable = [
      'id_usuario','nombre_rol',
  ];
}
