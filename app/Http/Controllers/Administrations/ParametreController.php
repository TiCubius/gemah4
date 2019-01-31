<?php

namespace App\Http\Controllers\Administrations;

use App\Http\Controllers\Controller;
use App\Models\Parametre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ParametreController extends Controller
{
	/**
	 * GET - Affiche la page d'édition des paramètres
	 *
	 * @return View
	 */
	public function edit(): View
	{
		// On récupère les paramètres du département de l'utilisateur
		$departement_id = Session::get("user")->service->departement_id;
		$parametres = Parametre::where("departement_id", $departement_id)->get();

		// On groupe les parmaètres par catégories
		$groupedParametres = $parametres->mapToGroups(function ($item, $key) {
			$parametreStart = implode('/', explode('/', $item->key, -1));
			return [$parametreStart => $item];
		})->sortKeys();

		return view("web.administrations.parametres.edit", compact("groupedParametres"));
	}

	/**
	 * PATCH - Met à jour les paramètres
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function update(Request $request): RedirectResponse
	{
		// On récupère le département de l'utilisateur
		$departement_id = Session::get("user")->service->departement_id;

		// On modifie chaque paramètre envoyé uniquement dans le département de l'utilisateur
		foreach ($request->except(["_token", "_method"]) as $key => $value) {
			$parametre = Parametre::where(["key" => $key, "departement_id" => $departement_id]);
			$parametre->update(["value" => $value]);
		}

		return back()->with("success", "Les paramètres ont bien été modifiés");
	}
}
