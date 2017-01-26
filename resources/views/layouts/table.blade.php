@section('page_content')
	<div class="panel">
		<div class="panel__heading">@yield('panel_heading')</div>

		<div class="panel__body">
			{{-- OPTIONS PANEL --}}
			@section('panel_options')
				<div class="panel-options">
					<div class="panel-options__left">
						<form class="form form-search">
							<select class="input" id="limit">
								 @foreach (config('config_app.LIMITS') as $l)
								 	@if ($l == $limit)
										<option value="{{$l}}" selected>{{$l}}</option>
									@else
										<option value="{{$l}}">{{$l}}</option>
									@endif
								 @endforeach
							</select>
						</form>
					</div>
					<div class="panel-options__right">
						<form class="form form-search" id="form-search">
							<input type="text" name="" class="input" name="filter" id="filter" placeholder="Search...">
							<button type="submit" class="button"><span class="icon-search"></span></button>
						</form>
					</div>
				</div>
			@show

			{{-- TABLE --}}
			<table class="table table-striped">
				<thead>
					@yield('table_head')
				</thead>
				<tbody id="tbody">
					@yield('table_body')
				</tbody>
			</table>
		</div>

		<div class="panel__footer">
			@yield('panel_footer')
		</div>
	</div>
@endsection
