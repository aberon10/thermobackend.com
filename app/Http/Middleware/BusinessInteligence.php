<?php

namespace App\Http\Middleware;

use Closure;

class BusinessInteligence
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
		if($request->session()->has('account') && session('account') == 2) {
			return $next($request);
		}

		abort(403);
	}
}
