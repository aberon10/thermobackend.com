<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="{{url('css/styles.css')}}" rel="stylesheet">

    <!-- Icons -->
    <link href="{{url('css/icons/icons.css')}}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>

@section('header')
	<i class="icon-bars icon-large icon-toggle" id="open-sidebar" style="margin: 1rem"></i>
@show

<nav class="sidenav" id="sidenav">
	<div class="sidenav-header">
		<h2>Ayuda</h2>
		<i class="icon-close" id="close-sidebar"></i>
	</div>
	<ul class="sidenav-menu">
		<li class="active"><a href="#">Dashboard</a></li>
		<li><a href="#">Generos</a></li>
		<li><a href="#">Artistas</a></li>
		<li><a href="#">Albums</a></li>
		<li><a href="#">Pistas</a></li>
		<li><a href="#">Publicidad</a></li>
	</ul>
</nav>

@section('main_content')
	    <div class="ed-container" id="main-container">
			<div class="ed-item">
				<div class="home">
					<div class="home__title">
						<h1 class="center">¿Necesitas <span>ayuda? </span></h1>
					</div>
					<div class="home__content">
						<div>
							<p>En esta sección encontraras toda la ayuda necesaria para poder utilizar la app ThermoBackend. Cada uno de los articulos presenta en gran detalle la forma correcta de sacarle el máximo provecho a esta aplicación backend. </p>
							<p>Si no encuentras lo que necesitas o te quedan dudas al leer alguno de los articulos, no dudes en contactar al administrador.</p>
						</div>
						<ul class="home__menu">
							<li><a href="#">Dashboard</a></li>
							<li><a href="#">Generos</a></li>
							<li><a href="#">Artistas</a></li>
							<li><a href="#">Albums</a></li>
							<li><a href="#">Pistas</a></li>
							<li><a href="#">Publicidad</a></li>
						</ul>
						<div class="" data-article='dashboard'>
							<h2>DashBoard</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						</div>
						<div class="" data-article='genres'>
							<h2>Generos</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						</div>
						<div class="" data-article='artists'>
							<h2>Artistas</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						</div>
						<div class="" data-article='albums'>
							<h2>Albums</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						</div>
						<div class="" data-article='tracks'>
							<h2>Pistas</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						</div>
						<div class="" data-article='publicidad'>
							<h2>Publicidad</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<footer class="home-footer">
			<p class="center">ThermoBackend - {{date('Y')}}</p>
		</footer>
@show

{{-- Scripts --}}
@section('scripts')
	<script src="{{url('/js/app.min.js')}}"></script>
@show
</body>
</html>
