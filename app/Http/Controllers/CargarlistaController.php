<?php

namespace mol\Http\Controllers;

use Illuminate\Http\Request;
use mol\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use mol\Http\Requests\TareaFormRequest;
use mol\Tarea;

use DB;
use Carbon\Carbon; //Fecha zona horaria
use Response;
use Illuminate\Support\Collection;

class CargarlistaController extends Controller
{
    //constructor
    public function __construct(){
        

    }
    public function index(Request $request){
    	if($request){
    		$query=trim($request->get('searchText'));
    		$lista=DB::table('list as lis')
            ->select('lis.*')
    		->where('lis.user','LIKE','%'.$query.'%')
    		->get();

            //dd($lista);
    		return view('lista.lista.index',["lista"=>$lista,"searchText"=>$query]);
    	}
    }
    public function create(){
        $user=DB::table('users')->get();
        $tareas=DB::table('tarea')->get();
        //dd($artefactos);
    	return view("lista.lista.create",["user"=>$user,"tarea"=>$tareas]);
    }

    public function store(listaFormRequest $request){
       
            $lista = new lista;
            $mytime = Carbon::now();
            //$lista->fecha_hora = $mytime->toDateTimeString();
            $lista->hora_inicio=$request->get('hora_inicio');
            $lista->hora_fin=$request->get('hora_fin');
            $lista->observaciones=$request->get('observaciones');
            $lista->estado='Activo';
            $lista->save();

            $nombre = $request->get('pnombre');
            $observaciones = $request->get('pobservaciones');
            $ntarea = $request->get('ptarea');

            $cont = 0;
            while ($cont < count($nombre)) {
                # code...
                $detalle = new DetalleLista();
                $detalle->idlista=$lista->id;
                $detalle->nombretarea=$nombre[$cont];
                $detalle->observaciones=$observaciones[$cont];
                $detalle->save();
                $cont=$cont+1;
            }

            $cont = 0;

            if ($ntarea != 0){
                while ($cont < count($ntarea)) {
                # code...
                $detalle = new Tarea();
                $detalle->nombre=$nombre[$cont];
                $detalle->observaciones=$observaciones[$cont];
                $detalle->save();
                $cont=$cont+1;
            }
            }
           
           
        return Redirect::to('movimiento/lista');
    }

     public function edit($id)
    {
        return view("lista.cargar.edit",["lista"=>Lista::findOrFail($id)]);
    }

    public function update(CategoriaFormRequest $request,$id)
    {
        $categoria=Categoria::findOrFail($id);
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        $categoria->update();
        return Redirect::to('lista/cargar');
    }
    public function show($id){
        $lista=DB::table('lista as i')
            ->join('detalle_lista as di','i.id','=','di.idlista')
            ->select('i.idlista','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precio_compra) as total'))
            ->where('i.idlista','=',$id)
             ->groupBy('i.idlista','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante', 'i.num_comprobante','i.impuesto','i.estado')
            ->first();
            $detalles=DB::table('detalle_lista as d')
            ->join('articulo as a', 'd.idarticulo','=', 'a.idarticulo')
            ->select('a.nombre as articulo','d.cantidad', 'd.precio_compra', 'd.precio_venta')
            ->where('d.idlista','=',$id)

            ->get();//obengo todos los detalles;
            return view("movimiento.lista.show",["lista"=>$lista,"detalles"=>$detalles]);
    }
    public function destroy($id){
        $lista=lista::findOrFail($id); //coincida con el id
        $lista->Estado='C';
        $lista->update();
        return Redirect::to('movimiento/lista');
    }
}
