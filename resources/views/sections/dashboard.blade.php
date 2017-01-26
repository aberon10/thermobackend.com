@extends('layouts.app')

{{-- Titulo de la seccion izquierda--}}
@section('title_left', 'DashBoard')

{{-- Titulo de la seccion derecha--}}
@section('title_right')
	<a href="#" class="nodecoration" target="_blanck"><span class="icon-help icon-large info"></span></a>
@endsection

{{-- Menu Vertical --}}
@extends('layouts.menuapp')

@section('main_content')
	<div class="ed-container">
		<div class="ed-item">
			<div class="page">
				<div class="page__content">

					{{-- INDICADORES --}}
					<div class="indicators-container">
						<div class="indicator indicator-facebook">
							<div class="indicator__title">
								<span class="icon-facebook-square indicator__logo"></span>
								<p>Facebook <span class="percentage">10%</span></p>
							</div>
							<div class="indicator__number">200</div>
						</div>
						<div class="indicator indicator-googlemas">
							<div class="indicator__title">
								<span class="icon-google indicator__logo"></span>
								<p>Google <span class="percentage">15%</span>	</p>
							</div>
							<div class="indicator__number">300</div>
						</div>
						<div class="indicator indicator-alice-blue">
							<div class="indicator__title">
								<span class="icon-users indicator__logo"></span>
								<p>Premium <span class="percentage">70%</span></p>
							</div>
							<div class="indicator__number">1400</div>
						</div>
						<div class="indicator indicator-default">
							<div class="indicator__title">
								<span class="icon-users indicator__logo"></span>
								<p>Gratis <span class="percentage">5%</span></p>
							</div>
							<div class="indicator__number">100</div>
						</div>
					</div>

					<div class="ed-container">
						<div class="ed-item m-100 xl-70">
							<div class="panel-container panel-column-2">
								<div class="panel">
									<div class="panel__heading">
										Grafica 1
										<div class="panel-buttons">
											<span class="icon-chevron-up" data-toggle="panel"></span>
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
											<span class="icon-chevron-up" data-toggle="panel"></span>
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
											<span class="icon-chevron-up" data-toggle="panel"></span>
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
						</div>
						<div class="ed-item m-100 xl-30">
							{{-- TODO LIST --}}
							<div class="panel">
								<div class="panel__heading">
									Tareas Pendientes
									<div class="panel-buttons">
										<span class="icon-chevron-up" data-toggle="panel"></span>
										<span class="icon-close"></span>
									</div>
								</div>
								<div class="panel__body">
									<div class="todo-list-container">
									<ul class="todo-list">
										<li class="todo-list__item active">
											<a href="#"><span class="icon-check"></span> Tarea 1</a>
										</li>
										<li class="todo-list__item">
											<a href="#"><span class="icon-check"></span> Tarea 2</a>
										</li>
										<li class="todo-list__item">
											<a href="#"><span class="icon-check"></span> Tarea 3</a>
										</li>
										<li class="todo-list__item">
											<a href="#"><span class="icon-check"></span> Tarea 4</a>
										</li>
									</ul>
									</div>
									<a href="#" class="button button-alice">Hecho</a>
									<a href="{{url('/task')}}" class="button button-blue">Ver todas las tareas</a>
								</div>
								<div class="divider"></div>
								<div class="panel__footer">
									<h3 class="center">Nueva Tarea</h3>
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
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
@endsection

{{-- Footer --}}
@extends('layouts.footerapp')

