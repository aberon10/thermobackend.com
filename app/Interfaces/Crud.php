<?php
	namespace App\Interfaces;

	use Illuminate\Http\Request;

	interface Crud {
		public function add(Request $request);
		public function edit(Request $request, $id);
		public function update(Request $request, $id);
		public function delete(Request $request);
	}
