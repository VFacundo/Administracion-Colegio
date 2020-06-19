<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class personal_materia extends Model
{
      protected $fillable = [
      'id_personal','id_materia','tipo','fecha_alta','fecha_baja','suplente_de',
  ];
}
