@section('menuapp')
    {{-- Sidebar --}}
    <aside class="sidebar">

        {{-- Logotipo --}}
        <div class="sidebar__header">
            <div class="app-logo">
                <img src="{{url('/images/logo.png')}}" alt="Logo" class="app-logo__img">
                <div class="app-logo__name">                
                    <h3>ThermoBackend <span class="icon icon-sort-desc"></span></h3>
                </div>
            </div>            
        </div>
    
        <div class="sidebar__body">
            
            {{-- Nueva Nota --}}
            <a href="#" class="button button-blue button-center">
                <span class="icon icon-plus"></span> Crear una nueva nota
            </a>           
            <a href="#" class="button button-center">Ver todas las notas</a>

            {{-- Menu --}}
            <nav class="menu-vertical__nav">
                <ul class="menu-vertical">                   
                    <li class="menu-vertical__item"><a href="#" class="menu-vertical__link">Dashboard</a></li>        
                    <li class="menu-vertical__item"><a href="#" class="menu-vertical__link">Usuarios</a></li>        
                    <li class="menu-vertical__item">
                        <a href="#" class="menu-vertical__link item-selected">
                            Música 
                            <span class="divider"></span>
                        </a>
                        <ul class="menu-vertical__submenu">
                            <li><a href="#" class="menu-vertical__link">Generos</a></li>        
                            <li><a href="#" class="menu-vertical__link">Artistas</a></li> 
                            <li><a href="#" class="menu-vertical__link">Albums</a></li> 
                            <li><a href="#" class="menu-vertical__link">Pistas</a></li> 
                        </ul>
                    </li>        
                </ul>
            </nav>  
        </div>

    </aside>
@show