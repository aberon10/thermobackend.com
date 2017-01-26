@section('footerlist')
	<div class="snackbar" id="snackbar"></div>
	<footer class="main-footer">
		<div class="loader"></div>
		<div class="loader-message"></div>
		<span id="help-block" class="help-block"></span>
		<div class="float-right main-footer__buttons">
			<a href="#" class="button button-error hide" id="@yield('id_button_delete')">Eliminar</a>
			<a href="@yield('url_add')" class="button button-alice">Añadir nuevo</a>
		</div>
	</footer>
@endsection

