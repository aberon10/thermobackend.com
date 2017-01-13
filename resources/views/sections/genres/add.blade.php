@extends('layouts.app')

@extends('layouts.menuapp')

@section('content')
	@include('layouts.form')
@endsection

{{-- Footer --}}
@extends('layouts.footerapp')

{{-- Buttons --}}
@section('id_button_cancel', '')
@section('url_button_cancel', url('/genres/'))
@section('id_button_accept', 'add')
@section('text_button_accept', 'Guardar cambios')

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
