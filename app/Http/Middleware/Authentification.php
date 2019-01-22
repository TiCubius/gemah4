<?php

namespace App\Http\Middleware;

use App\Models\Utilisateur;
use Closure;
use Illuminate\Support\Facades\Session;

class Authentification
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure                 $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (!Session::has("user")) {
			return redirect(route('web.connexion'));
		}

		// Reload user in session
		$currentUser = Session::get("user");
		$newUser = Utilisateur::with("service.permissions")->find($currentUser->id);
		Session::put("user", $newUser);

		if (!$newUser) {
			return redirect(route("web.connexion"))->withErrors("Veuillez vous reconnecter");
		}

		return $next($request);
	}
}
