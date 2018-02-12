<?php
namespace App\Http\Controllers;

use DB;
use App\Mail;
use App\Password;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return view('sections.home', compact('users'));
    }

    public function help(Request $request)
    {
        return view('sections.help.help');
    }

    public function helpUsers(Request $request)
    {
        return view('sections.help.users');
    }

    public function helpMusic(Request $request)
    {
        return view('sections.help.music');
    }

    public function helpAdvertising(Request $request)
    {
        return view('sections.help.advertising');
    }

	public function forgotPassword(Request $request)
	{
		return view('sections.forgot');
	}

	public function disabledJS(Request $request)
	{
		return view('sections.disabledJS');
	}

	/**
	 * resetPassword
	 *
	 * @param Request $request
	 * @return void
	 */
	public function resetPassword(Request $request)
	{
		$validation = Validator::make(
			$request->only('user'),
			['user' => 'required'],
			['user.required' => 'El campo es requerido.']
		);

		if ($validation->fails()) {
			return response()->json([
				'success' => false,
				'message' => $request->only('user')
			], 422);
		}

		// check exist user
		$userdata = Usuario::where('usuario', '=', $request->user)
			->whereIn('id_tipo_usuario', [1, 2])
			->first();

		if ($userdata) {
			// GENERO EL NUEVO PASSWORD
			$password = Password::passwordGenerate();

        	// actualizo la contraseña
        	$userdata->pass = bcrypt($password);
        	$userdata->updated_at = date('Y-m-d H:i:s');
        	$userdata->save();

			// Tabla password_resets
			DB::table('password_resets')->insert(
				['id_usuario' => $userdata->id_usuario]
			);

			// Envio el correo al usuario con la nueva contraseña
			$to = $userdata->correo;
			$subject = 'Reset password.';
			$alt_message = 'Solicitud de Contraseña.';
            $content = "<body>
				<header class='header'>
					<h1 class='logo'>ThermoBackend</h1>
				</header>
				<section class='main-container'>
					<p>Hola, <b>".$userdata->nombre."</b></p>
					<p>Tu solicitud de contraseña ha sido satisfactoria.</p>
					<p>La nueva contraseña es: <b>".$password."</b></p>
					<p>Es importante que cambies tu contraseña la proxima vez que inicies sesión.</p>
					<div class='signature'>
						<p>Si tienes alguna duda, contacta a nuestro equipo de soporte o responde a este mismo correo.</p>
						<p>Gracias, El equipo de ThermoBackend.</p>
					</div>
					<footer class='footer'>
						<p>© 2016 - ".date('Y')." ThermoBackend todos los derechos reservados</p>
					</footer>
				</section>
			</body>
			</html>";

			if (Mail::sendMail($to, $userdata->usuario, $subject, $content, $alt_message)) {
				return response()->json([
					'success'  => true,
					'message'  => 'La nueva contraseña ha sido enviada a tu casilla de correo.'
			    ], 200);
			}

		} else {
			$errors = array('user' => ['El usuario ingresado no existe.']);
			return response()->json([
				'success' => false,
				'message' => $errors
			]);
		}

	}
}
