@extends('layouts.app')

{{-- Titulo de la seccion izquierda --}}
@section('title_left', config('config_app.sections_title.edit_user'))

{{-- Menu Vertical --}}
@extends('layouts.menuapp')

{{-- Contenido Principal --}}
@section('page_content')
<div class="panel panel-large">

	{{-- TABS --}}
	<ul class="tab">
		<li class="tab-item">
			<a href="#" class="tab-link active" data-tab="preferences">
				<span class="icon-user tab-link__icon"></span>
				<span class="tab-link__text">Datos Personales</span>
			</a>
		</li>
		<li class="tab-item">
			<a href="#" class="tab-link" data-tab="image">
				<span class="icon-picture-oexpand tab-link__icon"></span>
				<span class="tab-link__text">Imagen de perfil</span>
			</a>
		</li>
		<li class="tab-item">
			<a href="#" class="tab-link" data-tab="change-password">
				<span class="icon-lock-password tab-link__icon"></span>
				<span class="tab-link__text">Cambiar contraseña</span>
			</a>
		</li>
	</ul>

	{{-- CONTENT TABS --}}
	<div class="tab-content">
		{{-- TAB 1 --}}
		<div class="tab-content__item active" id="preferences">
			<div class="panel" style="border: none;">
				<div class="panel__heading" style="border: none;">Edita tus Datos Personales</div>
				<div class="panel__body" style="border: none;">
					<form class="form" action="#" method="POST" id="form-user">
						{{csrf_field()}}
						<div class="form-group">
							<label for="usuario" class="label">Usuario</label>
							<span class="error"></span>
							<input class="input" type="text" name="usuario" id="usuario" placeholder="Usuario" value="{{$data[0]->usuario}}" disabled>
						</div>
						<div class="form-group">
						    <label for="nombre" class="label">Nombre</label>
							<span class="error"></span>
							<input class="input" type="text" name="nombre" id="nombre" placeholder="Nombre" value="{{$data[0]->nombre}}">
						</div>
						<div class="form-group">
							<label for="apellido" class="label">Apellido</label>
							<span class="error"></span>
							<input class="input" type="text" name="apellido" id="apellido" placeholder="Apellido" value="{{$data[0]->apellido}}">
						</div>
						<div class="form-group">
							<label for="" class="label">Fecha de Nacimiento<span class="error">*</span></label>
							<div class="input-select">
								<?php
									$date = explode('-', $data[0]->fecha_nac);
									$year = $date[0] ?? null;
									$month = $date[1] ?? null;
									$day = $date[2] ?? null;
								?>
								<select class="input select" name="day" id="day">
									<option value="">Dia</option>
									@for ($i = 1; $i <= 31; $i++)
										@if ($day != null)
											@if ($i == $day)
												<option value="{{$i}}" selected>{{$i}}</option>
											@else
												<option value="{{$i}}">{{$i}}</option>
											@endif
										@endif
									@endfor
								</select>
								<select class="input select" name="month" id="month">
									<option value="">Mes</option>
									@for ($i = 1; $i <= 12; $i++)
										@if ($month != null)
											@if ($i == $month)
												<option value="{{$i}}" selected>{{$i}}</option>
											@else
												<option value="{{$i}}">{{$i}}</option>
											@endif
										@endif
									@endfor
								</select>
								<select class="input select" name="year" id="year">
									<option value="">Año</option>
									@for ($i = 1920; $i <= date('Y'); $i++)
									@if ($year != null)
											@if ($i == $year)
												<option value="{{$i}}" selected>{{$i}}</option>
											@else
												<option value="{{$i}}">{{$i}}</option>
											@endif
										@endif
									@endfor
								</select>
							</div>
							<span class="tooltiptext left error" id="tooltip-date"></span>
						</div>
						<div class="form-group">
							<label for="correo" class="label">Correo</label>
							<span class="error"></span>
							<input class="input" type="text" name="correo" id="correo" placeholder="Correo electrónico" value="{{$data[0]->correo}}">
						</div>
						<div class="form-group">
							<label for="sexo" class="label">Sexo</label>
							<span class="error"></span>
							<select class="input" name="sexo" id="sexo">
								<option value="">Sexo...</option>
								<option value="F" <?php if($data[0]->sexo == 'F') echo 'selected'; ?>>Femenino</option>
								<option value="M" <?php if($data[0]->sexo == 'M') echo 'selected'; ?>>Masculino</option>
							</select>
						</div>
						<input type="submit" class="button button-alice" id="add" value="Guardar Cambios">
					</form>
				</div>
			</div>
		</div>

		{{-- TAB 2 --}}
		<div class="tab-content__item" id="image">
			<div class="panel" style="border: none;">
				<div class="panel__heading" style="border: none;">
					Actualiza tu imagen de perfil
				</div>
				<div class="panel__body" style="border: none;">
					<form action="#" method="POST" class="form" id="form-change-image" enctype="multipart/form-data">
						<div class="form-group">
							{{-- DROP ZONE --}}
							<div class="preview" id="drop-zone"></div>
						</div>
						<input type="submit" class="button button-alice" id="btn-change-image" value="Actualizar imagen">
					</form>
				</div>
			</div>
		</div>

		{{-- TAB 3 --}}
		<div class="tab-content__item" id="change-password">
			<div class="panel" style="border: none;">
				<div class="panel__heading" style="border: none;">
					Cambiar contraseña
				</div>
				<div class="panel__body" style="border: none;">
					<form action="#" method="POST" class="form" id="form-change-password">
						<div class="form-group">
							<input class="input" type="password" name="current_password" id="current_password" placeholder="Actual Contraseña">
							<span class="error"></span>
						</div>
						<div class="form-group">
							<input class="input" type="password" name="new_password" id="new_password" placeholder="Nueva Contraseña">
							<span class="error"></span>
						</div>
						<div class="form-group">
							<input class="input" type="password" name="confirm_password" id="confirm_password" placeholder="Confirmar Contraseña">
							<span class="error"></span>
						</div>
						<input type="submit" class="button button-alice" id="btn-change-password" value="Cambiar Contraseña">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

{{-- Footer --}}
@extends('layouts.footerapp')

