<?php

namespace mol;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    //declaración de los atributos de la tabla
    protected $table = 'ingreso';
    protected $primaryKey = 'id';
    public $timestamp = false;
    protected $fillable = [
    	'usuario_id',
    	'fecha_hora',
    	'tipo',
    	'observaciones'
    ];
    protected $guarded = [ ];
}
