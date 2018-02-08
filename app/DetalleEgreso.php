<?php

namespace mol;

use Illuminate\Database\Eloquent\Model;

class DetalleEgreso extends Model
{
    //declaración de los atributos de la tabla
    protected $table = 'detalle_egreso';
    protected $primaryKey = 'iddetalle_egreso';
    public $timestamp = false;
    protected $fillable = [
    	'egreso_id',
    	'artefacto_id',
    	'idcategoria',
    	'cantidad'
    ];
    protected $guarded = [ ];
}
