<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class responsable extends Model
{
    protected $fillable = [
       'id','persona_asociada',
    ];
}
