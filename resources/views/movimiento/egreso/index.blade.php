@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>LISTADO DE egresoS <a href="egreso/create"><button class="btn btn-success">Nuevo</button></a></h3>
			@include('movimiento.egreso.search')
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table id="example1" class="table table-striped table-bordered table-condensed table-hover">
					<thead>
						<th>Fecha</th>
						<th>Tipo</th>
						<th>Estado</th>
						<th>Observaciones</th>
						<th>Opciones</th>

					</thead>
					<!-- bucle -->
					@foreach ($egresos as $mov)
					<tr>
						<td>{{$mov->fecha_hora}}</td>
						<td>{{$mov->tipo}}</td>
						<td>{{$mov->estado}}</td>
						<td>{{$mov->observaciones}}</td>
						<td>
							<a href="{{URL::action('egresoController@show', $mov->id)}}"><button class="btn btn-info"> Detalles</button></a>
							<a href="" data-target="#modal-delete-{{$mov->id}}" data-toggle="modal"><button class="btn btn-danger"> Anular</button></a>
						</td>
					</tr>
					@include('movimiento.egreso.modal')
					@endforeach
					
				</table>
				
			</div>
			{{$egresos->render()}}
			
		</div>
	</div>

	<script type="text/javascript">
$(document).ready(function(){
    $('#example1').DataTable();
});

</script>
@endsection