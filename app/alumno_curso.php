<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class alumno_curso extends Model
{
     protected $fillable = [
       'id','id_alumno','id_curso',
    ];
}
