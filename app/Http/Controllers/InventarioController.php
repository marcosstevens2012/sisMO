<?php

namespace mol\Http\Controllers;

use Illuminate\Http\Request;
use mol\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use mol\Http\Requests\InventarioFormRequest;
use mol\Inventario;
use DB;


class InventarioController extends Controller
{
    //constructor
    public function __construct(){
        

    }
    public function index(Request $request){
    	if($request){
    		$query=trim($request->get('searchText'));
    		$artefactos=DB::table('artefacto as a')
    		//de la union eligo los campos que requiero
    		->select('a.id', 'a.nombre', 'a.stock', 'a.descripcion', 'a.estado')
    		->where('a.nombre','LIKE','%'.$query.'%')
            //otro campo
            //->orwhere('a.nombre','LIKE','%'.$query.'%')
    		->orderBy('a.id','desc')
    		->paginate(100);
    		//retorna la vista en la carpeta almacen/categoria/index.php
    		return view('artefacto.artefacto.index',["artefactos"=>$artefactos,"searchText"=>$query]);
    	}
    }
    public function create()
    {
        return view("artefacto.artefacto.create");
    }
    public function store (InventarioFormRequest $request)
    {
        $artefacto = new Inventario;
        $artefacto->nombre=$request->get('nombre');
        $artefacto->stock=$request->get('stock');
        $artefacto->descripcion=$request->get('descripcion');
        $artefacto->estado='Activo';
        $artefacto->save();
        return Redirect::to('artefacto/artefacto'); //redirecciona a la vista categoria

    }
    public function show($id)
    {
        return view("artefacto.artefacto.show",["artefacto"=>artefacto::findOrFail($id)]);
    }
    public function edit($id)
    {
        $artefacto = Inventario::findOrFail($id);
        return view("artefacto.artefacto.edit",["artefacto"=>$artefacto]);
        //return view("almacen.categoria.edit",["categoria"=>Categoria::findOrFail($id)]);

    }
    public function update(InventarioFormRequest $request,$id)
    {
        $artefacto=Inventario::findOrFail($id);
        $artefacto->nombre=$request->get('nombre');
        $artefacto->stock=$request->get('stock');
        $artefacto->estado=$request->get('estado');
        $artefacto->descripcion=$request->get('descripcion');
        $artefacto->update();
        return Redirect::to('artefacto/artefacto');
    }
    public function destroy($id)
    {
        try {
        DB::beginTransaction();
        $artefacto=Inventario::findOrFail($id);
        $artefacto->estado='Inactivo';
        $artefacto->update();
        DB::commit();
        $r = 'artefacto Eliminado';
        }

        catch (\Exception $e) {
        DB::rollback(); 
        $r = 'No se ha podido eliminar artefacto';
        }

        return Redirect::to('artefacto/artefacto')->with('notice',$r); //redirecciona a la vista turno

    }
}