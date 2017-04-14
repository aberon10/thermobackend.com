{{-- Header --}}
@section('header')
	<header class="main-header">

		@if ($_SERVER['REQUEST_URI'] != '/login' && $_SERVER['REQUEST_URI'] != '/home' &&
		$_SERVER['REQUEST_URI'] != '/' && $_SERVER['REQUEST_URI'] != '/forgotPassword' &&
		$_SERVER['REQUEST_URI'] != '/about' && !preg_match("/^\/help/", $_SERVER['REQUEST_URI'] ))
			<a href="#" class="nodecoration" data-toggle="main-menu"><span class="icon-bars icon-large toggle-bars"></span></a>
		@else
			<a href="/" class="nodecoration"><img src="{{url('images/logo.png')}}" style="margin-left: 1em;"></a>
		@endif

		@if (session('user'))
		{{-- Submenu preferences --}}
		<nav class="main-nav">
			<ul class="main-menu">
				<li class="">
					<img src="{{'/storage/'.session('src_img')}}" alt="" class="avatar">
					<a href="#" class="dropdown" id="dropdown-toggle">
						{{session('user')}} <span class="icon icon-chevron-down"></span>
					</a>
					<ul class="main-submenu hide" style="z-index: 10000;">
						<li><a href="{{url('users/edit')}}">Mi Perfil</a></li>
						<li><a href="{{url('/help')}}" target="_blanck">Ayuda</a></li>
						<li><div class="divider"></div></li>
						<li>
							<form class="hide" method="POST" action="{{url('/login/logout')}}" id="form-logout">
								{{csrf_field()}}
								<input type="submit" class="hide" name="">
							</form>
							<a href="{{url('/login/logout')}}">Cerrar sesión</a>
						</li>
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
