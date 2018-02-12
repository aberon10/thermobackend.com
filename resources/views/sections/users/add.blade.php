@extends('layouts.app')

{{-- Titulo de la seccion izquierda--}}
@section('title_left', config('config_app.sections_title.add_user'))

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
