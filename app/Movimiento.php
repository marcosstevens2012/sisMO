<?php

namespace mol;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    //declaración de los atributos de la tabla
    protected $table = 'movimiento';
    protected $primaryKey = 'id';
    public $timestamp = false;
    protected $fillable = [
    	'usuario',
    	'fecha_hora',
    	'tipo',
    	'observaciones'
    ];
    protected $guarded = [ ];
}
