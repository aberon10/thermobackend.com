<?php
namespace App\Http\Controllers;

use App\Http\Controllers\GenresController;
use App\Http\Controllers\UserController;
use App\Models\Tarea;
use App\Models\Usuario;
use Illuminate\Http\Request;
use DB;
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Usuario::where('id_tipo_usuario', '=', 4)->orWhere('id_tipo_usuario', '=', 3)->get();
        $total_users = count($users);

        // total users account facebook
        $fa_users = Usuario::whereIn('id_tipo_usuario', [3, 4])
                ->where('id_facebook', '!=', '')
                ->get();
        // total users account google+
        $g_users = Usuario::whereIn('id_tipo_usuario', [3, 4])
                ->where('id_google', '!=', '')
                ->get();
        // total users account premium
        $p_users = Usuario::where('id_tipo_usuario', '=', 3)->get();
        // total users account free
        $f_users = Usuario::where('id_tipo_usuario', '=', 4)->get();

        $facebook_users = ($total_users == 0) ? 0 : round(((count($fa_users) * 100) / $total_users), 2);
        $google_users = ($total_users == 0) ? 0 : round(((count($g_users) * 100) / $total_users), 2);
        $premium_users = ($total_users == 0) ? 0 : round(((count($p_users) * 100) / $total_users), 2);
        $free_users = ($total_users == 0) ? 0 : round(((count($f_users) * 100) / $total_users), 2);

    	$user = Usuario::where('usuario', '=', session('user'))->first();
		$tasks = Tarea::where('id_usuario', '=', $user->id_usuario)->orderBy('id_tarea', 'desc')->where('estado', '=', 'PENDIENTE')->get();

        $indicadores = array(
            'facebook' => [count($fa_users), $facebook_users],
            'google'   => [count($g_users), $google_users],
            'premium'  => [count($p_users), $premium_users],
            'free'     => [count($f_users), $free_users],
            'total'    => $total_users
        );
        return view('sections.dashboard', compact('tasks', 'indicadores'));
    }

    public function graphics()
    {
        return response()->json([
			'success'              => true,
			'porcentajes_generos'  => GenresController::mostPopular(),
			'porcentajes_usuarios' => UserController::latestRecords()
		]);
    }
}
