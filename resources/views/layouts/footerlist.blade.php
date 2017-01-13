@section('footerlist')
	<footer class="main-footer">
		<span id="help-block" class="help-block"></span>
		<div class="float-right main-footer__buttons">
			<a href="#" class="button button-error hide" id="@yield('id_button_delete')">Eliminar</a>
			<a href="@yield('url-add')" class="button button-alice">Añadir nuevo</a>
		</div>
	</footer>
@endsection

