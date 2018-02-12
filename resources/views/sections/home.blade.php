@extends('layouts.app')

@section('main_content')
	    <div class="ed-container">
			<div class="ed-item">
				<div class="home">
					<div class="home__title">
						<h1 class="center">THERMO <span>BACKEND</span></h1>
					</div>
					<div class="home__content">
						<div class="home__content" style="max-width: 960px; margin: auto;">
						<p class="">La apliación ThermoBackend se encargada de llevar a cabo la gestión y administración de los recursos que involucran a la app principal ThermoMusic. Siendo estos, géneros musicales, artistas, albums, pistas, publicidad, entre otros. A su vez ofrece distintos reportes, gráficas, indicadores y otros datos que son de gran importancia a la hora brindar el mejor servicio y experiencia a nuestros usuarios.</p>
					</div>
					</div>
				</div>
			</div>
		</div>
		<footer class="home-footer">
			<p class="center">ThermoBackend 2016 - {{date('Y')}}</p>
		</footer>
@endsection
