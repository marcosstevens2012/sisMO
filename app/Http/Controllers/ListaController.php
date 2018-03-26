<?php

namespace mol\Http\Controllers;

use Illuminate\Http\Request;
use mol\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use mol\Http\Requests\TareaFormRequest;
use mol\Tarea;
use mol\CargarlistaController;
use mol\lista;
use mol\Detallelista;
use mol\HistorialList;
use DB;
use Carbon\Carbon; //Fecha zona horaria
use Response;
use Illuminate\Support\Collection;

class listaController extends Controller
{
    //constructor
    public function __construct(){
        

    }
    public function index(Request $request){
    	if($request){
    		$query=trim($request->get('searchText'));
    		$lista=DB::table('lista as lis')
            ->select('lis.*')
    		//->where('lis.user','LIKE','%'.$query.'%')
    		->get();
    		return view('lista.lista.index',["lista"=>$lista,"searchText"=>$query]);
    	}
    }
    public function create(){
        $user=DB::table('users')->get();
        $tareas=DB::table('tarea')->get();
        //dd($artefactos);
    	return view("lista.lista.create",["user"=>$user,"tarea"=>$tareas]);
    }

    public function store(Request $request){
       
            $lista = new lista;
            $mytime = Carbon::now();
            //$lista->fecha_hora = $mytime->toDateTimeString();
            $lista->hora_inicio=$request->get('hora_inicio');
            $lista->hora_fin=$request->get('hora_fin');
            $lista->user=$request->get('pidusuario');
            $lista->observaciones=$request->get('lobservaciones');
            $lista->estado='Activo';
            $lista->save();

            $nombre = $request->get('nombre');
            $observaciones = $request->get('pobservaciones');
            $ntarea = $request->get('nuevonombre');
            $observacioness = $request->get('pobservacioness');
            //dd($ntarea);

             $cont = 0;

            if ($ntarea != 0){
                while ($cont < count($ntarea)) {
                # code...
                $tareanueva = new Tarea();
                $tareanueva->nombre=$ntarea[$cont];
                $tareanueva->observaciones=$observacioness[$cont];
                $tareanueva->save();
                $detalle = new Detallelista();
                $detalle->listaid=$lista->id;
                $detalle->tarea=$tareanueva->id;
                $detalle->observaciones=$observacioness[$cont];
                $detalle->save();
                $cont=$cont+1;
            }
            }

            $cont = 0;
            while ($cont < count($nombre)) {
                # code...
                $detalle = new Detallelista();
                $detalle->listaid=$lista->id;
                $detalle->tarea=$nombre[$cont];
                $detalle->observaciones=$observaciones[$cont];
                $detalle->save();
                $cont=$cont+1;
            }


           
           
        return Redirect::to('lista/lista');
    }

    public function edit($id)
    {       
            $hora_inicio=DB::table('lista')->where('id','=',$id)->select('hora_inicio')->first();
            $hora_fin=DB::table('lista')->where('id','=',$id)->select('hora_fin')->first();

            $date = Carbon::now();
            $date = $date->format('h:i:s');

            if($hora_inicio > $date || $hora_fin < $date){
                return Redirect::to('lista/lista')->with('notice','Fuera de Horario');
            }

            $lista=DB::table('lista as i')
            ->join('detalle_list as di','i.id','=','di.listaid')
            ->select('i.*')
            ->where('i.id','=',$id)
            ->first();
            $detalles=DB::table('detalle_list as d')
            ->join('lista as a', 'd.listaid','=', 'a.id')
            ->join('tarea as tar','tar.id','=','d.tarea')
            ->where('d.listaid','=',$id)
            ->select('d.*','tar.nombre as tarea','tar.id as idtarea')
            ->get();//obengo todos los detalles;
            //dump($lista);
    
        return view("lista.lista.edit",["lista"=>$lista,"detalles"=>$detalles]);
    }

    public function update(Request $request,$id)
    {   

        $tarea = $request->get('tarea');
        $idtarea = $request->get('idtarea');
        $estado = $request->input('estado');
        $iddetalle = $request->get('id');
        $date = Carbon::now();
        $cont = 0;
            
            while ($cont < count($iddetalle)) {
                # code...
                $detalle = new HistorialList;
                if( $estado[$cont] === null){           
                    $detalle->estado="off";
                }else{
                    $detalle->estado=$estado[$cont];
                }
                $detalle->fecha_hora=$date;
                $detalle->id_detalle=$iddetalle[$cont];
                $detalle->idtarea=$idtarea[$cont];
                $detalle->save();
                $cont=$cont+1;
            }
        return Redirect::to('lista/lista');
    }
    public function show($id){
            $lista=DB::table('lista as i')
            ->join('detalle_list as di','i.id','=','di.listaid')
            ->select('i.*')
            ->where('i.id','=',$id)
            ->first();
            $detalles=DB::table('detalle_list as d')
            ->join('lista as a', 'd.listaid','=', 'a.id')
            ->where('d.listaid','=',$id)
            ->select('d.*')
            ->get();//obengo todos los detalles;
            //dump($lista);
            return view("lista.lista.show",["lista"=>$lista,"detalles"=>$detalles]);
    }
    public function destroy($id){
        $lista=lista::findOrFail($id); //coincida con el id
        $lista->Estado='C';
        $lista->update();
        return Redirect::to('lista/lista');
    }
}
