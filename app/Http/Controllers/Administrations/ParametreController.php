<?php

namespace App\Http\Controllers\Administrations;

use App\Http\Controllers\Controller;
use App\Models\Parametre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ParametreController extends Controller
{

	/**
	 * PATCH - Met à jours les paramètres
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function update(Request $request): RedirectResponse
	{
		foreach ($request->except(["_token", "_method"]) as $key => $value) {
			$parametre = Parametre::where("key", $key);
			$parametre->update(["value" => $value]);
		}

		return back()->with("success", "Les paramètres ont bien été modifiés");
	}

}
