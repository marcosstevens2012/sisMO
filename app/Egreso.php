<?php

namespace mol;

use Illuminate\Database\Eloquent\Model;

class Engreso extends Model
{
    //declaración de los atributos de la tabla
    protected $table = 'egreso';
    protected $primaryKey = 'id';
    public $timestamp = false;
    protected $fillable = [
    	'usuario',
    	'observaciones'
    ];
    protected $guarded = [ ];
}
