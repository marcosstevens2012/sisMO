<?php

namespace mol;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    //declaración de los atributos de la tabla
    protected $table = 'detalle_ingreso';
    protected $primaryKey = 'id';
    public $timestamp = false;
    protected $fillable = [
    	'movimiento_id',
    	'artefacto_id',
    	'cantidad'
    ];
    protected $guarded = [ ];
}
