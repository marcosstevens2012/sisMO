@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Cargar Lista</h3>
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
	{!!Form::model($lista, ['method'=>'PATCH', 'route'=>['lista.update', $lista->id],'files'=>'true'])!!}
	{{Form::token()}}
		
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="table-responsive">
					<table id="example1" class="table table-striped table-bordered table-condensed table-hover">
						<thead style="background-color: #ccc">
							<th>Tarea</th>
							<th>Estado</th>
							<th>Observaciones</th>
						</thead>
						<tfoot>
							<th></th>
							<th></th>
						</tfoot>
						<tbody>
							@foreach($detalles as $det)
							<tr>
								<td style="display: none"><input type="number" name="id[]" readonly value="{{$det->id}}">
								<td style="display: none"><input type="number" name="idtarea[]" readonly value="{{$det->idtarea}}">
								<td><input type="text" name="tarea[]" id="tarea" value="{{$det->tarea}}" readonly></td>
								<td><input type="checkbox" name="estado[]" style="transform: scale(2.0);"></input></td>
								<td><textarea name="observaciones[]" id="observaciones" >{{$det->observaciones}}</textarea></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
					<div class="form-group">
						<button class="btn btn-primary" type="submit">Guardar</button>
						<button class="btn btn-danger" type="reset">Cancelar</button>
					</div>
				</div>
			</div>		
	</div>
	{!!Form::close() !!}
@endsection
