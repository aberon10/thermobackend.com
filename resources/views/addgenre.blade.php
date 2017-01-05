@extends('layouts.app')

{{-- Menu Vertical --}}
@extends('layouts.menuapp')

@section('content')
    <div class="ed-container">
        <div class="ed-item">
            <div class="main-container">

				<div class="panel panel-middle">
					<div class="panel__heading">Añadir Nuevo Genero</div>
					<div class="panel__body">
						<form action="{{url('/genres/add')}}" method="POST" class="form" id="form-addgenre" enctype="multipart/form-data">
							{{csrf_field()}}
							<div class="form-group">
								<label for="nombre_genero" class="label">Nombre</label>
								<input type="text" class="input" name="nombre_genero" id="nombre_genero" placeholder="Nombre" value="{{old('nombre_genero')}}">
								<p class="message"></p>
								<p class="info"> Utiliza sólo: letras, números, guiones, puntos, espacios y el signo &.</p>
							</div>
							<div class="form-group">
								<label for="descripcion" class="label">Descripción (Opcional)</label>
								<textarea name="descripcion" id="descripcion" cols="30" rows="80" class="input" maxlength="250"></textarea>
							</div>
							{{-- DROP ZONE --}}
							<div class="preview" id="drop-zone">
								<span class="icon-upload-cloud preview__icon"></spsan>
							</div>
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
@section('id_button_accept', 'add_genere')

{{-- Scripts --}}
@section('scripts')
	<script src="{{url('/js/libs/jquery.min.js')}}"></script>
	<script src="{{url('/js/utilities/utilities.js')}}"></script>
	<script src="{{url('/js/validations/validations.js')}}"></script>
	<script src="{{url('/js/validations/uploadFile.js')}}"></script>
	<script src="{{url('/js/genres.js')}}"></script>
@endsection
