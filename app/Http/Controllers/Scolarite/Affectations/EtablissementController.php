<?php

namespace App\Http\Controllers\Scolarite\Affectations;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\Eleve;
use App\Models\Etablissement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EtablissementController extends Controller
{
	/**
	 * GET - Liste des établissements qu'il est possible d'affecter
	 *
	 * @param Eleve   $eleve
	 * @param Request $request
	 * @return View|RedirectResponse
	 */
	public function index(Eleve $eleve, Request $request)
	{
		if ($eleve->etablissement_id === null) {
			$academies = Academie::with("departements")->get();

			if ($request->exists(["nom", "ville", "telephone"])) {
				$searchedEtablissements = Etablissement::search($request->input("departement_id"), $request->input("nom"), $request->input("ville"), $request->input("telephone"))
					->get();
			}

			return view("web.scolarites.eleves.affectations.etablissements", compact("eleve", "academies", "searchedEtablissements"));
		}

		return redirect(route("web.scolarites.eleves.show", [$eleve]))->withErrors("L'élève est déjà affecté à un établissement.");
	}


	/**
	 * POST - Affecte un établissement à cet élève
	 *
	 * @param Eleve         $eleve
	 * @param Etablissement $etablissement
	 * @return RedirectResponse
	 */
	public function attach(Eleve $eleve, Etablissement $etablissement): RedirectResponse
	{
		if ($eleve->etablissement_id === null) {
			$eleve->update([
				"etablissement_id" => $etablissement->id,
			]);

			return redirect(route("web.scolarites.eleves.show", [$eleve]));
		}

		return redirect(route("web.scolarites.eleves.show", [$eleve]))->withErrors("L'élève est déjà affecté à un établissement.");
	}

	/**
	 * DELETE - Désaffecte l'établissement de cet élève
	 *
	 * @param Eleve         $eleve
	 * @param Etablissement $etablissement
	 * @return RedirectResponse
	 */
	public function detach(Eleve $eleve, Etablissement $etablissement): RedirectResponse
	{
		if ($eleve->etablissement_id == $etablissement->id) {
			$eleve->update([
				"etablissement_id" => null,
			]);

			return redirect(route("web.scolarites.eleves.show", [$eleve]));
		}

		return redirect(route("web.scolarites.eleves.show", [$eleve]))->withErrors("L'élève n'est pas affecté à cet établissement.");
	}
}
