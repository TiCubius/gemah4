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
		$departement_id = Session::get("user")->service->departement_id;
		$parametres = Parametre::where("departement_id", $departement_id)->get();

		$groupedParametres = $parametres->mapToGroups(function ($item, $key) {
			$parametreStart = implode('/', explode('/', $item->key, -1));
			return [$parametreStart => $item];
		})->sortKeys();


		return view("web.administrations.parametres.edit", compact("groupedParametres"));
	}

	/**
	 * PATCH - Met à jours les paramètres
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function update(Request $request): RedirectResponse
	{
		$departement_id = Session::get("user")->service->departement_id;

		foreach ($request->except(["_token", "_method"]) as $key => $value) {
			$parametre = Parametre::where(["key" => $key, "departement_id" => $departement_id]);
			$parametre->update(["value" => $value]);
		}

		return back()->with("success", "Les paramètres ont bien été modifiés");
	}
}
