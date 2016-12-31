<?php
namespace App\Http\Controllers;

use App\Models\Usuario;
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
            'pass'    => 'required',
        ], [
            'usuario.required' => 'Ingresa tu nombre de usuario',
            'pass.required'    => 'Ingresa tu contraseña'
        ]); 
        
        $userdata = Usuario::where('usuario', $request->usuario)->first();

        if ($userdata != null) {
            // comparo el hash con el password ingresado   
            if (Hash::check($request->pass, $userdata->pass)) {
                    
                // creo una sesion 
                $request->session()->regenerate();

                $request->session()->put('user', $request->usuario);

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

    function __construct(){}
}
