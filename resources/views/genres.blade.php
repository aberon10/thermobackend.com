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
						Listado de Generos
					</div>
					<div class="panel__body">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Nombre Genero</th>
									<th>Fecha he creacion</th>
									<th>Ultima actualizacion</th>
									<th>#</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td>Metal</td>
									<td>{{date('d/m/Y')}}</td>
									<td>{{date('d/m/Y')}}</td>
									<td><span class="icon-trash"></span></td>
								</tr>
								<tr>
									<td>2</td>
									<td>Cumbia</td>
									<td>{{date('d/m/Y')}}</td>
									<td>{{date('d/m/Y')}}</td>
									<td><span class="icon-trash"></span></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

            </div>
        </div>
    </div>
@endsection

{{-- Footer --}}
@extends('layouts.footerapp')

@section('footerapp')
	<footer class="main-footer">
		<div class="float-right main-footer__buttons">
			<a href="{{url('genres/add')}}" class="button button-alice">Añadir nuevo</a>
		</div>
	</footer>
@endsection
