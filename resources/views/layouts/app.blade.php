<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    @if ($_SERVER['REQUEST_URI'] == '/dashboard')
   		<link href="{{url('css/providers/jquery-ui.min.css')}}" rel="stylesheet">
	@endif

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
	<noscript>
		<meta http-equiv="refresh" content="0;URL='http://thermobackend.com/home/disabledJS'" />
	</noscript>
</head>
<body>

	@include('layouts.header') {{-- Header --}}

    @yield('menuapp') {{-- Menu vertical --}}

    {{-- Contenido principal --}}
    @section('main_content')
	    <div class="ed-container">
			<div class="ed-item">
				<div class="page">
					<div class="page__title">
						@section('page_title')
							<div class="title-left">
								<h2>@yield('title_left')</h2>
							</div>
							<div class="title-right">
								@yield('title_right')
							</div>
						@show
					</div>
					<div class="page__content">
	   					@yield('page_content') {{-- Contenido principal --}}
					</div>
				</div>
			</div>
		</div>
	@show

    @yield('footerapp') {{-- Pie de página --}}
    @yield('footerlist') {{-- Pie de página de los listados--}}

	{{-- Scripts --}}
    @section('scripts')
		<script src="{{url('/js/app.min.js')}}"></script>
	@show

</body>
</html>
