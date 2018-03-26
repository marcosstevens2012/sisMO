@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar artefacto {{$artefacto->nombre}}</h3>
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
	{!!Form::model($artefacto, ['method'=>'PATCH', 'route'=>['artefacto.update', $artefacto->id],'files'=>'true'])!!}
	{{Form::token()}}
	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-4">
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" required value="{{$artefacto->nombre}}" class="form-control" placeholder="Nombre">
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="stock">Stock</label>
				<input type="text" name="stock" required value="{{$artefacto->stock}}" class="form-control" placeholder="Stock">
			</div>
			
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="estado">Estado</label>
				<select name="estado" id="estado" class="form-control " data-live-search="true"  >
					@if ($artefacto->estado=='Activo')
					<option value="Activo" selected>Activo</option>
					<option value="Inactivo">Inactivo</option>
					@elseif  ($artefacto->estado=='Inactivo')
					<option value="Activo">Activo</option>
					<option value="Inactivo" selected>Inactivo</option>
					@endif
				</select>
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="descripcion">Descripcion</label>
				<input type="text" name="descripcion" style="text-transform:uppercase;" onkeyup="aMays(event, this)" onblur="aMays(event, this)" required value="{{$artefacto->descripcion}}" class="form-control" placeholder="Descripcion">
			</div>
			
		</div>
		

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<button class="btn btn-primary" type="submit">Guardar</button>
				<button class="btn btn-danger" type="reset">Cancelar</button>
			</div>
		</div>
	</div>
	{!!Form::close() !!}
@endsection
