<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class curso extends Model
{
     protected $fillable = [
       'id','anio','nombre_curso', 'division', 'aula','id_ciclo_lectivo',
    ];
}
