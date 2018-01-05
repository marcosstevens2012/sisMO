<?php

namespace mol\Http\Controllers;

use Illuminate\Http\Request;
use mol\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use mol\Http\Requests\IngresoFormRequest;
use mol\Ingreso;
use mol\DetalleIngreso;

use DB;
use Carbon\Carbon; //Fecha zona horaria
use Response;
use Illuminate\Support\Collection;

class IngresoController extends Controller
{
    //constructor
    }
    public function index(Request $request){
    	if($request){
    		$query=trim($request->get('searchText'));
    		$ingreso=DB::table('movimiento as mov')
    		->join('artefacto as as art','mov.id','=','art.id')
    		->select('mov.id','mov.fecha_hora','mov.nombre','mov.estado')
    		->where('art.nombre','LIKE','%'.$query.'%')
    		->orderBy('mov.id','desc')
    		->groupBy('mov.id','i.fecha_hora','art.nombre','i.estado')
    		->paginate(7);
    		return view('movimiento.index',["ingresos"=>$ingreso,"searchText"=>$query]);
    	}
    }
    public function create(){
    	$persona=DB::table('persona')->where('tipo_persona','=','Proveedor')->get();
    	$articulos=DB::table('articulo as art')
    	->select(DB::raw('CONCAT(art.codigo, " ",art.nombre) AS articulo'),'art.idarticulo')
    	->where('art.estado','=','Activo')
    	->get();
    	return view("compras.ingreso.create",["personas"=>$persona,"articulos"=>$articulos]);
    }
    public function store(IngresoFormRequest $request){
        try {
            DB::beginTransaction();
            $ingreso = new Ingreso;
            $ingreso->idproveedor=$request->get('idproveedor');
            $ingreso->tipo_comprobante=$request->get('tipo_comprobante');
            $ingreso->serie_comprobante=$request->get('serie_comprobante');
            $ingreso->num_comprobante=$request->get('num_comprobante');
            $mytime = Carbon::now('America/Mexico_City');
            $ingreso->fecha_hora = $mytime->toDateTimeString();
            $ingreso->impuesto='18';
            $ingreso->estado='A';
            $ingreso->save();

            $idarticulo=$request->get('idarticulo');
            $cantidad = $request->get('cantidad');
            $precio_compra = $request->get('precio_compra');
            $precio_venta = $request->get('precio_venta');

            //recorre los articulos agregados
            $cont = 0;
            while ($cont < count($idarticulo)) {
                # code...
                $detalle = new DetalleIngreso();
                $detalle->idingreso=$ingreso->idingreso;
                $detalle->idarticulo=$idarticulo[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->precio_compra=$precio_compra[$cont];
                $detalle->precio_venta=$precio_venta[$cont];
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
        $ingreso=DB::table('ingreso as i')
            ->join('persona as p','i.idproveedor','=','p.idpersona')
            ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
            ->select('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado',DB::raw('sum(di.cantidad*precio_compra) as total'))
            ->where('i.idingreso','=',$id)
             ->groupBy('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante', 'i.num_comprobante','i.impuesto','i.estado')
            ->first();
            $detalles=DB::table('detalle_ingreso as d')
            ->join('articulo as a', 'd.idarticulo','=', 'a.idarticulo')
            ->select('a.nombre as articulo','d.cantidad', 'd.precio_compra', 'd.precio_venta')
            ->where('d.idingreso','=',$id)

            ->get();//obengo todos los detalles;
            return view("compras.ingreso.show",["ingreso"=>$ingreso,"detalles"=>$detalles]);
    }
    public function destroy($id){
        $ingreso=Ingreso::findOrFail($id); //coincida con el id
        $ingreso->Estado='C';
        $ingreso->update();
        return Redirect::to('compras/ingreso');
    }
}
