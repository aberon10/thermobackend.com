@extends('layouts.app')
@extends('layouts.menuapp')
@section('content')
<div class="ed-container">
	<div class="ed-item">
		<div class="main-container">
			@if (isset($albums) && $albums)
			<div class="panel">
				<div class="panel__heading">Albums</div>
				<div class="panel__body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Album</th>
								<th>Artista</th>
								<th>Fecha he creación</th>
								<th>Ultima actualización</th>
								<th class="center">
									<input type="checkbox" name="" value="" class="hide" id="delete-all">
									<label for="delete-all"><span class="icon-trash error"></span></label>
								</th>
							</tr>
						</thead>
						<tbody>
							@foreach($albums as $album)
							<tr>
								<td>{{$loop->index + 1}}</td>
								<td><a href="{{url('/albums/edit/'.$album->id_album)}}">{{$album->nombre}}</a></td>
								<td><a href="{{url('/artists/edit/'.$artists[$loop->index]->id_artista)}}">{{$artists[$loop->index]->nombre_artista}}</a></td>
								<td>{{DateFormat::format($album->created_at)}}</td>
								<td>{{DateFormat::format($album->updated_at)}}</td>
								<td class="center"><input type="checkbox" name="{{$album->nombre}}" data-music="true" value="{{$album->id_album}}"></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			@else
				<h1 class="center">No hay albums disponibles</h1>
			@endif
		</div>
	</div>
</div>
@endsection

{{-- Footer --}}
@extends('layouts.footerlist')

{{-- URL button add --}}
@section('url-add', url('albums/add'))

{{-- ID button delete --}}
@section('id_button_delete', 'delete')

{{-- Scripts --}}
@section('scripts')
	<script src="{{url('/js/utilities/ajax.js')}}"></script>
	<script src="{{url('/js/music-config.js')}}"></script>
	<script src="{{url('/js/music-delete.js')}}"></script>
	<script src="{{url('/js/music-init.js')}}"></script>
@endsection
