@extends('layouts.app')

{{-- Titulo de la seccion --}}
@section('title_left', config('config_app.sections_title.index_user'))

{{-- Titulo de la seccion derecha--}}
@section('title_right')
	<a href="#" class="nodecoration" target="_blanck"><span class="icon-help icon-large info"></span></a>
@endsection

{{-- Menu Vertical --}}
@extends('layouts.menuapp')

{{-- Table --}}
@extends('layouts.table')

{{-- Titulo del panel --}}
@section('panel_heading', config('config_app.sections_title.index_user'))

@section('table_head')
	<tr>
		<th>#</th>
		<th>Usuario</th>
		<th>Rol</th>
		<th>Nombre</th>
		<th>Apellido</th>
		<th>Correo</th>
		<th>Fecha de nacimiento</th>
		<th>Sexo</th>
		<th>Registrado</th>
		<th>Ultima actualización</th>
		<th class="center">
			<span class="icon-trash error"></span>
		</th>
	</tr>
@endsection

@section('table_body')
	@for ($i = 0; $i < count($users); $i++)
		<tr>
			<td>{{$index++}}</td>
			<td>{{$users[$i]->usuario}}</td>
			<td>{{$users[$i]->nombre_tipo}}</td>
			<td>{{$users[$i]->nombre}}</td>
			<td>{{($users[$i]->apellido) ?? '-'}}</td>
			<td>{{$users[$i]->correo}}</td>
			<td>{{($users[$i]->fecha_nac) ?? '-'}}</td>
			<td>{{$users[$i]->sexo}}</td>
			<td>{{ ($users[$i]->created_at) ? DateFormat::format($users[$i]->created_at) : '-' }}</td>
			<td>{{ ($users[$i]->updated_at) ? DateFormat::format($users[$i]->updated_at) : '-' }}</td>
			<td class="center"><input type="checkbox" name="{{$users[$i]->id_usuario}}" data-user="true" value="{{$users[$i]->id_usuario}}"></td>
		</tr>
	@endfor
@endsection

@section('panel_footer')
	<div class="panel-options" id="panel-options">
		<div class="panel-options__left">
			<p>Visualizando {{$users->currentPage()}} de {{$users->lastPage()}} paginas de {{$total_users}} usuarios</p>
		</div>
		<div class="panel-options__right">
			{{-- Paginacion --}}
			{{$users->links()}}
		</div>
	</div>
@endsection

{{-- Footer --}}
@extends('layouts.footerlist')

{{-- URL button add --}}
@section('url_add', url('users/add'))
@section('id_button_delete', 'delete-user')
