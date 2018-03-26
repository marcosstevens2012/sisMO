@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>LISTAS DE TAREAS<a href="lista/create"><button class="btn btn-success">Nueva</button></a></h3>
			@include('lista.lista.search')
		</div>
	</div>
	@if(Session::has('notice'))<!-- crea una alerta de q ha sido creado correctamente el usuario-->
   					<div class="alert alert-info">
   					<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    				<strong>Notice:</strong> {{Session::get('notice')}}</div>
    @endif

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table id="example1" class="table table-striped table-bordered table-condensed table-hover">
					<thead>
						<th>Hora inicio</th> 
						<th>Hora fin</th>
						<th>Estado</th>
						<th>Opciones</th>
						
					</thead>
					<!-- bucle -->
					@foreach ($lista as $lis)
					<tr>
						<td>{{$lis->hora_inicio}}</td>
						<td>{{$lis->hora_fin}}</td>
						<td>{{$lis->estado}}</td>
						<td>
							<a href="{{URL::action('ListaController@edit', $lis->id)}}"><button class="btn btn-info">Editar</button></a>
							<a href="{{URL::action('ListaController@edit', $lis->id)}}"><button class="btn btn-info">Ver Lista</button></a>
							<a href="" data-target="#modal-delete-{{$lis->id}}" data-toggle="modal"><button class="btn btn-danger"> Eliminar</button></a>
						</td>
					</tr>
					@include('lista.lista.modal')
					@endforeach
					
				</table>
				
			</div>
						
		</div>
	</div>

<script type="text/javascript">
$(document).ready(function(){
    $('#example1').DataTable();
});

</script>
@endsection
