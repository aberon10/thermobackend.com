@extends('layouts.app')

@section('main_content')
	    <div class="ed-container">
			<div class="ed-item">
				<div class="home">
					<div class="home__title">
						<h1 class="center">THERMO <span>BACKEND</span></h1>
					</div>
					<div class="home__content">
						<ul class="home__menu">
							<li><a href="#">Home</a></li>
							<li><a href="#">Acerca De</a></li>
							<li><a href="#">Ayuda</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<footer class="home-footer">
			<p class="center">ThermoBackend - Todos los derechos reservados &copy {{date('Y')}}</p>
		</footer>
@endsection
