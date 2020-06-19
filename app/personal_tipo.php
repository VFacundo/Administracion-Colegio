<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class personal_tipo extends Model
{
    protected $fillable = [
      'id_personal','id_tipo_personal','fecha_desde','fecha_hasta',
  ];
}
