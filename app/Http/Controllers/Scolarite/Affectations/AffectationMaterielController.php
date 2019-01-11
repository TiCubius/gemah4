<?php

namespace App\Http\Controllers\Scolarite\Affectations;

use App\Http\Controllers\Controller;
use App\Models\DomaineMateriel;
use App\Models\Eleve;
use App\Models\EtatMateriel;
use App\Models\Materiel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AffectationMaterielController extends Controller
{
	/**
	 * GET - Liste du matériel qu'il est possible d'affecter
	 *
	 * @param Eleve   $eleve
	 * @param Request $request
	 * @return View
	 */
	public function index(Eleve $eleve, Request $request): View
	{
		$domaines = DomaineMateriel::with("types")->orderBy("nom")->get();
		$etats = EtatMateriel::orderBy("nom")->get();

		if ($request->exists(["type_id", "etat_id", "marque", "modele", "num_serie"])) {
			$searchedMateriels = Materiel::search($request->input("type_id"), $request->input("etat_id"), $request->input("marque"), $request->input("modele"), $request->input("num_serie"))
				->where("eleve_id", null)
				->get();
		}

		return view("web.scolarites.eleves.affectations.materiels", compact("eleve", "domaines", "etats", "latestCreatedMateriels", "latestUpdatedMateriels", "searchedMateriels"));
	}


	/**
	 * POST - Affecte un matériel à l'élève
	 *
	 * @param Eleve    $eleve
	 * @param Materiel $materiel
	 * @return RedirectResponse
	 */
	public function attach(Eleve $eleve, Materiel $materiel): RedirectResponse
	{
		if ($materiel->eleve_id !== $eleve->id and !($materiel->eleve_id)) {
			$materiel->update([
				'eleve_id' => $eleve->id,
			]);
			$eleve->update([
				'prix_global' => ($eleve->prix_global + $materiel->prix_ttc),
			]);
			return redirect()->route("web.scolarites.eleves.show", [$eleve]);
		}

		return redirect()
			->route("web.scolarites.eleves.show", [$eleve])
			->withErrors("Le materiel est deja affecte a l'eleve");
	}

	/**
	 * DELETE - Désaffecte le matériel de l'élève
	 *
	 * @param Eleve    $eleve
	 * @param Materiel $materiel
	 * @return RedirectResponse
	 */
	public function detach(Eleve $eleve, Materiel $materiel): RedirectResponse
	{
		if ($materiel->eleve_id == $eleve->id) {
			$materiel->update(["eleve_id" => null]);

			return redirect()->route("web.scolarites.eleves.show", [$eleve]);
		}

		return redirect()
			->route("web.scolarites.eleves.show", [$eleve])
			->withErrors("Le matériel est déjà affecté à l'élève");
	}
}
