@extends('layouts.app')

{{-- Menu Vertical --}}
@extends('layouts.menuapp')

@section('content')
	<div class="ed-container">
		<div class="ed-item">
			<div class="main-container">
				<div class="panel panel-middle">
					<div class="panel__heading">{{$panel_title}}</div>
					<div class="panel__body">
						<form action="{{url('/genres/update/'.$data_genre[0]->id_genero)}}" method="POST" class="form" id="form-add" enctype="multipart/form-data">
							{{csrf_field()}}
							<div class="form-group">
								<label for="nombre" class="label">Nombre</label>
								<input type="text" class="input" name="nombre" id="nombre" placeholder="Nombre"
								value="{{(old('nombre')) ? old('nombre') : $data_genre[0]->nombre_genero }}">
								<p class="message">Utiliza sólo: letras, números, guiones, puntos, espacios y el signo &.</p>
							</div>
							<div class="form-group">
								<label for="descripcion" class="label">Descripción (Opcional)</label>
								<textarea name="descripcion" id="descripcion" cols="30" rows="80" class="input" maxlength="250"
								value="{{(old('descripcion')) ? old('descripcion') : $data_genre[0]->descripcion }}"></textarea>
								<p class="message"></p>
							</div>
							{{-- DROP ZONE --}}
							<div class="preview" id="drop-zone">
								<span class="icon-upload-cloud preview__icon"></span>
								<a href="#" class="button button-alice preview__button" id="button-file">Seleccionar archivo</a>
								<input type="file" class="hide" id="file" name="file">
								<p class="error-uploaded"></p>
								<h2 class="preview__title">Arrastra tu archivo aquí</h2>
								<img src="{{url('/storage/'.$img_genre[0]->src_img)}}" alt="" id="preview-element">
								<h4 class="name_file hide"></h4>
							</div>
							<div class="loading"></div>
							<input type="submit" class="hide" id="button-form">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

{{-- Footer --}}
@extends('layouts.footerapp')

{{-- Defino los id de los botones --}}
@section('id_button_cancel', '')
@section('url_button_cancel', url('/genres/'))
@section('id_button_accept', 'add')
@section('text_button_accept', 'Guardar Cambios')

{{-- Scripts --}}
@section('scripts')
	<script src="{{url('/js/utilities/ajax.js')}}"></script>
	<script src="{{url('/js/utilities/utilities.js')}}"></script>
	<script src="{{url('/js/validations/validations.js')}}"></script>
	<script src="{{url('/js/validations/upload-file.js')}}"></script>
	<script src="{{url('/js/music-config.js')}}"></script>
	<script src="{{url('/js/music-add-edit.js')}}"></script>
	<script src="{{url('/js/music-init.js')}}"></script>
@endsection
