<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
	{
		$this->middleware('admin');
	}

	public function index()
	{
		return view('sections.task.index');
	}
}
