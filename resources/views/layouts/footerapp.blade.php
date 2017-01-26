@section('footerapp')
	<div class="snackbar" id="snackbar"></div>
	<footer class="main-footer">
		@if ($_SERVER['REQUEST_URI'] != '/dashboard')
			<div class="loader"></div>
			<div class="loader-message"></div>
			<span id="help-block" class="help-block">
			</span>
			<div class="float-right">
				<a href="@yield('url_button_cancel')" class="button" id="delete">Cancelar</a>
				<a href="#" class="button button-alice" id="@yield('id_button_add')">Guardar Cambios</a>
			</div>
		@else
			<h3 style="margin: 0; padding: .2em .5em;">DashBoard
			<small style="color: #777; font-weight: normal;"> Graficas - Estadisticas - Tareas</small></h3>
		@endif
	</footer>
@endsection

