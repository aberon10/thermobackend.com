@extends('layouts.app')
@extends('layouts.menuapp')
@section('content')
<div class="ed-container">
	<div class="ed-item">
		<div class="main-container">
			@if (isset($artists) && $artists)
			<div class="panel">
				<div class="panel__heading">Artistas</div>
				<div class="panel__body">
					<table class="table table-striped">
						<thead>
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
						</thead>
						<tbody>
							@foreach($artists as $artist)
							<tr>
								<td>{{$loop->index + 1}}</td>
								<td><a href="{{url('/artists/edit/'.$artist->id_artista)}}">{{$artist->nombre_artista}}</a></td>
								<td><a href="{{url('/genres/edit/'.$genres[$loop->index]->id_genero)}}">{{$genres[$loop->index]->nombre_genero}}</a></td>
								<td>{{DateFormat::format($artist->updated_at)}}</td>
								<td>{{DateFormat::format($artist->updated_at)}}</td>
								<td class="center"><input type="checkbox" name="{{$artist->nombre_artista}}" data-music="true" value="{{$artist->id_artista}}"></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			@else
			<h1 class="center">No hay artistas disponibles</h1>
			@endif
		</div>
	</div>
</div>
@endsection

{{-- Footer --}}
@extends('layouts.footerlist')

{{-- URL button add --}}
@section('url-add', url('artists/add'))

{{-- ID button delete --}}
@section('id_button_delete', 'delete')

{{-- Scripts --}}
@section('scripts')
	<script src="{{url('/js/utilities/ajax.js')}}"></script>
	<script src="{{url('/js/music-config.js')}}"></script>
	<script src="{{url('/js/music-delete.js')}}"></script>
	<script src="{{url('/js/music-init.js')}}"></script>
@endsection
