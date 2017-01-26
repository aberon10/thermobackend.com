@extends('layouts.app')

{{-- Titulo de la seccion izquierda--}}
@section('title_left', config('config_app.sections_title.add_user'))

{{-- Titulo de la seccion derecha--}}
@section('title_right')
	<a href="#" class="nodecoration tooltip" target="_blanck">
	  	<span class="tooltiptext left">¿Necesitas ayuda?</span>
		<span class="icon-help icon-large info"></span>
	</a>
@endsection

{{-- Menu Vertical --}}
@extends('layouts.menuapp')

{{-- Formulario --}}
@extends('layouts.formuser')
@section('panel_title', config('config_app.sections_title.add_user'))

{{-- Footer --}}
@extends('layouts.footerapp')

{{-- Buttons --}}
@section('url_button_cancel', url('/users'))
@section('id_button_add', 'add')
