@extends('layouts.app')

{{-- Titulo de la seccion --}}
@section('title_left', config('config_app.sections_title.index_genre'))

{{-- Titulo de la seccion derecha--}}
@section('title_right')
	<a href="#" class="nodecoration" target="_blanck"><span class="icon-help icon-large info"></span></a>
@endsection

{{-- Menu Vertical --}}
@extends('layouts.menuapp')

{{-- Table --}}
@extends('layouts.table')

{{-- Titulo del panel --}}
@section('panel_heading', config('config_app.sections_title.index_genre'))

@section('table_head')
	<tr>
		<th>#</th>
		<th>Nombre Género</th>
		<th>Fecha he creación</th>
		<th>Ultima actualización</th>
		<th class="center">
			<input type="checkbox" name="" value="" class="hide" id="delete-all">
			<label for="delete-all"><span class="icon-trash error"></span></label>
		</th>
	</tr>
@endsection

@section('table_body')
	@foreach($genres as $genre)
		<tr>
			<td>{{$index++}}</td>
			<td><a href="{{url('/genres/edit/'.$genre->id_genero)}}">{{$genre->nombre_genero}}</a></td>
			<td>{{DateFormat::format($genre->created_at)}}</td>
			<td>{{DateFormat::format($genre->updated_at)}}</td>
			<td class="center"><input type="checkbox" name="{{$genre->nombre_genero}}" data-music="true" value="{{$genre->id_genero}}"></td>
		</tr>
	@endforeach
@endsection

@section('panel_footer')
	<div class="panel-options">
		<div class="panel-options__left">
			<p>Visualizando {{$genres->currentPage()}} de {{$genres->lastPage()}} paginas de {{$total_genres}} generos</p>
		</div>
		<div class="panel-options__right">
			{{-- Paginacion --}}
			{{$genres->links()}}
		</div>
	</div>
@endsection

{{-- Footer --}}
@extends('layouts.footerlist')

@section('url_add', '/genres/add')

{{-- Scripts --}}
@section('scripts')
	<script src="{{url('/js/utilities/ajax.js')}}"></script>
	<script src="{{url('/js/music-config.js')}}"></script>
	<script src="{{url('/js/music-delete.js')}}"></script>
	<script src="{{url('/js/music-init.js')}}"></script>
@endsection
