@extends('sections.help.help')

@section('article')
<article class="article" data-article='dashboard'>
	<h3 class="article-title">Publicidad</h3>
	<div class="article-content">
		<p>Esta sección permite gestionar todo lo relevante a la publicidad de la aplicación.</p>
		<h4>AÑADIR NUEVA</h4>
		<p>Esta funcionlidad permite llevar a cabo el ingreso de una nueva publicidad. Es importante destacar que la publicidad se dividen en dos tipos audios y banners.</p>
		<h4>VER TODAS</h4>
		<p>En este apartado se puede obtener una vista previa o se puede reproduccir en el caso del audio.</p>
		<h4>ELIMINAR</h4>
		<p>Para eliminar cualquiera de las publicidades, es tan sencillo como marcar el campo (checkbox) junto al nombre de esta y luego hacer clic en el bóton <b class="error">Eliminar</b>.</p>
		<h4>MODIFICAR</h4>
		<p>La tarea de modificar es tan facil como hacer clic en el nombre de la entidad que se quiere modificar, luego realizar los cambios necesarios y por ultimo se hacer clic en el bóton Guardar para aplicar los cambios.</p>
		<p class="attention"><b>ANTECIÓN: </b> Esta sección esta disponible solo para usuarios con perfil de BUSINESS INTELLIGENCE.</p>
	</div>
</article>
@endsection
