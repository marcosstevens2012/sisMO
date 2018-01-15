<?php

namespace mol\Http\Controllers;

use Illuminate\Http\Request;
use mol\Http\Requests;
use mol\Categoria;
use Illuminate\Support\Facades\Redirect;
use mol\Http\Requests\CategoriaFormRequest;
use DB;

class CategoriaController extends Controller
{
    //constructor
    public function __construct(){
         
    }
    public function index(Request $request){
    	if($request){
    		$query=trim($request->get('searchText'));
    		$categoria=DB::table('categoria')->where('nombre','LIKE','%'.$query.'%')
    		->where('condicion','=','Activo')
    		->orderBy('idcategoria','desc')
    		->paginate(7);
    		//retorna la vista en la carpeta artefacto/categoria/index.php
    		return view('artefacto.categoria.index',["categorias"=>$categoria,"searchText"=>$query]);
    	}
    }
    public function create()
    {
    	//artefacto/categoria/create.php
        return view("artefacto.categoria.create");
    }
    public function store (CategoriaFormRequest $request)
    {
        $categoria=new Categoria;
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        $categoria->stock=$request->get('stock');
        $categoria->condicion='Activo';
        $categoria->save();
        return Redirect::to('artefacto/categoria'); //redirecciona a la vista categoria

    }
    public function show($id)
    {
        return view("artefacto.categoria.show",["categoria"=>Categoria::findOrFail($id)]);//muestra categoria especifica
    }
    public function edit($id)
    {
        return view("artefacto.categoria.edit",["categoria"=>Categoria::findOrFail($id)]);
    }
    public function update(CategoriaFormRequest $request,$id)
    {
        $categoria=Categoria::findOrFail($id);
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        $categoria->update();
        return Redirect::to('artefacto/categoria');
    }
    public function destroy($id)
    {
        $categoria=Categoria::findOrFail($id);
        $categoria->condicion='0';
        $categoria->update();
        return Redirect::to('artefacto/categoria');
    }
}
