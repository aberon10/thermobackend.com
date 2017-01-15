<div class="ed-container">
	<div class="ed-item">
		<div class="main-container">
			<div class="panel panel-middle">
				<div class="panel__heading">{{$panel_title}}</div>
				<div class="panel__body">
					<form action="#" method="POST" class="form" id="form-add" enctype="multipart/form-data">
						{{csrf_field()}}
						<div class="form-group">
							<label for="nombre" class="label">Nombre</label>
							<input type="text" class="input" name="nombre" id="nombre" placeholder="Nombre" value="{{old('nombre')}}" autofocus>
							<p class="message">Utiliza sólo caracteres alfanumericos, guiones, puntos, espacios, comillas y el signo &.</p>
						</div>
						@if ($_SERVER['REQUEST_URI'] != '/genres/add')
							<div class="form-group">
								<label for="select-item" class="label">{{$label_select}}</label>
								<select class="input" name="select-item" id="select-item">
									@if (isset($genres))
										<option value="">Selecciona un genero...</option>
										@foreach($genres as $genre)
										<option value="{{$genre->id_genero}}">{{$genre->nombre_genero}}</option>
										@endforeach
									@elseif (isset($artists))
										<option value="">Selecciona un artista...</option>
										@foreach($artists as $artist)
										<option value="{{$artist->id_artista}}">{{$artist->nombre_artista}}</option>
										@endforeach
									@elseif (isset($albums))
											//
									@endif
								</select>
								<p class="message"></p>
							</div>
						@endif
						@if ($_SERVER['REQUEST_URI'] == '/genres/add')
						<div class="form-group">
							<label for="descripcion" class="label">Descripción (Opcional)</label>
							<textarea name="descripcion" id="descripcion" cols="30" rows="80" class="input" maxlength="250"
							value="{{old('descripcion')}}"></textarea>
							<p class="message"></p>
						</div>
						@endif
						@if ($_SERVER['REQUEST_URI'] == '/albums/add')
							<div class="form-group">
								<label class="label" for="cantidad_pistas">Cantidad de Pistas</label>
								<input class="input" type="number" min="1" max="100" name="cantidad_pistas" id="cantidad_pistas"></input>
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
										echo "<option value=\"$i\">$i</option>";
									}
								?>
								</select>
								<p class="message"></p>
							</div>
						@endif
						{{-- DROP ZONE --}}
						<div class="preview" id="drop-zone">
							<span class="icon-upload-cloud preview__icon"></span>
						</div>
						<input type="submit" class="hide">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
