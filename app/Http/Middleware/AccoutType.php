<?php

namespace App\Http\Middleware;

use Closure;

class AccoutType
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($request->session()->has('user') &&
			$request->session()->has('account') &&
			session('account') == 1) {
			return $next($request);
		}

		abort(403);
	}
}
