@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>NUEVO ARTEFACTO</h3>
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
	{!! Form::open(array('url'=>'artefacto/artefacto', 'method'=>'POST', 'autocomplete'=>'off', 'files'=>'true'))!!}
	{{Form::token()}}
	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" style="text-transform:uppercase;" onkeyup="aMays(event, this)" onblur="aMays(event, this)" required value="{{old('nombre')}}" class="form-control" placeholder="Nombre">
			</div>
		</div>

		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
					<div class="form-group">
						<label>Categoria</label>
						<select name="categoria" id="categoria" class="form-control selectpicker" data-live-search="true">
							@foreach($categorias as $cat)
								<option value="{{$cat->idcategoria}}">{{$cat->nombre}}</option>
							@endforeach	
						</select>
					</div>
		</div>

		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
				<div class="form-group">
					<label>Estado Fisico</label>
						<select name="estadof" id="estadof" class="form-control selectpicker" data-live-search="true">
							
						<option value="MUY BUENO">MUY BUENO</option>
						<option value="BUENO">BUENO</option>
						<option value="REGULAR">REGULAR</option>
						<option value="MALO">MALO</option>
						<option value="MUY MALO">MUY MALO</option>
							
						</select>
				</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="descripcion">Detalles</label>
				<input type="text" name="descripcion" style="text-transform:uppercase;" onkeyup="aMays(event, this)" onblur="aMays(event, this)" required value="{{old('descripcion')}}" class="form-control" placeholder="Descripcion">
			</div>
			
		</div>

		<div class="col-md-6 col-md-offset-3">
			<div class="col-md-6 col-md-offset-3">
			<div class="form-group">
				<button class="btn btn-primary" type="submit">Guardar</button>
				<button class="btn btn-danger" type="reset">Cancelar</button>
			</div>
		</div>
		</div>


	</div>
	{!!Form::close() !!}

<script type="text/javascript">




function aMays(e, elemento) {
tecla=(document.all) ? e.keyCode : e.which; 
 elemento.value = elemento.value.toUpperCase();
}

</script>
@endsection