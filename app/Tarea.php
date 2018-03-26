<?php

namespace mol;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    //declaración de los atributos de la tabla
    protected $table = 'tarea';
    protected $primaryKey = 'id';
    public $timestamp = false;
    protected $fillable = [
    	'nombre',
    	'observaciones'
    ];
    protected $guarded = [ ];
}
