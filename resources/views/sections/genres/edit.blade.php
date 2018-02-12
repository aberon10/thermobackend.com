@extends('layouts.app')

{{-- Menu Vertical --}}
@extends('layouts.menuapp')

{{-- Titulo de la seccion izquierda--}}
@section('title_left', config('config_app.sections_title.edit_genre'))

{{-- Formulario para Editar --}}
@extends('layouts.formedit')
@section('panel_heading', config('config_app.sections_title.edit_genre'))

{{-- Footer --}}
@extends('layouts.footerapp')
@section('url_button_cancel', url('/genres/'))
@section('id_button_add', 'music-add')
