<?php

namespace App\Http\Middleware;

use App\Models\Utilisateur;
use Closure;
use Illuminate\Routing\Route;
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
			if ($request->path() !== "/") {
				Session::put("redirect_uri", $request->path());
			}

			return redirect(route('web.connexion'));
		}

		if (Session::has("redirect_uri")) {
			$uri = Session::get("redirect_uri");
			Session::remove("redirect_uri");;

			return redirect($uri);
		}

		// Reload user in session
		$currentUser = Session::get("user");
		$newUser = Utilisateur::find($currentUser->id);

		if (!$newUser) {
			Session::put("user", null);

			return redirect(route("web.connexion"))->withErrors("Veuillez vous reconnecter");
		}

		if ($newUser->updated_at != $currentUser->updated_at) {
			$newUser->load("service.permissions");
			Session::put("user", $newUser);
		}

		if (!$newUser) {
			return redirect(route("web.connexion"))->withErrors("Veuillez vous reconnecter");
		}

		return $next($request);
	}
}
