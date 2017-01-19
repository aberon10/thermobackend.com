{{-- Header --}}
@section('header')
	<header class="main-header">

		@if ($_SERVER['REQUEST_URI'] != '/login' && $_SERVER['REQUEST_URI'] != '/home' && $_SERVER['REQUEST_URI'] != '/')
			<a href="#" class="nodecoration" data-toggle="main-menu"><span class="icon-bars icon-large toggle-bars"></span></a>
		@else
			<img src="{{url('images/logo.png')}}" style="margin-left: 1em;">
		@endif

		@if (session('user'))
		{{-- Submenu preferences --}}
		<nav class="main-nav">
			<ul class="main-menu">
				<li class="" id="dropdown-toggle">
					<img src="{{asset('storage/avatars/user.jpg')}}" alt="" class="avatar">
					<a href="#" class="dropdown">
						{{session('user')}} <span class="icon icon-chevron-down"></span>
					</a>
					<ul class="main-submenu hide">
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
