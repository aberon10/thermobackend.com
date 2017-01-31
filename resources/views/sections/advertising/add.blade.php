@extends('layouts.app')
{{-- Titulo de la seccion izquierda--}}
@section('title_left', config('config_app.sections_title.index_advertising'))
{{-- Titulo de la seccion derecha--}}
@section('title_right')
<span class="icon-help icon-large info"></span>
@endsection
{{-- Menu Vertical --}}
@extends('layouts.menuapp')
@section('page_content')
{{-- FORMULARIO --}}
<div class="panel panel-middle">
	<div class="panel__heading">
		Nueva Publicidad
	</div>
	<div class="panel__body">
		<form class="form" id="form-advertising" method="POST" action="#">
			{{csrf_field()}}
			<div class="form-group">
				<label class="label" for="title">Nombre</label>
				<input type="text" class="input" id="name" name="name" placeholder="Nombre de la publicidad">
				<p class="error"></p>
			</div>
			<div class="form-group">
				<select class="input select" id="type-advetising" name="type">
					<option value="">Tipo de publicidad...</option>
					<option value="audio">Audio</option>
					<option value="image">Banner</option>
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
