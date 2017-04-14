@extends('layouts.app')

@section('main_content')
	<div class="ed-container">
		<div class="ed-item">

			<div class="panel panel-small" style="margin-top: 4em;">
				<div class="panel__heading">Iniciar Sesión <img src="{{url('images/logo.png')}}"></div>
				<div class="panel__body">
					<form action="{{url('/login')}}" method="POST" name="form-login" class="form">

						{{csrf_field()}}

						<div class="form-group {{ $errors->has('usuario') ? 'error' : '' }} {{ $errors->has('message_error') ? 'error' : '' }}">
							<label for="usuario" class="label">Usuario</label>
							<input type="text" class="input" id="usuario" name="usuario" placeholder="Usuario" value="{{ old('usuario') }}" autofocus>
							@if ($errors->has('usuario'))
								<p class="message">{{$errors->first('usuario')}}</p>
							@endif
						</div>
						<div class="form-group {{ $errors->has('pass') ? 'error' : '' }} {{ $errors->has('message_error') ? 'error' : '' }}">
							<label for="pass" class="label">
								Contraseña
								<a href="{{url('http://thermobackend.com/forgotPassword')}}" class="float-right">Olvidaste tu contraseña?</a>
							</label>
							<input type="password" class="input" id="pass" name="pass" placeholder="Contraseña" value="{{old('pass')}}">
							@if ($errors->has('pass'))
								<p class="message">{{$errors->first('pass')}}</p>
							@endif
						</div>
						<div class="form-group {{ $errors->has('message_error') ? 'error' : '' }}">
							@if ($errors->has('message_error'))
								<p class="message">{{$errors->first('message_error')}}</p>
							@endif
							<a href="{{url('/help')}}" class="float-left" style="padding: .5rem 0;">Necesitas ayuda?</a>
							<button type="submit" class="button button-full button-blue gradient bold">Entrar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<footer class="home-footer">
		<p class="center">ThermoBackend 2016 - {{date('Y')}}</p>
	</footer>
@endsection

