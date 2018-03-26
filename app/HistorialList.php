<?php

namespace mol;

use Illuminate\Database\Eloquent\Model;

class HistorialList extends Model
{
    //declaración de los atributos de la tabla
    protected $table = 'historial_list';
    protected $primaryKey = 'id';
    public $timestamp = false;
    protected $fillable = [
    	'id_detalle',
    	'estado',
    	'fecha_hora',
    	'idtarea'
    ];
    protected $guarded = [ ];
}
