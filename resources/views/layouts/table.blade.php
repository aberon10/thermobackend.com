@section('page_content')
	<div class="panel">
		<div class="panel__heading">@yield('panel_heading')</div>

		<div class="panel__body">
			{{-- OPTIONS PANEL --}}
			@section('panel_options')
				<div class="panel-options">
					<div class="panel-options__left">
						<form class="form form-search">
							<select class="input">
								<option value="">Limite de Registros...</option>
								<option>10</option>
								<option>25</option>
								<option>50</option>
								<option>100</option>
							</select>
						</form>
					</div>
					<div class="panel-options__right">
						<form class="form form-search">
							<input type="text" name="" class="input" placeholder="Search...">
							<button class="button"><span class="icon-search"></span></button>
						</form>
					</div>
				</div>
			@show

			{{-- TABLE --}}
			<table class="table table-striped">
				<thead>
					@yield('table_head')
				</thead>
				<tbody>
					@yield('table_body')
				</tbody>
			</table>
		</div>

		<div class="panel__footer">
			@yield('panel_footer')
		</div>
	</div>
@endsection
