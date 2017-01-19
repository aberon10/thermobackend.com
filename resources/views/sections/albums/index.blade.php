@extends('layouts.app')

{{-- Titulo de la seccion --}}
@section('title_left', config('config_app.sections_title.index_album'))

{{-- Titulo de la seccion derecha--}}
@section('title_right')
	<a href="#" class="nodecoration" target="_blanck"><span class="icon-help icon-large info"></span></a>
@endsection

{{-- Menu Vertical --}}
@extends('layouts.menuapp')

{{-- Table --}}
@extends('layouts.table')

{{-- Titulo del panel --}}
@section('panel_heading', config('config_app.sections_title.index_album'))

@section('table_head')
	<tr>
		<th>#</th>
		<th>Album</th>
		<th>Artista</th>
		<th>Fecha he creación</th>
		<th>Ultima actualización</th>
		<th></th>
		<th class="center">
			<input type="checkbox" name="" value="" class="hide" id="delete-all">
			<label for="delete-all"><span class="icon-trash error"></span></label>
		</th>
	</tr>
@endsection

@section('table_body')
	@for ($i = 0; $i < count($albums); $i++)
		<tr>
			<td>{{$index++}}</td>
			<td><a href="{{url('/tracks/'.$albums[$i]->id_album)}}">{{$albums[$i]->nombre}}</a></td>
			<td><a href="{{url('/artists/edit/'.$albums[$i]->id_artista)}}">{{$albums[$i]->nombre_artista}}</a></td>
			<td>{{DateFormat::format($albums[$i]->created_at)}}</td>
			<td>{{DateFormat::format($albums[$i]->updated_at)}}</td>
			<td><a href="{{url('/albums/edit/'.$albums[$i]->id_album)}}"><i class="icon-edit"></i></a></td>
			<td class="center"><input type="checkbox" name="{{$albums[$i]->nombre}}" data-music="true" value="{{$albums[$i]->id_album}}"></td>
		</tr>
	@endfor
@endsection

@section('panel_footer')
	<div class="panel-options">
		<div class="panel-options__left">
			<p>Visualizando {{$albums->currentPage()}} de {{$albums->lastPage()}} paginas de {{$total_albums}} albums</p>
		</div>
		<div class="panel-options__right">
			{{-- Paginacion --}}
			{{$albums->links()}}
		</div>
	</div>
@endsection

{{-- Footer --}}
@extends('layouts.footerlist')

{{-- URL button add --}}
@section('url_add', url('albums/add'))

{{-- Scripts --}}
@section('scripts')
<script src="{{url('/js/utilities/ajax.js')}}"></script>
<script src="{{url('/js/music-config.js')}}"></script>
<script src="{{url('/js/music-delete.js')}}"></script>
<script src="{{url('/js/music-init.js')}}"></script>
@endsection
