<?php

namespace mol;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    //declaración de los atributos de la tabla
    protected $table = 'artefacto';
    protected $primaryKey = 'id';
    public $timestamp = false;
    protected $fillable = [
    	'nombre',
    	'stock',
    	'estado',
    	'descripcion'
    ];
    protected $guarded = [ ];
}
