<?php
namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\ImagenUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

class LoginController extends Controller
{

    /**
     * showLoginForm
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        // valido que se envien los datos
        $this->validate($request, [
            'usuario' => 'required',
            'pass'    => 'required'
        ], [
            'usuario.required' => 'Ingresa tu nombre de usuario',
            'pass.required'    => 'Ingresa tu contraseña'
        ]);

        $user = strtolower($request->usuario);
		$userdata = Usuario::where('usuario', $user)->first();
		$id_user  = $userdata->id_usuario;

        if ($userdata != null) {
            // comparo el hash con el password ingresado
            if (Hash::check($request->pass, $userdata->pass)) {

            	// compruebo si es el primer inicio de sesion
            	if ($userdata->cuenta_valida == NULL) {
            		$userdata->cuenta_valida = 'S';
            		$userdata->save();
            	}

            	// recupero la imagen
            	$img = ImagenUsuario::where('id_usuario', '=', $id_user)->first();

            	$src_img = (isset($img)) ? $img->src_img : 'avatars/user.jpg';

                // creo una sesion
                $request->session()->regenerate();

                $request->session()->put('user', $user);
                $request->session()->put('src_img', $src_img);
                $request->session()->put('account', $userdata->id_tipo_usuario);

                return redirect('/dashboard');

            } else {
                return redirect('/login')
                    ->withErrors(['message_error' => 'Las credenciales no son validas.'])
                    ->withInput();
            }
        } else {
            return redirect('/login')
                ->withErrors(['message_error' => 'Las credenciales no son validas.'])
                ->withInput();
        }
    }
}
