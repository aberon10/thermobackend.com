@extends('layouts.app')

{{-- Menu Vertical --}}
@extends('layouts.menuapp')

@section('content')
	<div class="ed-container">
		<div class="ed-item">
			<div class="main-container">
				<div class="panel panel-middle">
					<div class="panel__heading">Actualizar Genero</div>
					<div class="panel__body">
						<form action="{{url('/genres/update/'.$data_genre[0]->id_genero)}}" method="POST" class="form" id="form-addgenre" enctype="multipart/form-data">
							{{csrf_field()}}
							<div class="form-group">
								<label for="nombre_genero" class="label">Nombre</label>
								<input type="text" class="input" name="nombre_genero" id="nombre_genero" placeholder="Nombre"
								value="{{(old('nombre_genero')) ? old('nombre_genero') : $data_genre[0]->nombre_genero }}">
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
							<input type="submit" class="hide" id="button-addgenre">
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
@section('id_button_accept', 'add_genere')
@section('text_button_accept', 'Guardar Cambios')

{{-- Scripts --}}
@section('scripts')
	<script src="{{url('/js/utilities/ajax.js')}}"></script>
	<script src="{{url('/js/utilities/utilities.js')}}"></script>
	<script src="{{url('/js/validations/validations.js')}}"></script>
	<script src="{{url('/js/validations/uploadFile.js')}}"></script>
	<script src="{{url('/js/genres.js')}}"></script>
@endsection
