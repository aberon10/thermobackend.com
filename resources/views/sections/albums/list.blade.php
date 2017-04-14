@extends('layouts.app')
{{-- Titulo de la seccion izquierda --}}
@section('title_left', 'Albums - '.$data[0]->nombre_artista)
{{-- Titulo de la seccion derecha --}}
@section('title_right')
<input type="checkbox" class="hide" id="delete-all">
<label for="delete-all"><span class="icon-trash icon-large error"></span></label>
@endsection
{{-- Menu Vertical --}}
@extends('layouts.menuapp')
@section('page_content')
<div class="panel-container panel-column-2">
	@foreach($data as $album)
	<div class="panel">
		<div class="panel__heading">
			<a href="{{url('/albums/edit/'.$album->id_album)}}">{{$album->nombre}}</a>
			<div class="panel-buttons">
				<input type="checkbox" id="{{$album->nombre}}" name="{{$album->nombre}}" data-music="true" value="{{$album->id_album}}">
				<span class="icon-chevron-down" data-toggle="panel"></span>
				<span class="icon-close"></span>
			</div>
		</div>
		<div class="panel__body">
			<div class="player" style="width: 100%;">
				<a href="{{url('tracks/'.$album->id_album)}}" class="center">
					<img src="{{url('http://thermobackend.com/storage/'.$album->src_img)}}" alt="{{$album->nombre}}"
						style='margin: 0 auto 1.5em; display: block; max-width: 220px;'">
				</a>
			</div>
			<div class="">
				<table class="table table-striped">
					<tbody>
						<tr><td><strong>Año de Lanzamiento:</strong></td><td>{{$album->anio}}</td></tr>
						<tr><td><strong>Cantidad de pistas:</strong></td><td>{{$album->cant_pistas}}</td></tr>
						<tr><td><strong>Fecha de creación:</strong></td><td> {{DateFormat::format($album->created_at)}}</td></tr>
						<tr><td><strong>Ultima actualización:</strong></td><td> {{DateFormat::format($album->updated_at)}}</td></tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	@endforeach
</div>
@endsection
{{-- Footer --}}
@extends('layouts.footerlist')
{{-- URL button add --}}
@section('url_add', url('albums/add'))
@section('id_button_delete', 'delete-music')
