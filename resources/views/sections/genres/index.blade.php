@extends('layouts.app')

{{-- Menu Vertical --}}
@extends('layouts.menuapp')

@section('content')
    <div class="ed-container">
        <div class="ed-item">
            <div class="main-container">
				{{-- Table of Genres --}}
				<div class="panel">
					<div class="panel__heading">
						Generos
					</div>
					<div class="panel__body">
						<table class="table table-striped">
							<thead>
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
							</thead>
							<tbody>
								@foreach($genres as $genre)
									<tr>
										<td>{{$loop->index + 1}}</td>
										<td><a href="{{url('/genres/edit/'.$genre->id_genero)}}">{{$genre->nombre_genero}}</a></td>
										<td>{{DateFormat::format($genre->updated_at)}}</td>
										<td>{{DateFormat::format($genre->updated_at)}}</td>
										<td class="center"><input type="checkbox" name="{{$genre->nombre_genero}}" data-music="true" value="{{$genre->id_genero}}"></td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>

            </div>
        </div>
    </div>
@endsection

{{-- Footer --}}
@extends('layouts.footerlist')

{{-- URL button add --}}
@section('url-add', url('genres/add'))

{{-- ID button delete --}}
@section('id_button_delete', 'delete')

{{-- Scripts --}}
@section('scripts')
	<script src="{{url('/js/utilities/ajax.js')}}"></script>
	<script src="{{url('/js/music-config.js')}}"></script>
	<script src="{{url('/js/music-delete.js')}}"></script>
	<script src="{{url('/js/music-init.js')}}"></script>
@endsection
