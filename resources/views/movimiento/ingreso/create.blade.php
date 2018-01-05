@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo ingreso</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
					@endforeach
				</ul>
			</div>
			@endif
		</div>
	</div>
	{!! Form::open(array('url'=>'movimiento/movimiento', 'method'=>'POST', 'autocomplete'=>'off'))!!}
	{{Form::token()}}

	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-body">
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
					<div class="form-group">
						<label>Artefacto</label>
						<select name="pidartefacto" id="pidartefacto" class="form-control selectpicker" data-live-search="true">
							@foreach($artefactos as $artefacto)
								<option value="{{$artefacto->ida}}">{{$artefacto->artefacto}}</option>
							@endforeach	
						</select>
					</div>
				</div>

				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
					<div class="form-group">
						<label for="cantidad">Cantidad</label>
						<input type="number" name="pcantidad" id="pcantidad" class="form-control " placeholder="cantidad">
					</div>
				</div>

				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
					<div class="form-group">
						<button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
					</div>
				</div>

				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<table id="detalles" class="table table-striped table-bordered table-condensed">
						<thead style="background-color: #ccc">
							<th>Opciones</th>
							<th>Artefacto</th>
							<th>Cantidad</th>
						</thead>
						<tfoot>
							<th></th>
							<th></th>
							<th></th>
						</tfoot>
						<tbody>
						
						</tbody>
					</table>
				</div>
			</div>
			
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" id="guardar">
			<div class="form-group">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<button class="btn btn-primary" type="submit">Guardar</button>
				<button class="btn btn-danger" type="reset">Cancelar</button>
			</div>
		</div>


	</div>
	{!!Form::close() !!}


	<script src="{{asset('js/jQuery-3.1.1.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/jquery-3.2.0.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
	

	<script type="text/javascript">
		$(document).ready(function($){
			$('#pprecio_compra').mask("#.##0,00", {reverse: true});
			$('#pprecio_venta').mask("#.##0,00", {reverse: true});
		})
	</script>


	@push ('scripts') <!-- Trabajar con el script definido en el layout-->
	<script>
		$(document).ready(function(){
			$('#bt_add').click(function(){
				agregar();
			});
		});
		var cont=0;
		var total = 0;
		subtotal=[];
		$('#guardar').hide();

		function agregar(){
			idartefacto = $('#pidartefacto').val();
			artefacto = $('#pidartefacto option:selected').text();
			cantidad = $('#pcantidad').val();
			if(idartefacto !="" && cantidad !=""){
				var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+')" >X</button></td><td><input type="hidden" name="idartefacto[]" value="'+idartefacto+'">'+artefacto+'</td><td><input type="number" name="cantidad[]" value="'+cantidad+'"></td></tr>';
				cont++;
				limpiar();
				$('#total').html("$ " + parseFloat(total));
				evaluar();
				$('#detalles').append(fila);
			}else{
				alert("Error al ingresar el detalle del ingreso, revise los datos del artefacto");
			}


		}
		function limpiar(){
			$('#pcantidad').val("");
			$('#pprecio_compra').val("");
			$('#pprecio_venta').val("");
		}

		function evaluar(){
			if (total>0) {
				$('#guardar').show();
			}
			else{
				$('#guardar').hide();
			}
		}
		function eliminar(index){
			total=total-subtotal[index];
			$("#total").html("$ " + total);
			$("#fila" + index).remove();
			evaluar();
		}
	</script>
	@endpush

@endsection