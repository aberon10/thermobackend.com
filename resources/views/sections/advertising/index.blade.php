@extends('layouts.app')

{{-- Titulo de la seccion izquierda--}}
@section('title_left', config('config_app.sections_title.index_advertising'))


{{-- Menu Vertical --}}
@extends('layouts.menuapp')

@section('page_content')

{{-- IMAGES --}}
@if (count($advertising_image) > 0)
	<h3>Banners</h3>
	<div class="panel-container panel-column-2">
		@foreach ($advertising_image as $adv)
		<div class="panel">
			<div class="panel__heading">
				<a href="{{url('/advertising/edit/'.$adv->id_publicidad)}}">{{ $adv->nombre_publicidad}}</a>
				<div class="panel-buttons">
					<input type="checkbox" class="" data-advertising="true" value="{{$adv->id_publicidad}}">
					<span class="icon-chevron-down"></span>
					<span class="icon-close"></span>
				</div>
			</div>
			<div class="panel__body">
				<img src="{{'storage/'.$adv->src}}" alt="{{$adv->nombre}}">
			</div>
		</div>
		@endforeach
	</div>
@endif

{{-- AUDIO --}}
@if (count($advertising_audio) > 0)
	<h3>Audios</h3>
	<div class="panel-container panel-column-2">
		@foreach ($advertising_audio as $adv)
			<div class="panel">
				<div class="panel__heading">
					<a href="{{url('/advertising/edit/'.$adv->id_publicidad)}}">{{ $adv->nombre_publicidad}}</a>
					<div class="panel-buttons">
						<input type="checkbox" class="" data-advertising="true" value="{{$adv->id_publicidad}}">
						<span class="icon-chevron-down"></span>
						<span class="icon-close"></span>
					</div>
				</div>
				<div class="panel__body">
					<div class="player">
						<audio src="{{'storage/'.$adv->src}}" type="audio/mpeg" controls></audio>
						<div class="mask"></div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
@endif
@endsection

@extends('layouts.footerlist')
@section('id_button_delete', 'delete-advertising')
@section('url_add', '/advertising/add')
