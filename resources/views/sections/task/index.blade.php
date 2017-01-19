@extends('layouts.app')
{{-- Titulo de la seccion izquierda--}}
@section('title_left', 'Tareas')

{{-- Titulo de la seccion derecha--}}
@section('title_right')
<a href="#" class="nodecoration" target="_blanck"><span class="icon-trash icon-large error"></span></a>
<span class="icon-help icon-large info"></span>
@endsection

{{-- Menu Vertical --}}
@extends('layouts.menuapp')
@section('page_content')
<div class="panel-container panel-column-3">
	<div class="panel">
		<div class="panel__heading">
			Nueva Tarea
		</div>
		<div class="panel__body">
			<form class="form">
				<div class="form-group">
					<label class="label" for="title">Titulo</label>
					<input type="text" class="input" id="title" name="title" placeholder="Titulo de la tarea ?">
				</div>
				<div class="form-group">
					<label class="label" for="content">Contenido</label>
					<input type="text" class="input" id="content" name="content" placeholder="Cuál es la tarea?">
				</div>
				<div class="form-group">
					<button type="submit" class="button button-alice">Guardar</button>
				</div>
			</form>
		</div>
	</div>
	<div class="panel">
		<div class="panel__heading">
			Grafica 1
			<div class="panel-buttons">
				<input type="checkbox" class="" data-task="delete">
				<span class="icon-chevron-down"></span>
				<span class="icon-close"></span>
			</div>
		</div>
		<div class="panel__body">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</div>
	</div>
	<div class="panel">
		<div class="panel__heading">
			Grafica 2
			<div class="panel-buttons">
				<input type="checkbox" class="" data-task="delete">
				<span class="icon-chevron-down"></span>
				<span class="icon-close"></span>
			</div>
		</div>
		<div class="panel__body">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</div>
	</div>
	<div class="panel">
		<div class="panel__heading">
			Grafica 3
			<div class="panel-buttons">
				<input type="checkbox" class="" data-task="delete">
				<span class="icon-chevron-down"></span>
				<span class="icon-close"></span>
			</div>
		</div>
		<div class="panel__body">
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</div>
	</div>
</div> {{-- Fin del panel-container --}}
@endsection
