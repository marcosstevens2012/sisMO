<?php

namespace mol\Http\Controllers;

use Illuminate\Http\Request;
use mol\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use mol\Http\Requests\ingresoFormRequest;
use mol\Ingreso;
use mol\Egreso;
use mol\Inventario;
use mol\Categoria;
use mol\DetalleIngreso;

use DB;
use Carbon\Carbon; //Fecha zona horaria
use Response;
use Illuminate\Support\Collection;

class IngresoController extends Controller
{
    //constructor
    public function __construct(){
        

    }
    public function index(Request $request){
    	if($request){
    		$query=trim($request->get('searchText'));
    		$ingreso=DB::table('ingreso as mov')
    		->join('detalle_ingreso as dm','mov.id','=','dm.ingreso_id')
            ->join('artefacto as art','dm.artefacto_id','=','art.id')
    		->select('mov.id','mov.fecha_hora','mov.estado','art.nombre','mov.tipo','mov.observaciones','art.estadof')
    		->where('art.nombre','LIKE','%'.$query.'%')
    		->orderBy('mov.id','desc')
    		->groupBy('mov.id','mov.fecha_hora','art.nombre','mov.tipo','mov.estado','mov.observaciones','art.estadof')
    		->paginate(7);
    		return view('movimiento.ingreso.index',["ingresos"=>$ingreso,"searchText"=>$query]);
    	}
    }
    public function create(){
    	$artefactos=DB::table('artefacto as art')
        ->join('categoria as cat','cat.idcategoria','=','art.categoria')
        ->join('estado as est','est.id','=','art.estadof') 
    	->select('art.nombre AS artefacto','est.nombre as estadof','est.id','art.id','cat.idcategoria as categoria','cat.nombre as ncategoria','art.id')
    	->get();

        $user=DB::table('users')->get();
        $estado=DB::table('estado')->get();
        

        //dd($artefactos);
    	return view("movimiento.ingreso.create",["artefactos"=>$artefactos,"user"=>$user,"estado"=>$estado]);
    }

    public function buscarEgreso(Request $request){

        //$data=Egreso::select('id')->where('usuario',$request->id)->take(100)->get();

        $data=DB::table('egreso as egr')
        ->join('detalle_egreso as de','de.egreso_id','=','egr.id')
        ->join('artefacto as art','art.id','=','de.artefacto_id')
        ->join('users as u','u.id','=','egr.usuario')
        ->join('estado as est','est.id','=','art.estadof')
        ->where('usuario',$request->id)
        ->where('art.disponible','=',false)
        ->select('art.*','est.nombre as estad')
        ->get();

        return response()->json($data);//then sent this data to ajax success
    }
    public function store(IngresoFormRequest $request){
       
            $ingreso = new Ingreso;
            $mytime = Carbon::now();
            $ingreso->fecha_hora = $mytime->toDateTimeString();
            $ingreso->observaciones=$request->get('observaciones');
            $ingreso->estado='Activo';
            $ingreso->save();

            $idartefacto = $request->get('idartefacto');
            $estado= $request->get('estado');
            $idcategoria = $request->get('idcategoria');
            $observaciones = $request->get('observaciones');
            //dd($idartefacto);
            $cont = 0;
            foreach ($idartefacto as $id) {

                $artefacto = Inventario::findOrFail($id);
                $categoria = Categoria::findOrFail($idcategoria);
                $categoria->stock = $categoria->stock + 1;
                $artefacto->disponible = true;
                $artefacto->estadof = $estado[$cont];
                $artefacto->save();
                $cont=$cont+1;
                //dd($artefacto);
                
            }


            $cont = 0;
            while ($cont < count($idartefacto)) {
                # code...
                $detalle = new DetalleIngreso();
                $detalle->ingreso_id=$ingreso->id;
                $detalle->artefacto_id=$idartefacto[$cont];
                $detalle->idcategoria=$idcategoria[$cont];
                $detalle->observaciones=$observaciones[$cont];
                $detalle->save();
                $cont=$cont+1;
            }
           
           
        return Redirect::to('movimiento/ingreso');
    }
    public function show($id){
            $ingreso=DB::table('ingreso as i')
            ->join('detalle_ingreso as di','i.id','=','di.ingreso_id')
            ->select('i.*','di.*')
            ->where('i.id','=',$id)
            //->groupBy('i.id','i.fecha_hora')
            ->first();
            $detalles=DB::table('detalle_ingreso as d')
            ->join('artefacto as inv', 'd.artefacto_id','=', 'inv.id')
            ->select('inv.nombre')
            ->where('d.ingreso_id','=',$id)

            ->get();//obengo todos los detalles;
            return view("movimiento.ingreso.show",["ingreso"=>$ingreso,"detalles"=>$detalles]);
    }
    public function destroy($id){
        $ingreso=Ingreso::findOrFail($id); //coincida con el id
        $ingreso->Estado='C';
        $ingreso->update();
        return Redirect::to('movimiento/ingreso');
    }
}
