@extends('layouts.app')

{{-- Titulo de la seccion izquierda--}}
@section('title_left', config('config_app.sections_title.add_genre'))

{{-- Menu Vertical --}}
@extends('layouts.menuapp')

{{-- Formulario --}}
@extends('layouts.form')
@section('panel_title', config('config_app.sections_title.add_genre'))

{{-- Footer --}}
@extends('layouts.footerapp')

{{-- Buttons --}}
@section('url_button_cancel', url('/genres/'))
@section('id_button_add', 'music-add')

