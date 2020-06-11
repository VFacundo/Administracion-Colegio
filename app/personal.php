<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class personal extends Model
{
      protected $fillable = [
       'id','id_persona', 'fecha_alta','fecha_baja','manejo_de_grupo','legajo_personal',
    ];
}
