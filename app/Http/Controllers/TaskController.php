<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function __construct()
	{
		$this->middleware('admin');
	}

	/**
	 * create
	 * @param  Request $request
	 * @return Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		$validations = Validator::make(
			$request->only('title', 'task'),
		[
			'title' => 'required|max:250',
		],
		[
			'title.required' => 'Campo requerido.',
			'title.max'  => 'Utiliza como máximo 250 caracteres.',
		]);

		if ($validations->fails()) {
			return response()->json([
				'success'  => false,
				'messages' => $validations->errors()
			], 422);
		}

		$task = new Tarea;
		$task->id_usuario = Usuario::where('usuario', '=', session('user'))->first()->id_usuario;
		$task->titulo = trim($request->title);
		$task->estado = strtoupper('PENDIENTE');
		$task->save();

		return response()->json([
			'success' => true,
			'task'    => [
					'id'    => $task->id_tarea,
					'title' => $task->titulo,
					'created_at' => $task->created_at
				]
		], 200);
	}

	/**
	 * delete
	 * @param  Request $request
	 * @return Illuminate\Http\Response
	 */
	public function delete(Request $request)
	{
		$tasks = $request->input('tasks');
		$count_tasks = count($tasks);
		$i=0;
		$delete = true;
		$message = 'Tarea eliminada con exito';

		while ($i < $count_tasks && $delete) {
			$task = Tarea::find($tasks[$i]);
			if ($task != null) {
				$task->delete();
			} else {
				$delete = false;
			}
			$i++;
		}

		if ($delete && $count_tasks > 1) {
			$message = 'Tareas eliminadas con exito.';
		} else if (!$delete) {
			$message = 'La tarea seleccionada no existe.';
		}

		return response()->json([
			'success' => $delete,
			'message' => $message
		], 200);
	}
}
