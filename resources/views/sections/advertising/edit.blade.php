@extends('layouts.app')
{{-- Titulo de la seccion izquierda--}}
@section('title_left', config('config_app.sections_title.edit_advertising'))

{{-- Menu Vertical --}}
@extends('layouts.menuapp')
@section('page_content')
{{-- FORMULARIO --}}
<div class="panel panel-middle">
	<div class="panel__heading">
		{{config('config_app.sections_title.edit_advertising')}}
	</div>
	<div class="panel__body">
		<form class="form" id="form-advertising" method="POST" action="#">
			{{csrf_field()}}
			@if ( preg_match("/^(\/advertising\/edit\/){1}[0-9]{1,}$/", $_SERVER['REQUEST_URI']) )
				<input type="hidden" name="_id" value="{{$advertising->id_publicidad}}">
			@endif
			<div class="form-group">
				<label class="label" for="title">Nombre</label>
				<input type="text" class="input" id="name" name="name" placeholder="Nombre de la publicidad" value="{{$advertising->nombre_publicidad}}">
				<p class="error"></p>
			</div>
			<div class="form-group">
				<select class="input select" id="type-advetising" name="type">
					<option value="">Tipo de publicidad...</option>
					<option value="audio" <?php if($advertising->id_tipo_publicidad == 1){echo 'selected';}?>>Audio</option>
					<option value="image" <?php if($advertising->id_tipo_publicidad == 2){echo 'selected';}?>>Banner</option>
				</select>
				<p class="error"></p>
			</div>
			<div class="form-group hide">
				{{-- DROP ZONE --}}
				<div class="preview" id="drop-zone">
					<span class="icon-upload-cloud preview__icon"></span>
				</div>
			</div>
			<div class="form-group">
				<button type="submit" class="button button-alice">Guardar</button>
			</div>
		</form>
	</div>
</div>
@endsection

@extends('layouts.footerapp')
