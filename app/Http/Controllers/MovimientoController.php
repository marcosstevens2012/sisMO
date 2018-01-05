<?php

namespace mol\Http\Controllers;

use Illuminate\Http\Request;
use mol\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use mol\Http\Requests\movimientoFormRequest;
use mol\movimiento;
use mol\Detallemovimiento;

use DB;
use Carbon\Carbon; //Fecha zona horaria
use Response;
use Illuminate\Support\Collection;

class MovimientoController extends Controller
{
    //constructor
    }
    public function index(Request $request){
    	if($request){
    		$query=trim($request->get('searchText'));
    		$movimiento=DB::table('movimiento as mov')
    		->join('artefacto as as art','mov.id','=','art.id')
    		->join('detalle_movimiento as dm','mov.id','=','mov.idingreso')
    		->select('mov.id','mov.fecha_hora','mov.nombre','mov.estado')
    		->where('art.nombre','LIKE','%'.$query.'%')
    		->orderBy('mov.id','desc')
    		->groupBy('mov.id','i.fecha_hora','art.nombre','i.estado')
    		->paginate(7);
    		return view('movimiento.index',["moviemientos"=>$movimiento,"searchText"=>$query]);
    	}
    }
    public function create(){
    	$persona=DB::table('persona')->where('tipo_persona','=','Proveedor')->get();
    	$articulos=DB::table('articulo as art')
    	->select(DB::raw('CONCAT(art.codigo, " ",art.nombre) AS articulo'),'art.idarticulo')
    	->where('art.estado','=','Activo')
    	->get();
    	return view("moviemiento.movimiento.create",["personas"=>$persona,"articulos"=>$articulos]);
    }
    public function store(IngresoFormRequest $request){
        try {
            DB::beginTransaction();
            $ingreso = new Ingreso;
            $mytime = Carbon::now();
            $ingreso->fecha_hora = $mytime->toDateTimeString();
            $movimiento->observaciones=$request->get('observaciones');
            $movimiento->tipo=$request->get('tipo');
            $ingreso->estado='A';
            $ingreso->save();

            $idartefacto=$request->get('idartefacto');
            $cantidad = $request->get('cantidad');

            //recorre los articulos agregados
            $cont = 0;
            while ($cont < count($idartefacto)) {
                # code...
                $detalle = new DetalleMovimiento();
                $detalle->idingreso=$ingreso->idingreso;
                $detalle->idarticulo=$idartefacto[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->save();
                $cont=$cont+1;
            }
            DB::commit();
         } catch (\Exception $e) {
            DB::rollback(); 
        }
           
        return Redirect::to('compras/ingreso');
    }
    public function show($id){
        $movimiento=DB::table('movimiento as i')
            ->join('persona as p','i.idproveedor','=','p.idpersona')
            ->join('detalle_movimiento as di','i.idmovimiento','=','di.idmovimiento')
            ->select('i.idmovimiento','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precio_compra) as total'))
            ->where('i.idmovimiento','=',$id)
             ->groupBy('i.idmovimiento','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante', 'i.num_comprobante','i.impuesto','i.estado')
            ->first();
            $detalles=DB::table('detalle_movimiento as d')
            ->join('articulo as a', 'd.idarticulo','=', 'a.idarticulo')
            ->select('a.nombre as articulo','d.cantidad', 'd.precio_compra', 'd.precio_venta')
            ->where('d.idmovimiento','=',$id)

            ->get();//obengo todos los detalles;
            return view("compras.movimiento.show",["movimiento"=>$movimiento,"detalles"=>$detalles]);
    }
    public function destroy($id){
        $movimiento=movimiento::findOrFail($id); //coincida con el id
        $movimiento->Estado='C';
        $movimiento->update();
        return Redirect::to('compras/movimiento');
    }
}
