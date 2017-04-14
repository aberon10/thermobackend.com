<?php
namespace App\Http\Controllers;

use App\File;
use App\Interfaces\Crud;
use App\Mail;
use App\Models\ImagenUsuario;
use App\Models\Usuario;
use App\ValidationsUser;
use App\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
	{
		$this->middleware(['admin']);
	}

	/**
	 * index
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$total_users = count(Usuario::where('usuario', '!=', session('user'))->get());

		$filter = $_GET['filter'] ?? '';
		$limit  = $_GET['limit'] ?? config('config_app.MAX_USERS_PAGE');

		if (!in_array($limit, config('config_app.LIMITS'))) {
			abort(404);
		}

		if ($filter) {
			$filter = str_replace('%', '\\%', trim($filter));
			$filter = $filter."%";
		} else if(!$filter) {
			$filter = '%';
		}

		$users = \DB::table('usuario')
				->select('id_usuario', 'usuario', 'nombre', 'apellido', 'fecha_nac', 'sexo', 'correo',
					'usuario.created_at', 'usuario.updated_at', 'tipo_usuario.nombre_tipo')
				->where('usuario', 'LIKE', $filter)
				->where('usuario', '!=', session('user'))
				->join('tipo_usuario', 'usuario.id_tipo_usuario', '=', 'tipo_usuario.id_tipo_usr')
				->orderBy('tipo_usuario.id_tipo_usr', 'asc')
				->orderBy('usuario', 'asc')
				->paginate($limit);

		$index = ($users->currentPage() == 1) ? 1 : (($users->currentPage() - 1) * $limit) + 1;

		if (count($users) == 0 && $total_users == 0) {
			return redirect('users/add');
		} else if (count($users) == 0 && $total_users > 0) {
			abort(404);
		} else {
			return view('sections.users.index', compact('users', 'total_users', 'index', 'limit'));
		}
	}

	/**
	 * search
	 * @param  Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function search(Request $request)
	{
		$total_data = count(Usuario::all());
		$filter      = str_replace('%', '\\%', trim($request->filter));
		$filter      = $filter."%";
		$limit       = ($request->limit && in_array($request->limit, config('config_app.LIMITS'))) ? $request->limit : config('config_app.MAX_USERS_PAGE');

		$data = \DB::table('usuario')
				->select('id_usuario', 'usuario', 'nombre', 'apellido', 'fecha_nac', 'sexo', 'correo',
					'usuario.created_at', 'usuario.updated_at', 'tipo_usuario.nombre_tipo')
				->where('usuario', 'LIKE', $filter)
				->where('usuario', '!=', session('user'))
				->join('tipo_usuario', 'usuario.id_tipo_usuario', '=', 'tipo_usuario.id_tipo_usr')
				->orderBy('tipo_usuario.id_tipo_usr', 'asc')
				->orderBy('usuario', 'asc')
				->paginate($limit);

		$index = ($data->currentPage() == 1) ? 1 : (($data->currentPage() - 1) * $limit) + 1;

		return response()->json([
			'entitie'       => 'user',
			'filter'        => $request->filter,
			'limit'			=> $limit,
			'data'          => $data,
			'total_data'    => $total_data,
			'pagination'    => (string) $data->links(),
			'message_panel' => 'Visualizando '.$data->currentPage().' de '.$data->lastPage().' paginas de '.$total_data.' usuarios.'
		]);
	}

	/**
	 * showForm
	 * @return \Illuminate\Http\Response
	 */
	public function showForm()
	{
		return view('sections.users.add');
	}

	/**
	 * add
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function add(Request $request)
	{
		// validations fields
		if ($errors = ValidationsUser::validateFields(
			$request->only('usuario', 'cuenta', 'nombre', 'apellido', 'day', 'month', 'year', 'correo', 'sexo'))) {
			return response()->json([
				'success'  => false,
				'messages' => $errors,
				'message'  => 'Por favor, Comprueba los errores.'
		    ], 422);
		}

		// check exist user
		$exist_user = Usuario::where('usuario', '=', $request->usuario)->first();

		if ($exist_user == null) {

			$user = new Usuario;
			$user->usuario         = $request->usuario;
			$user->id_tipo_usuario = $request->cuenta;
			$user->nombre          = $request->nombre;
			$user->apellido        = $request->apellido;
			$user->correo          = $request->correo;
			$user->sexo            = $request->sexo;
			$password 			   = Password::passwordGenerate(); // genero un password aleatorio de 8 caracteres
			$user->pass            = bcrypt($password);
			$user->fecha_nac       = $request->year.'-'.$request->month.'-'.$request->day;
			$user->save();

			// Imagen Usuario
			$source = 'avatars/user.jpg';
			$target = 'avatars/'.$request->usuario.'.jpg';

			$img_usuario = new ImagenUsuario;
			$img_usuario->id_usuario = Usuario::where('usuario', '=', $request->usuario)->first()->id_usuario;
			$img_usuario->src_img = $target;
			$img_usuario->save();

			File::fullCopy(storage_path().'/app/public/'.$source, storage_path().'/app/public/'.$target);

			// Envio el correo al usuario informando del registro
			$to   = $user->correo;
			$data = [
						'username' => $user->usuario,
						'name'     => $user->nombre,
						'email'    => $user->correo,
						'password' => $password,
						'url'      => 'http://thermobackend.com/login'
					];
			$subject     = 'Bienvenid@ al Sistema ThermoBackend';
			$alt_message = 'Bienvenid@ al Sistema ThermoBackend';

			if (Mail::send($to, $data, $subject, 1, $alt_message)) {
				return response()->json([
					'success'  => true,
					'mail'     => true
			    ], 200);
			}

		} else {
			return response()->json([
				'success'  => false,
				'exist'    => true,
				'messages' => ['username' => 'El usuario ya existe'] ,
				'message'  => 'Por favor, Comprueba los errores.'
		    ], 422);
		}
	}

	/**
	 * delete
	 * @param  Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function delete(Request $request)
	{
		$users = $request->input('items');
		$count_users = count($users);

		if ($count_users > 0) {
			$exist = true;
			$i = 0;

			// compruebo si el/los usario/s existe/n
			while ($i < $count_users && $exist) {
				if (empty(Usuario::find($users[$i]))) {
					$exist = false;
				}
				$i++;
			}

			if (!$exist) {
				return response()->json([
					"success" => false,
					"message" => "El usuario seleccionado no existe."
				]);
			} else {
				$source_img = [];

				// recupero las rutas de la imagen
				for ($i=0; $i < $count_users; $i++) {
					array_push($source_img, ImagenUsuario::where('id_usuario', '=', $users[$i])->first()->src_img);
				}

				// elimino el avatar
				$count_src_img = count($source_img);
				for ($i=0; $i < $count_src_img; $i++) {
					File::removeFiles([storage_path().'/app/public/'.$source_img[$i]]);
				}

				// elimino el/los usuario/s de la DB
				for ($i=0; $i < $count_users; $i++) {
					Usuario::find($users[$i])->delete();
				}

				return response()->json([
					"success" => true,
					"message" => ($count_users > 1) ? 'Usuarios eliminados con éxito.' : 'Usuario eliminado con éxito.'
				]);
			}
		}
	}

	/**
	 * edit
	 * @return \Illuminate\Http\Response
	 */
	public function edit()
	{
		$data = Usuario::where('usuario', '=', session('user'))->get();
		return view('sections.users.edit', compact('data', 'birthdate'));
	}

	/**
	 * update
	 * @param  Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		// validations fields
		if ($errors = ValidationsUser::validateFields(
			$request->only('nombre', 'apellido', 'day', 'month', 'year', 'correo', 'sexo'))) {
			return response()->json([
				'success'  => false,
				'messages' => $errors,
				'message'  => 'Por favor, Comprueba los errores.'
		    ], 422);
		}

		$user = Usuario::where('usuario', '=', session('user'))->get();
		$user[0]->nombre    = $request->nombre;
		$user[0]->apellido  = $request->apellido;
		$user[0]->correo    = $request->correo;
		$user[0]->sexo      = $request->sexo;
		$user[0]->fecha_nac = $request->year.'-'.$request->month.'-'.$request->day;
		$user[0]->save();

		// Envio el correo al usuario informando del cambio en los datos personales
		$to   = $user[0]->correo;
		$data = [
			'username' => session('user'),
			'name'     => $user[0]->nombre,
			'email'    => $user[0]->correo,
			'message'  => 'Solo queremos informarte, que tu cuenta ha sido actualizada con exito'
		];
		$subject     = 'Cuenta actualizada';
		$alt_message = 'Cuenta actualizada';

		if (Mail::send($to, $data, $subject, 2, $alt_message)) {
			return response()->json([
				'success'  => true,
				'mail'     => true
		    ], 200);
		}
	}

	/**
	 * updateimage
	 * @param  Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function updateimage(Request $request)
	{
		$validation = Validator::make($request->only('file'),
			['file' => 'required|mimes:jpg,jpeg,png,gif|max:8192'],
			[
				'file.required' => 'El campo es requerido.',
				'file.mimes'    => 'Tipo de archivo no permitido.',
				'file.max'      => 'El archivo no debe superar los 8192kb.'
			]
		);

		if ($validation->fails()) {
			return response()->json([
				'success'  => false,
				'message' => $validation->errors()->first('file'),
		    ], 422);
		}

		$user = Usuario::where('usuario', '=', session('user'))->get();
		$img_user = ImagenUsuario::where('id_usuario', '=', $user[0]->id_usuario)->first();

		// Elimino la imagen vieja
		if (NULL != ($error = File::removeFiles([storage_path().'/app/public/'.$img_user->src_img]))) {
			return response()->json([
				'success' => false,
				'message' => $error
			], 422);
		}

		// Subo la nueva imagen
		$filename = session('user').'.'.$request->file('file')->guessClientExtension();

		$path = $request->file('file')->storeAs(
			'avatars/', $filename, 'public'
		);

		$img_user->src_img = 'avatars/'.$filename;
		$img_user->updated_at = date('Y-m-d H:i:s');
		$img_user->save();

		$request->session()->put('src_img', $img_user->src_img);

		return response()->json(['success' => true, 'src' => 'thermobackend.com/storage/'.$img_user->src_img], 200);
	}

	/**
	 * changepassword
	 * @param  Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function changepassword(Request $request)
	{
		$validation = Validator::make($request->only('current_password', 'new_password', 'confirm_password'),
			[
				'current_password' => 'required',
				'new_password'     => 'required',
				'confirm_password' => 'required',
			],
			[
				'current_password.required' => 'El campo es requerido.',
				'new_password.required'     => 'El campo es requerido.',
				'confirm_password.required' => 'El campo es requerido.',
			]
		);

		if ($validation->fails()) {
			return response()->json([
				'success'  => false,
				'messages' => $validation->errors(),
			]);
		}

		// comparo que las contraseña ingresada sea valida
		$userdata = Usuario::where('usuario', session('user'))->first();

        if (Hash::check($request->current_password, $userdata->pass)) {
        	// Compruebo que la nueva contraseña cumpla los requisitos
        	if (!preg_match('/([A-Za-z\_\.\-]+\d+\W+)/', $request->new_password) && (strlen($request->new_password) < 8 || strlen($request->new_password) > 30)) {
        		return response()->json([
					'success'  => false,
					'messages' => ['new_password' => ['Utiliza entre 8 y 30 caracteres, incluyendo letras, números y signos de puntuación (ejemplo & y -).']],
				]);
        	}

        	if ($request->new_password != $request->confirm_password) {
        		return response()->json([
					'success'  => false,
					'messages' => ['confirm_password' => ['La contraseña no coincide.']],
				]);
        	}

        	// actualizo la contraseña
        	$userdata->pass = bcrypt($request->new_password);
        	$userdata->updated_at = date('Y-m-d H:i:s');
        	$userdata->save();

			// Envio el correo al usuario informando del cambio de contraseña
			$to   = $userdata->correo;
			$data = [
				'username' => session('user'),
				'name' => $userdata->nombre,
				'email' => $userdata->correo,
				'message' => 'Solo queremos informarte, que tu contraseña fue cambiada con éxito.'
			];
			$subject     = 'Contraseña cambiada con éxito.';
			$alt_message = 'Contraseña cambiada con éxito.';

			if (Mail::send($to, $data, $subject, 2, $alt_message)) {
				return response()->json([
					'success'  => true,
					'message'  => 'Contraseña cambiada con éxito.'
			    ], 200);
			}
        } else {
        	$errors = array('current_password' => ['La contraseña ingresada no es valida']);
			return response()->json([
				'success'  => false,
				'messages' => $errors,
			]);
        }
	}

    public static function latestRecords() {
        $mes_anterior = 0;
        $mes_actual = 0;
        $diff = 0;

        $prev_date = (date('m') == 0) ? date('Y-12-01') : date('m') - 1;
        $prev_month = Usuario::where('CREATED_AT', '>=', date('Y').'-'.$prev_date.'-01')
                    ->where('CREATED_AT', '<=', date('Y').'-'.$prev_date.'-31')
                    ->where('id_tipo_usuario', '=', 3)
                    ->orWhere('id_tipo_usuario', '=', 4)
                    ->get();

        // MES ACTUAL
        $current_month = Usuario::where('CREATED_AT', '>=', date('Y-m-01'))
                    ->where('id_tipo_usuario', '=', 3)
                    ->orWhere('id_tipo_usuario', '=', 4)
                    ->get();

        $count_users_prev = count($prev_month);
        $count_users_current = count($current_month);

        // total de usuarios registrados en los ultimos 2 meses
        $total_users = $count_users_prev + $count_users_current;

        if ($total_users > 0) {
            $mes_anterior = ($count_users_prev * 100) / $total_users;
            $mes_actual = ($count_users_current * 100) / $total_users;
            $diff = $mes_actual - $mes_anterior;
        }

        return [
            'prev_month'    => $count_users_prev,
            'current_month' => $count_users_current,
            'mes_anterior'  => $mes_anterior,
            'mes_actual'    => $mes_actual,
            'diferencia'    => $diff
        ];
    }
}
