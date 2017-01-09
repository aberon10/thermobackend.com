<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ThermoBackend') }}</title>

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

    {{-- Header --}}
    @section('header')
        <header class="main-header">
            <div class="">ThermoBackend</div>
            @if (session('user'))
                {{-- Submenu preferences --}}
                 <nav class="main-nav">
                    <ul class="main-menu">
                        <li>
                            <img src="{{asset('storage/avatars/user.jpg')}}" alt="" class="avatar">
                            <a href="#" class="dropdown">
                                {{session('user')}} <span class="icon icon-sort-desc"></span>
                            </a>
                            <ul class="main-submenu">
                                <li><a href="#">Mi Perfil</a></li>
                                <li><a href="#">Ayuda</a></li>
                                <li><div class="divider"></div></li>
                                <li><a href="#">Cerrar sesion</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            @else
                <nav class="main-nav">
                    <ul class="main-menu">
                        <li><a href="{{url('/login')}}">Login</a></li>
                    </ul>
                </nav>
            @endif

        </header>
    @show

    @yield('content') {{-- Contenido principal --}}
    @yield('menuapp') {{-- Menu vertical --}}
    @yield('footerapp') {{-- Pie de página --}}
    @yield('footerlist') {{-- Pie de página de los listados--}}

    @yield('scripts') {{-- Scripts JS --}}
</body>
</html>
