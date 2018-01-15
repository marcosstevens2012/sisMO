@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>INVENTARIO DE ARTEFACTOS <a href="artefacto/create"><button class="btn btn-success">Nuevo</button></a></h3>
			@include('artefacto.artefacto.search')
		</div>
	</div>
	@if(Session::has('notice'))<!-- crea una alerta de q ha sido creado correctamente el usuario-->
                
   					<div class="alert alert-info">{{ Session::get('notice') }}</div>
				
        @endif

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table id="example1" class="table table-striped table-bordered table-condensed table-hover">
					<thead>
						<th>Nombre</th> 
						<th>Estado</th>
						<th>Estado Fisico</th>
						<th>Opciones</th>
						
					</thead>
					<!-- bucle -->
					@foreach ($artefactos as $ins)
					<tr>
						<td>{{$ins->nombre}}</td>
						<td>{{$ins->estado}}</td>
						<td>{{$ins->estadof}}</td>
						<td>
							<a href="{{URL::action('InventarioController@edit', $ins->id)}}"><button class="btn btn-info"> Editar</button></a>
							<a href="" data-target="#modal-delete-{{$ins->id}}" data-toggle="modal"><button class="btn btn-danger"> Eliminar</button></a>
						</td>
					</tr>
					@include('artefacto.artefacto.modal')
					@endforeach
					
				</table>
				
			</div>
			{{$artefactos->render()}}
			
		</div>
	</div>

<script type="text/javascript">
$(document).ready(function(){
    $('#example1').DataTable();
});

</script>
@endsection
