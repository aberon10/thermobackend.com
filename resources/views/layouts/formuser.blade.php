@section('page_content')
	<div class="panel panel-middle">
		<div class="panel__heading">
			@yield('panel_title')
		</div>
		<div class="panel__body">
			<form class="form" action="#" method="POST" id="form-user">
				{{csrf_field()}}
				<div class="form-group inline tooltip">
	  				<span class="tooltiptext left red"></span>
					<input class="input" type="text" name="usuario" id="usuario" placeholder="Usuario" autofocus>
	  				<span class="tooltiptext right red"></span>
					<select name="cuenta" id="cuenta" class="input">
						<option value="">Tipo de Cuenta</option>
						<option value="1">Admin</option>
						<option value="2">Bussines Intelligence</option>
					</select>
				</div>
				<div class="form-group inline tooltip">
					<span class="tooltiptext left red"></span>
					<input class="input" type="text" name="nombre" id="nombre" placeholder="Nombre">
	  				<span class="tooltiptext right red"></span>
	  				<input class="input" type="text" name="apellido" id="apellido" placeholder="Apellido">
				</div>
				<div class="form-group tooltip">
					<label for="correo" class="label">Fecha de Nacimiento<span class="error">*</span></label>
					<div class="input-select">
						<select class="input select" name="day" id="day">
							<option value="">Dia</option>
							@for ($i = 1; $i <= 31; $i++)
								<option value="{{$i}}">{{$i}}</option>
							@endfor
						</select>
						<select class="input select" name="month" id="month">
							<option value="">Mes</option>
							@for ($i = 1; $i <= 12; $i++)
								<option value="{{$i}}">{{$i}}</option>
							@endfor
						</select>
						<select class="input select" name="year" id="year">
							<option value="">Año</option>
							@for ($i = 1920; $i <= date('Y'); $i++)
								<option value="{{$i}}">{{$i}}</option>
							@endfor
						</select>
					</div>
	  				<span class="tooltiptext left red" id="tooltip-date"></span>
				</div>
				<div class="form-group inline tooltip">
					<span class="tooltiptext left red"></span>
					<input class="input" type="text" name="correo" id="correo" placeholder="Correo electrónico">
	  				<span class="tooltiptext right red"></span>
					<select class="input" name="sexo" id="sexo">
						<option value="">Sexo...</option>
						<option value="F">Femenino</option>
						<option value="M">Masculino</option>
					</select>
				</div>
				<input type="submit" class="hide">
			</form>
		</div>
	</div>
@endsection
