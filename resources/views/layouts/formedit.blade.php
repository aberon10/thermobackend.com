@section('page_content')
<div class="panel panel-middle">
	<div class="panel__heading">@yield('panel_heading')</div>
	<div class="panel__body">
		<form action="" method="POST" class="form" id="form-add" enctype="multipart/form-data">
			{{csrf_field()}}

			<div class="form-group">
				<label for="nombre" class="label">Nombre</label>
				<input type="text" class="input" name="nombre" id="nombre" placeholder="Nombre"
				value="{{(old('nombre')) ? old('nombre') : $name }}">
				<p class="message">Utiliza sólo: letras, números, guiones, puntos, espacios y el signo &.</p>
			</div>

			@if (!preg_match('/^(\/genres\/edit\/[0-9]{1,})+$/', $_SERVER['REQUEST_URI']))
				<div class="form-group">
					<label for="select-item" class="label">{{(isset($label_select)) ? $label_select : ''}}</label>
					<select class="input" name="select-item" id="select-item">
						@if (isset($genres))
							<option value="">Selecciona un genero...</option>
							@foreach($genres as $g)
								@if ($g->id_genero == $genre->id_genero)
									<option value="{{$g->id_genero}}" selected>{{$g->nombre_genero}}</option>
								@else
									<option value="{{$g->id_genero}}">{{$g->nombre_genero}}</option>
								@endif
							@endforeach
						@elseif (isset($artists))
							<option value="">Selecciona un artista...</option>
							@foreach($artists as $a)
								@if ($a->id_artista == $main_data->id_artista)
									<option value="{{$a->id_artista}}" selected>{{$a->nombre_artista}}</option>
								@else
									<option value="{{$a->id_artista}}">{{$a->nombre_artista}}</option>
								@endif
							@endforeach
						@elseif (isset($albums))
							<option value="">Selecciona un album...</option>
							@foreach($albums as $a)
								@if ($a->id_album == $main_data->id_album)
									<option value="{{$a->id_album}}" selected>{{$a->nombre}}</option>
								@else
									<option value="{{$a->id_album}}">{{$a->nombre}}</option>
								@endif
							@endforeach
						@endif
					</select>
					<p class="message"></p>
				</div>
			@endif

			{{-- ALBUM --}}
			@if (preg_match('/^(\/albums\/edit\/[0-9]{1,})+$/', $_SERVER['REQUEST_URI']))
				<div class="form-group">
					<label class="label" for="cantidad_pistas">Cantidad de Pistas</label>
					<input class="input" type="number" min="1" max="100" name="cantidad_pistas" id="cantidad_pistas" value="{{$main_data->cant_pistas}}"></input>
					<p class="message"></p>
				</div>
				<div class="form-group">
					<label class="label" for="anio">Año de Lanzamiento</label>
					<select class="input" name="anio" id="anio">
						<option value="">Año de Lanzamiento...</option>
						<?php
							$current_year = date('Y');
							$init_year = 1920;
							for ($i = $current_year; $i > $init_year; $i--) {
								if ($i == $main_data->anio) {
									echo "<option value=\"$i\" selected>$i</option>";
								} else {
									echo "<option value=\"$i\">$i</option>";
								}
							}
						?>
					</select>
					<p class="message"></p>
				</div>
			@endif

			{{-- DROP ZONE --}}
			<div class="preview" id="drop-zone">
				<span class="icon-upload-cloud preview__icon"></span>
				<a href="#" class="button button-alice preview__button" id="button-file">Seleccionar archivo</a>
				<input type="file" class="hide" id="file" name="file">
				<p class="error-uploaded"></p>
				<h2 class="preview__title">Arrastra tu archivo aquí</h2>

				@if (preg_match('/^(\/tracks\/edit\/[0-9]{1,})+$/', $_SERVER['REQUEST_URI']))
					<div class="player">
						<audio id="preview-element" src="{{url('/storage/'.$main_data->src_audio)}}" type="{{$type}}" controls></audio>
						<div class="mask"></div>
					</div>
				@else
					<img src="{{url('/storage/'.$img->src_img)}}" alt="{{$name}}" id="preview-element">
				@endif

				<h4 class="name_file hide"></h4>
			</div>
			<div class="loading"></div>
			<input type="submit" class="hide">
		</form>
	</div>
</div>
@endsection
