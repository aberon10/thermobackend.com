<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Icons -->
    <link href="{{url('css/icons/icons.css')}}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{url('css/styles.css')}}" rel="stylesheet">
    <link href="{{url('css/help.css')}}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>

@include('layouts.header')

@section('main_content')
	    <div class="ed-container" id="main-container">
			<div class="ed-item no-padding">
				<section class="help">
					<header class="help-header"></header>
					<section class="help-content">
						<div class="articles">
							@section('article')
								@include('sections.help.dashboard')
							@show
						</div>
						<aside class="aside">
							<h2>Ayuda de ThermoBackend</h2>
							<ul class="menu">
								<li><a class="active" href="/help">DashBoard</a></li>
								<li><a href="/help/users">Usuarios</a></li>
								<li><a href="/help/music">Música</a></li>
								<li><a href="/help/advertising">Publicidad</a></li>
							</ul>
						</aside>
					</section>
				</section>
			</div>
		</div>
@show
<script src="{{url('/js/app.min.js')}}"></script>
</body>
</html>
