<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class noticia extends Model
{
  protected $fillable = [
     'id','descripcion_noticia','titulo_noticia','fecha_origen','noticias_usuarios_generador',
  ];
}
