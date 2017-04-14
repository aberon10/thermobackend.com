@extends('sections.help.help')

@section('article')
<article class="article" data-article='dashboard'>
	<h3 class="article-title">Música</h3>
	<div class="article-content">
		<p>Esta sección esta dividida a su vez en cuatro secciones Géneros, Artistas, Albums y Pistas.</p>
		<p>Cada una de esta secciones cuentan con cinco funcionaliadades Agregar, Listar, Buscar, Modificar y Elminar (a exepción de la seccón Pistas que solo cuenta con la primera de estas).</p>
		<h4>AGREGAR NUEVO...</h4>
		<p>Esta funcionlidad permite llevar a cabo el ingreso de un nuevo genero, album, artista o pista a la aplicación. Existen algunas peculiaridades o condiciones que deben cumplirse y que es importante tener en cuenta. Es decir, que para ingresar un artista a un determinado genero este ultimo debe existir previamente al igual que un album pertence a un artista y una canción pertenece a un album, por lo tanto, existe cierta dependencia entre una entidad y otra.</p>

		<h4>LISTADO - BÚSQUEDA</h4>
		<p>El listado detalla de gran forma cada una de las entidades. Permite explorar una a una las páginas por medio del menú de paginación o realizando una búsqueda más especifica indicando el nombre del genero, album, artista o pista.</p>
		<h4>ELIMINAR</h4>
		<p>Para eliminar cualquiera de las entidades, es tan sencillo como marcar el ultimo campo del listado y luego hacer clic en el bóton <b class="error">Eliminar</b>.</p>
		<h4>MODIFICAR</h4>
		<p>La tarea de modificar es tan facil como hacer clic en el nombre de la entidad que se quiere modificar, luego se efectuan los cambios correspondiente y por ultimo se debe hacer clic en el bóton Guardar para aplicar los cambios.</p>
		<p class="attention"><b>ANTECIÓN: </b> Esta sección esta disponible solo para usuarios con perfil de ADMINISTRADOR.</p>
	</div>
</article>
@endsection
