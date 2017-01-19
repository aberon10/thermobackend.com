@extends('layouts.app')

{{-- Titulo de la seccion izquierda--}}
@section('title_left', config('config_app.sections_title.add_artist'))

{{-- Titulo de la seccion derecha--}}
@section('title_right')
	<a href="#" class="nodecoration" target="_blanck"><span class="icon-help icon-large info"></span></a>
@endsection

{{-- Menu Vertical --}}
@extends('layouts.menuapp')
{{-- Formulario --}}
@extends('layouts.form')
@section('panel_title', config('config_app.sections_title.add_artist'))
{{-- Footer --}}
@extends('layouts.footerapp')
{{-- Buttons --}}
@section('url_button_cancel', url('/artists/'))
{{-- Scripts --}}
@section('scripts')
<script src="{{url('/js/utilities/ajax.js')}}"></script>
<script src="{{url('/js/utilities/utilities.js')}}"></script>
<script src="{{url('/js/validations/validations.js')}}"></script>
<script src="{{url('/js/validations/upload-file.js')}}"></script>
<script src="{{url('/js/music-config.js')}}"></script>
<script src="{{url('/js/music-add-edit.js')}}"></script>
<script src="{{url('/js/music-init.js')}}"></script>
@endsection
