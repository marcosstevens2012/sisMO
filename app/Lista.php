<?php

namespace mol;

use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    //declaración de los atributos de la tabla
    protected $table = 'lista';
    protected $primaryKey = 'id';
    public $timestamp = false;
    protected $fillable = [
    	'hora_inicio',
    	'hora_fin'
    ];
    protected $guarded = [ ];
}
