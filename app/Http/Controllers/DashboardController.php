<?php
namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\Usuario;
use Illuminate\Http\Request;

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
    	$user = Usuario::where('usuario', '=', session('user'))->first();
		$tasks = Tarea::where('id_usuario', '=', $user->id_usuario)->orderBy('id_tarea', 'desc')->where('estado', '=', 'PENDIENTE')->get();
        return view('sections.dashboard', compact('tasks'));
    }
}
