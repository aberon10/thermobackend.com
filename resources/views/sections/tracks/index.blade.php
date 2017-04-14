@extends('layouts.app')

{{-- Titulo de la seccion izquierda --}}
@section('title_left', $tracks[0]->nombre.' - '.$tracks[0]->nombre_artista)

{{-- Titulo de la seccion derecha --}}
@section('title_right')
	<input type="checkbox" class="hide" id="delete-all">
	<label for="delete-all"><span class="icon-trash icon-large error"></span></label>
@endsection

{{-- Menu Vertical --}}
@extends('layouts.menuapp')

@section('page_content')
	<div class="panel-container panel-column-2">
		@foreach($tracks as $track)
			<div class="panel">
				<div class="panel__heading">
					<a href="{{url('/tracks/edit/'.$track->id_cancion)}}">{{$track->nombre_cancion}}</a>
					<div class="panel-buttons">
						<input type="checkbox" id="{{$track->nombre_cancion}}" name="{{$track->nombre_cancion}}" data-music="true" value="{{$track->id_cancion}}">
						<span class="icon-chevron-down" data-toggle="panel"></span>
						<span class="icon-close"></span>
					</div>
				</div>
				<div class="panel__body">
					<div class="player">
						<audio src="{{url('http://thermobackend.com/storage/'.$track->src_audio)}}" type="audio/mpeg" controls></audio>
						<div class="mask"></div>
					</div>
					<div class="">
						<table class="table table-striped">
							<tbody>
								<tr><td><strong>Año de creación:</strong></td><td>{{$track->anio}}</td></tr>
								<tr><td><strong>Formato:</strong></td><td> {{$track->formato}}</td></tr>
								<tr><td><strong>Cantidad de reproducciones:</strong></td><td> {{$track->contador}}</td></tr>
								<tr><td><strong>Fecha de creación:</strong></td><td> {{DateFormat::format($track->created_at)}}</td></tr>
								<tr><td><strong>Ultima actualización:</strong></td><td> {{DateFormat::format($track->updated_at)}}</td></tr>
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
@section('url_add', url('tracks/add'))
@section('id_button_delete', 'delete-music')
