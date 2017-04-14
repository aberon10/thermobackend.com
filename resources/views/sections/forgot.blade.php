@extends('layouts.app')

@section('main_content')
	    <div class="ed-container">
			<div class="ed-item">
				<div class="panel panel-middle" style="margin-top: 4em;">
					<div class="panel__heading">Recuperar Constraseña</div>
					<div class="panel__body">
						<form class="form" method="POST" name="form-forgotopassword" id="form-forgotpassword">
							{{csrf_field()}}
							<p>Hola, has perdido tu contraseña? no te preocupes ingresa tu nombre de usuario para obtener una nueva.</p>
							<div class="form-group">
								<input type="text" class="input" id="user" name="user" placeholder="Usuario" autofocus required>
							</div>
							<div class="form-group">
								<div class="message"></div>
								<button type="submit" class="button button-blue gradient bold">Enviar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
@endsection

@section('scripts')
	<script src="{{url('/js/app.min.js')}}"></script>
	<script src="{{url('/js/forgotpassword.js')}}"></script>
@endsection
