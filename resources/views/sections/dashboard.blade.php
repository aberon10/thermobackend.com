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
									<div class="panel__body" id="first_chart"></div>
								</div>
								<div class="panel">
									<div class="panel__heading">
										Grafica 2
										<div class="panel-buttons">
											<span class="icon-chevron-up" data-toggle="panel"></span>
											<span class="icon-close"></span>
										</div>
									</div>
									<div class="panel__body" id="second_chart">
									</div>
								</div>
							</div> {{-- Fin del panel-container --}}
						</div>

						{{-- TODO LIST --}}
						<div class="ed-item m-100 xl-30">
							<div class="panel">
								<div class="panel__heading">
									MIS TAREAS
									<div class="panel-buttons">
										<span class="icon-chevron-up" data-toggle="panel"></span>
										<span class="icon-close"></span>
									</div>
								</div>

								{{-- Nueva Tarea --}}
								<div class="panel__body">
									<form class="form" action="#" method="POST" id="form-task">
										<div class="form-group inline">
											<input class="input" id="title" name="title" placeholder="Cuál es la tarea?"></input>
											<button type="submit" class="button button-alice">Guardar</button>
										</div>
										<span class="error"></span>
									</form>
								</div>

								<div class="panel__footer <?php if(isset($tasks) && count($tasks) == 0){echo 'hide';} ?>">
									{{-- Listado De Tareas --}}
									<div class="todo-list-container" id="todo-list-container" style="margin-bottom: 1.5em;">
										<ul class="todo-list" id="todo-list" style="max-height: 230px; overflow-y: auto;">
											@foreach ($tasks as $task)
												<li class="todo-list__item">
													<?php $title = (strlen($task->titulo) > 20) ? substr($task->titulo, 0, 18).'...' : $task->titulo; ?>
													<a href="#" data-task="{{$task->id_tarea}}"><span class="icon-check"></span> {{$title}} </a>
												</li>
											@endforeach
										</ul>
									</div>
									<p class="error" id="error-message-task"></p>
									<a href="#" class="button button-error bold hide" id="delete-task"><span class="icon-trash"></span> Eliminar Tarea</a>
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

{{-- Scripts --}}
@section('scripts')
	<script src="{{url('/js/libs/jquery.min.js')}}"></script>
	<script src="{{url('/js/libs/jquery-ui.min.js')}}"></script>
	<script src="{{url('/js/highcharts.js')}}"></script>
	<script src="{{url('/js/exporting.js')}}"></script>
	<script src="{{url('/js/app.min.js')}}"></script>
	<script src="{{url('/js/dashboard.js')}}"></script>
@endsection
