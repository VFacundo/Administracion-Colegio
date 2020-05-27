<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ciclo_lectivo extends Model
{
     protected $fillable = [
       'id','anio','nombre',
    ];
}
