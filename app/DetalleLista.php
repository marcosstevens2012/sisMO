<?php

namespace mol;

use Illuminate\Database\Eloquent\Model;

class DetalleLista extends Model
{
    //declaración de los atributos de la tabla
    protected $table = 'detalle_list';
    protected $primaryKey = 'id';
    public $timestamp = false;
    protected $fillable = [
    	'listaid',
    	'tarea'
    ];
    protected $guarded = [ ];
}
