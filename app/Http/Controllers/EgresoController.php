<?php

namespace mol\Http\Controllers;

use Illuminate\Http\Request;
use mol\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use mol\Http\Requests\egresoFormRequest;
use mol\Egreso;
use mol\Inventario;
use mol\Detalleegreso;

use DB;
use Carbon\Carbon; //Fecha zona horaria
use Response;
use Illuminate\Support\Collection;

class EgresoController extends Controller
{
    //constructor
    public function __construct(){
        

    }
    public function index(Request $request){
        if($request){
            $query=trim($request->get('searchText'));
            $egreso=DB::table('egreso as mov')
            ->join('detalle_egreso as dm','mov.id','=','dm.egreso_id')
            ->join('artefacto as art','dm.artefacto_id','=','art.id')
            ->select('mov.id','mov.estado','art.nombre','mov.observaciones')
            ->where('art.nombre','LIKE','%'.$query.'%')
            ->orderBy('mov.id','desc')
            ->groupBy('mov.id','art.nombre','mov.estado','mov.observaciones')
            ->paginate(7);
            return view('movimiento.egreso.index',["egresos"=>$egreso,"searchText"=>$query]);
        }
    }
    public function create(){
        $artefactos=DB::table('artefacto as art')
        ->join('categoria as cat','cat.idcategoria','=','art.categoria') 
        ->select('art.nombre AS artefacto','art.id','cat.idcategoria as categoria','cat.nombre as ncategoria')
        ->where('art.estado','=','Disponible')
        ->get();

        //dd($artefactos);
        return view("movimiento.egreso.create",["artefactos"=>$artefactos]);
    }
    public function store(egresoFormRequest $request){
       
            $egreso = new egreso;
            $mytime = Carbon::now();
            $egreso->fecha_hora = $mytime->toDateTimeString();
            $egreso->observaciones=$request->get('observaciones');
            $egreso->estado='Activo';
            $egreso->save();


            
            $idartefacto=$request->get('idartefacto');
            $cantidad = $request->get('cantidad');
            $idcategoria = $request->get('idcategoria');
            
            
            //recorre los articulos agregados
            $cont = 0;

            

            while ($cont < count($idartefacto)) {
                # code...
                $detalle = new Detalleegreso();
                $detalle->egreso_id=$egreso->id;
                $detalle->artefacto_id=$idartefacto[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->idcategoria=$idcategoria[$cont];
                $detalle->save();
                $cont=$cont+1;
            }
           
           
        return Redirect::to('movimiento/egreso');
    }
    public function show($id){
        $egreso=DB::table('egreso as i')
            ->join('detalle_egreso as di','i.id','=','di.idegreso')
            ->select('i.idegreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precio_compra) as total'))
            ->where('i.idegreso','=',$id)
             ->groupBy('i.idegreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante', 'i.num_comprobante','i.impuesto','i.estado')
            ->first();
            $detalles=DB::table('detalle_egreso as d')
            ->join('articulo as a', 'd.idarticulo','=', 'a.idarticulo')
            ->select('a.nombre as articulo','d.cantidad', 'd.precio_compra', 'd.precio_venta')
            ->where('d.idegreso','=',$id)

            ->get();//obengo todos los detalles;
            return view("movimiento.egreso.show",["egreso"=>$egreso,"detalles"=>$detalles]);
    }
    public function destroy($id){
        $egreso=egreso::findOrFail($id); //coincida con el id
        $egreso->Estado='C';
        $egreso->update();
        return Redirect::to('movimiento/egreso');
    }
}
