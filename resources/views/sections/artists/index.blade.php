@extends('layouts.app')

{{-- Titulo de la seccion --}}
@section('title_left', config('config_app.sections_title.index_artist'))

{{-- Titulo de la seccion derecha--}}
@section('title_right')
	<a href="#" class="nodecoration" target="_blanck"><span class="icon-help icon-large info"></span></a>
@endsection

{{-- Menu Vertical --}}
@extends('layouts.menuapp')

{{-- Table --}}
@extends('layouts.table')

{{-- Titulo del panel --}}
@section('panel_heading', config('config_app.sections_title.index_artist'))

@section('table_head')
	<tr>
		<th>#</th>
		<th>Artista</th>
		<th>Género</th>
		<th>Fecha he creación</th>
		<th>Ultima actualización</th>
		<th class="center">
			<input type="checkbox" name="" value="" class="hide" id="delete-all">
			<label for="delete-all"><span class="icon-trash error"></span></label>
		</th>
	</tr>
@endsection

@section('table_body')
	@foreach($artists as $artist)
		<tr>
			<td>{{$loop->index + 1}}</td>
			<td><a href="{{url('/artists/edit/'.$artist->id_artista)}}">{{$artist->nombre_artista}}</a></td>
			<td><a href="{{url('/genres/edit/'.$artist->id_genero)}}">{{$artist->nombre_genero}}</a></td>
			<td>{{DateFormat::format($artist->created_at)}}</td>
			<td>{{DateFormat::format($artist->updated_at)}}</td>
			<td class="center"><input type="checkbox" name="{{$artist->nombre_artista}}" data-music="true" value="{{$artist->id_artista}}"></td>
		</tr>
	@endforeach
@endsection

@section('panel_footer')
	<div class="panel-options">
		<div class="panel-options__left">
			<p>Visualizando {{$artists->currentPage()}} de {{$artists->lastPage()}} paginas de {{$total_artists}} artistas</p>
		</div>
		<div class="panel-options__right">
			{{-- Paginacion --}}
			{{$artists->links()}}
		</div>
	</div>
@endsection

{{-- Footer --}}
@extends('layouts.footerlist')

{{-- URL button add --}}
@section('url_add', url('artists/add'))

{{-- Scripts --}}
@section('scripts')
<script src="{{url('/js/utilities/ajax.js')}}"></script>
<script src="{{url('/js/music-config.js')}}"></script>
<script src="{{url('/js/music-delete.js')}}"></script>
<script src="{{url('/js/music-init.js')}}"></script>
@endsection
