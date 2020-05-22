<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tipo_documento extends Model
{
    protected $fillable = [
      'id','nombre_tipo','descripcion',
    ];
}
