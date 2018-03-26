@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nueva Entrada</h3>
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
	{!! Form::open(array('url'=>'movimiento/ingreso', 'method'=>'POST', 'autocomplete'=>'off'))!!}
	{{Form::token()}}

	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-body">

				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
					<div class="form-group">
						<label>Usuario</label>
						<select name="usuario" id="usuario" class="usuario form-control selectpicker" data-live-search="true">
							<option>Seleccione</option>
							@foreach($user as $use)
								<option value="{{$use->id}}">{{$use->name}}</option>
							@endforeach	
						</select>
					</div>
				</div>


				
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
					<div class="form-group">
						<label for="fecha">Artefacto</label>
						<select name="artefacto" id="artefacto" class="artefacto form-control" >
							
						</select>
					</div>
				</div>

				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
					<div class="form-group">
						<label>Estado entrada</label>
						<select name="estado" id="estado" class="estado form-control selectpicker" data-live-search="true" required>
							<option selected="Seleccione Estado">Seleccione Estado</option>
							@foreach($estado as $est)
							<option value="{{$est->id}}">{{$est->nombre}}</option>
							@endforeach	
						</select>
					</div>
				</div>

				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<div class="form-group">
						<label for="cantidad">Observaciones</label>
						<textarea id="observaciones" name="observaciones" class="form-control " placeholder="observaciones" style="resize: none"></textarea> 
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
							<th>Estado</th>
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

		

					
		<input type="number" name="idcategoria" id="idcategoria" class hidden="form-control " placeholder="categoria">
					
		
			
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
	<script>
	$('#pidartefacto').change(mostrarValores);
		
		function mostrarValores(){
			datosArtefacto = document.getElementById('pidartefacto').value.split('_');
			$('#idcategoria').val(datosArtefacto[1]);
			$('#idartefacto').val(datosArtefacto[0]);

		}
	</script>

			<!-- Trabajar con el script definido en el layout-->
	<script>
		$(document).ready(function(){
			$('#bt_add').click(function(){
				agregar();
			});
		});

		var cont=0;
		
		function agregar(){
			idartefacto = $('#artefacto').val();
			artefacto = $('#artefacto option:selected').text();
			idestado = $('#estado').val();
			estado = $('#estado option:selected').text();
			obs = $('#observaciones').val();

			if(idartefacto !=""){
				var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+')" >X</button></td><td><input type="hidden" name="idartefacto[]" value="'+idartefacto+'">'+artefacto+'</td><td><input type="hidden" name="estado[]" value="'+idestado+'">'+estado+'</td><td><textarea type="hidden" name="pobservaciones[]" value="'+obs+'">'+obs+'</textarea></tr>';
				cont++;
				limpiar();
				console.log(idartefacto);
				console.log(artefacto);
				$('#detalles').append(fila);
			}else{
				alert("Error al ingresar el detalle del movimiento, revise los datos del artefacto");
			}


		}
		function limpiar(){
			$('#pidartefacto').val("");
			
		}

		function eliminar(index){
			$("#fila" + index).remove();
			
		}
	</script>

	<script type="text/javascript">
    $(document).ready(function(){

        $(document).on('change','.usuario',function(e){
        	e.stopPropagation();
            //console.log("hmm its change");

            var iduser=$(this).val();
            var div=$(this).parent();

            var select = document.getElementById("artefacto");
			var length = select.options.length;
			for (i = 0; i < length; i++) {
			  select.options[i] = null;
			}
			    

            $.ajax({
                type:'get',
                url:'{!!URL::to('buscarEgreso')!!}',
                data:{'id':iduser},
                headers:{'X-CSFR-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                success:function(data){
               

						$.each(data, function (i, item) {
						    $('#artefacto').append($('<option>', { 
						        value: item.id,
						        text : item.nombre 
						    }));
						    console.log(item.id);
						});          
                },
                error:function(){

                }
            });

        });

    });
</script>
	@endpush

@endsection