@section('footerapp')
	<footer class="main-footer">
		<span id="help-block" class="help-block {{ $errors->first('message') ? 'error' : '' }}">
			@if ($errors->has('message'))
				{{$errors->first('message')}}
			@endif
		</span>
		<div class="float-right">
			<a href="#" id="@yield('id_button_cancel')" class="button">Cancelar</a>
			<a href="#" id="@yield('id_button_accept')" class="button button-alice">Guardar cambios</a>
		</div>
	</footer>
@endsection
