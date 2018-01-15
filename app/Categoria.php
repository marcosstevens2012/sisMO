<?php

namespace mol;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //declaración de los atributos de la tabla
    protected $table = 'categoria';
    protected $primaryKey = 'idcategoria';
    public $timestamp = false;
    protected $fillable = [
    	'nombre',
    	'stock',
    	'descripcion'
    ];
    protected $guarded = [ ];
}
