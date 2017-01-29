@section('menuapp')
    {{-- Sidebar --}}
    <aside class="sidebar">

        {{-- Logotipo --}}
        <div class="sidebar__header">
            <div class="app-logo">
                <img src="{{url('/images/logo.png')}}" alt="Logo" class="app-logo__img">
                <div class="app-logo__name">
                    <h3>ThermoBackend</h3>
                </div>
            </div>
        </div>

        <div class="sidebar__body">

            {{--Menu Secundario - Opciones ocultas --}}
            <div class="menu-secondary hide">
	            <a href="#" class="button button-alice button-center">
	                <span class="icon icon-plus"></span> Crear una nueva tarea
	            </a>
	            <a href="{{url('/task')}}" class="button button-center">Ver todas las tareas</a>
            </div>

			<div class="info-user-container">
	            <div class="info-user">
	            	<div class="info-user__avatar">
						<img src="{{'/storage/'.session('src_img')}}" alt="" class="radius" style="max-width: 64px;">
	            	</div>
	            	<div class="info-user__name">
	                	<span>Bienvenid@,</span>
	                	<h4>{{session('user')}}</h4>
	            	</div>
	            </div>
			</div>

            {{-- Menu --}}
            <nav class="menu-vertical__nav">
                <ul class="menu-vertical">
                    <li class="menu-vertical__item"><a href="{{url('/dashboard')}}" class="menu-vertical__link"><span class="icon-home"></span> Dashboard</a></li>
                    @if (session('account') == 1)
	                <li class="menu-vertical__item"><a href="{{url('/users')}}" class="menu-vertical__link"><span class="icon-users"></span> Usuarios</a></li>
	                <li class="menu-vertical__item item-submenu open">
	                    <a href="#" class="menu-vertical__link">
	                        Música
	                        <span class="icon-chevron-down"></span>
	                	</a>
	                    {{-- SubMenu --}}
	                    <ul class="menu-vertical__submenu">
	                        <li><a href="{{url('/genres')}}" class="menu-vertical__link">Generos</a></li>
	                        <li><a href="{{url('/artists')}}" class="menu-vertical__link">Artistas</a></li>
	                        <li><a href="{{url('/albums')}}" class="menu-vertical__link">Albums</a></li>
	                        <li><a href="{{url('/tracks/add')}}" class="menu-vertical__link">Pistas</a></li>
	                    </ul>
	                </li>
	                @elseif(session('account') == 2)
					<li class="menu-vertical__item"><a href="#" class="menu-vertical__link">Publicidad</a></li>
	                @endif
                </ul>
            </nav>
        </div>

        <div class="sidebar__footer">
            <a href="#" data-toggle="main-menu"><span class="icon-chevron-left"></span></a>
	        <a href="#"  id="toggle-secondary-menu"><span class="icon-configuration"></span></a>
	        <a href="#" class="tooltip"><span class="icon-help"></span></a>
	        <a href="#" class="tooltip"><span class="icon-bubble-comment-streamline-talk"></span></a>
        	<a href="#"><span class="icon-sign-out"></span></a>
        </div>

    </aside>
@endsection
