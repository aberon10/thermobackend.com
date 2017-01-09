@section('footerapp')
	<footer class="main-footer">
		<span id="help-block" class="help-block"></span>
		<div class="float-right">
			<a href="@yield('url_button_cancel')" id="@yield('id_button_cancel')" class="button">Cancelar</a>
			<a href="#" id="@yield('id_button_accept')" class="button button-alice">@yield('text_button_accept')</a>
		</div>
	</footer>
@endsection
