@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>NUEVA LISTA</h3>
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
	{!! Form::open(array('url'=>'lista/lista', 'method'=>'POST', 'autocomplete'=>'off', 'files'=>'true'))!!}
	{{Form::token()}}
	<div class="row">
		
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
					<div class="form-group">
						<label>Usuario</label>
						<select name="pidusuario" id="pidusuario" class="form-control selectpicker" data-live-search="true">
							<option>Seleccione</option>
							@foreach($user as $use)
								<option value="{{$use->id}}">{{$use->name}}</option>
							@endforeach	
						</select>
					</div>
				</div>

				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
					<div class="form-group">
						<label for="nombre">Hora Inicio</label>
						<input type="time" id="hora_inicio" name="hora_inicio" required value="{{old('hora_inicio')}}" class="form-control" >
					</div>
				</div>

				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
					<div class="form-group">
						<label for="hora_fin">Hora Fin</label>
						<input type="time" id="hora_fin" name="hora_fin" required value="{{old('hora_fin')}}" class="form-control" >
					</div>
				</div>

	</div>
	<div class="row">

		<div class="panel panel-primary">
			<div class="panel-body">

				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
					<div class="form-group">
						<label>Tarea</label>
						<select name="pptarea" id="pptarea" class="form-control selectpicker" data-live-search="true">
							<option class="disable" value="0">Seleccione</option>
							@foreach($tarea as $t)
								<option value="{{$t->id}}">{{$t->nombre}}</option>
							@endforeach	
						</select>
					</div>
				</div>

				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
					<div class="form-group">
						<label for="nombre">Crear Nueva</label>
						<input type="text" id="ptarea" name="ptarea" style="text-transform:uppercase;" onkeyup="aMays(event, this)" onblur="aMays(event, this)" value="{{old('ptarea')}}" class="form-control" placeholder="Nombre de Tarea">
					</div>
				</div>

				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<div class="form-group">
						<label for="cantidad">Observaciones</label>
						<textarea id="observaciones" name="observaciones" class="form-control " placeholder="Observaciones" style="resize: none"></textarea> 
					</div>
				</div>

				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
					<div class="form-group">
						<button type="button" hidden="false" id="bt_add" class="btn btn-primary">Agregar</button>
					</div>
				</div>

				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<table id="detalles" class="table table-striped table-bordered table-condensed">
						<thead style="background-color: #ccc">
							<th>Opciones</th>
							<th>Nombre</th>
							<th>Observaciones</th>
						</thead>
						<tfoot>
							<th></th>
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
	


	@push ('scripts') 
	

			<!-- Trabajar con el script definido en el layout-->
	<script>
		$(document).ready(function(){
			$('#bt_add').click(function(){
				agregar();
			});
		});

		var cont=0;
		$('#ptarea').disable();

		function agregar(){
			pidtarea = $('#pptarea').val();
			tarea = $('#pptarea option:selected').text();

			ptarea = $('#ptarea').val();
			obs = $('#observaciones').val();
			
			if(pidtarea !="0" ){
				var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+')" >X</button></td><td><input type="hidden" name="nombre[]" value="'+pidtarea+'">'+tarea+'</td><td><textarea type="hidden" name="pobservaciones[]" value="'+obs+'">'+obs+'</textarea></td></tr>';
				cont++;
				limpiar();
				
				$('#detalles').append(fila);

			}else if (ptarea !=""){
				
				var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+')" >X</button></td><td><input type="hidden" name="nuevonombre[]" value="'+ptarea+'">'+ptarea+'</td><td><textarea type="hidden" name="pobservacioness[]" value="'+obs+'">'+obs+'</textarea></td></tr>';
				cont++;
				limpiar();
				
				$('#detalles').append(fila);
			}else{
				alert("Error al ingresar el detalle del movimiento, revise los datos del artefacto");
			}


		}
		function limpiar(){
			$('#ptarea').val("");
			$('#observaciones').val("");
			
		}

		function eliminar(index){
			$("#fila" + index).remove();
			
		}
	</script>
	@endpush



	<script type="text/javascript">

	function aMays(e, elemento) {
	tecla=(document.all) ? e.keyCode : e.which; 
	 elemento.value = elemento.value.toUpperCase();
	}

	</script>
@endsection