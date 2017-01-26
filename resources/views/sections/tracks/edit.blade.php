@extends('layouts.app')

{{-- Titulo de la seccion izquierda--}}
@section('title_left', config('config_app.sections_title.edit_track'))

{{-- Titulo de la seccion derecha--}}
@section('title_right')
	<a href="#" class="nodecoration" target="_blanck"><span class="icon-help icon-large info"></span></a>
@endsection

{{-- Menu Vertical --}}
@extends('layouts.menuapp')

{{-- Formulario para Editar --}}
@extends('layouts.formedit')
@section('panel_heading', config('config_app.sections_title.edit_track'))

{{-- Footer --}}
@extends('layouts.footerapp')
@section('url_button_cancel', url('/albums/'))
@section('id_button_add', 'music-add')

