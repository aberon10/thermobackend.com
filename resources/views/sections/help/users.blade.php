@extends('sections.help.help')

@section('article')
<article class="article" data-article='dashboard'>
	<h3 class="article-title">Usuarios</h3>
	<div class="article-content">
		<p>Esta sección permite gestionar datos relevantes a los usuarios que pertenecen a la app ThermoBackend como aquellos usuarios finales que forman parte la aplicación ThermoMusic.</p>
		<h4>LISTADO - BÚSQUEDA</h4>
		<p>En primera instancia esta sección presenta un listado detallado de todos los usuarios, a tráves del cual se puede navegar una a una las páginas presentes por medio del menú de paginación o puede realizarse una busca rapida. Para efectuar dicha búsqueda debe indicarse el nombre de usuario y automáticamente la aplicacíon mostrara los resultados.</p>
		<h4>ELIMINAR</h4>
		<p>Para eliminar un usuario, se debe marcar el ultimo campo del listado y luego hacer clic en el bóton <b class="error">Eliminar</b>.</p>
		<h4>NUEVO USUARIO</h4>
		<p>Para añadir un nuevo usuario al sistema se debe completar el formulario correspondiente. Una vez completado, se enviara un correo a la casilla del usuario, dandole la Bienvenida e indicandole cuales son sus credenciales para iniciar sesión.</p>
		<p class="attention"><b>ANTECIÓN: </b> Esta sección esta disponible solo para usuarios con perfil de ADMINISTRADOR.</p>
	</div>
</article>
@endsection
