<?php
namespace App\Http\Controllers;

use App\File;
use App\Interfaces\Crud;
use App\Mail;
use App\Models\ImagenUsuario;
use App\Models\Usuario;
use App\Password;
use App\ValidationsUser;
use Illuminate\Http\Request;

class UserController extends Controller implements Crud
{
    public function __construct()
	{
		$this->middleware(['admin', 'account_type']);
	}

	/**
	 * index
	 * @return Illuminate\Http\Response
	 */
	public function index()
	{
		$total_users = count(Usuario::all());

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
	 * @return JSON
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
	 * @return Illuminate\Http\Response
	 */
	public function showForm()
	{
		return view('sections.users.add');
	}

	/**
	 * add
	 * @param Request $request
	 * @return Illuminate\Http\Response
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

			if (Mail::send($to, $data, $subject, null, $alt_message)) {
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
	 * @return Illuminate\Http\Response
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

	public function edit(Request $request, $id)
	{
		# code ...
	}

	public function update(Request $request, $id)
	{
		# code ...
	}
}
