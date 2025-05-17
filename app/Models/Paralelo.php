<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paralelo extends Model
{
    //mostrar como esta estructurada la tabla 
    protected $fillable=[ 'nombre'];
    //enseñar como se relacionan entre tablas
    public function estudiante(){
        return $this->hasMany(Estudiante::class);
    }

}
