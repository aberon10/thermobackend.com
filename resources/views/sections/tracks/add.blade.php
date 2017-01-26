@extends('layouts.app')

{{-- Titulo de la seccion izquierda--}}
@section('title_left', config('config_app.sections_title.add_track'))

{{-- Titulo de la seccion derecha--}}
@section('title_right')
	<a href="#" class="nodecoration" target="_blanck"><span class="icon-help icon-large info"></span></a>
@endsection

{{-- Menu Vertical --}}
@extends('layouts.menuapp')

{{-- Formulario --}}
@extends('layouts.form')
@section('panel_title', config('config_app.sections_title.add_track'))

{{-- Footer --}}
@extends('layouts.footerapp')

{{-- Buttons --}}
@section('url_button_cancel', url('/albums'))
@section('id_button_add', 'music-add')
