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
						<form action="{{url('/artists/update/'.$artist->id_artista)}}" method="POST" class="form" id="form-add" enctype="multipart/form-data">
							{{csrf_field()}}
							<div class="form-group">
								<label for="nombre" class="label">Nombre</label>
								<input type="text" class="input" name="nombre" id="nombre" placeholder="Nombre"
								value="{{(old('nombre')) ? old('nombre') : $artist->nombre_artista }}">
								<p class="message">Utiliza sólo: letras, números, guiones, puntos, espacios y el signo &.</p>
							</div>
							<div class="form-group">
								<label for="select-item" class="label">Genero</label>
								<select class="input" name="select-item" id="select-item">
									<option value="">Selecciona un genero...</option>
									@foreach($genres as $g)
										@if ($g->id_genero == $genre->id_genero)
											<option value="{{$g->id_genero}}" selected>{{$g->nombre_genero}}</option>
										@else
											<option value="{{$g->id_genero}}">{{$g->nombre_genero}}</option>
										@endif
									@endforeach
								</select>
								<p class="message"></p>
							</div>
							{{-- DROP ZONE --}}
							<div class="preview" id="drop-zone">
								<span class="icon-upload-cloud preview__icon"></span>
								<a href="#" class="button button-alice preview__button" id="button-file">Seleccionar archivo</a>
								<input type="file" class="hide" id="file" name="file">
								<p class="error-uploaded"></p>
								<h2 class="preview__title">Arrastra tu archivo aquí</h2>
								<img src="{{url('/storage/'.$img_artist->src_img)}}" alt="" id="preview-element">
								<h4 class="name_file hide"></h4>
							</div>
							<div class="loading"></div>
							<input type="submit" class="hide">
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
@section('url_button_cancel', url('/artists/'))
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
