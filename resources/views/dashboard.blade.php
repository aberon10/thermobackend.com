@extends('layouts.app')

{{-- Menu Vertical --}}
@extends('layouts.menuapp')

@section('content')
    <div class="ed-container">
        <div class="ed-item">
            <div class="main-container">

				<div class="indicators-container">

					<div class="indicator indicator-facebook">
						<div class="indicator__title">
							<span class="icon-facebook-square indicator__logo"></span>
							Cuentas de Facebook
						</div>
						<div class="indicator__number">500</div>
					</div>

					<div class="indicator indicator-googlemas">
						<div class="indicator__title">
							<span class="icon-google indicator__logo"></span>
							Cuentas de Google +
						</div>
						<div class="indicator__number">500</div>
					</div>

					<div class="indicator indicator-alice-blue">
						<div class="indicator__title">
							<span class="icon-users indicator__logo"></span>
							Cuentas Premium
						</div>
						<div class="indicator__number">500</div>
					</div>

					<div class="indicator indicator-default">
						<div class="indicator__title">
							<span class="icon-users indicator__logo"></span>
							Cuentas gratis
						</div>
						<div class="indicator__number">500</div>
					</div>

				</div>

            </div>
        </div>
    </div>
@endsection

{{-- Footer --}}
@extends('layouts.footerapp')
@section('id_button_cancel', '')
@section('url_button_cancel', url('/dashboard/'))
@section('id_button_accept', 'add_dashboard')
@section('text_button_accept', 'Guardar Cambios')
