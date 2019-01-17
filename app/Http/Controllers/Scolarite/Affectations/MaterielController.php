<?php

namespace App\Http\Controllers\Scolarite\Affectations;

use App\Http\Controllers\Controller;
use App\Models\DomaineMateriel;
use App\Models\Eleve;
use App\Models\EtatMateriel;
use App\Models\Materiel;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaterielController extends Controller
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
		$domaines = DomaineMateriel::with("types")->orderBy("libelle")->get();
		$etats = EtatMateriel::orderBy("libelle")->get();

		if ($request->exists(["type_materiel_id", "etat_materiel_id", "marque", "modele", "num_serie"])) {
			$searchedMateriels = Materiel::search($request->input("type_materiel_id"), $request->input("etat_materiel_id"), $request->input("marque"), $request->input("modele"), $request->input("num_serie"))
				->where("eleve_id", null)
				->get();
		}

		return view("web.scolarites.eleves.affectations.materiels", compact("eleve", "domaines", "etats", "searchedMateriels"));
	}


	/**
	 * POST - Affecte un matériel à cet élève
	 *
	 * @param Eleve    $eleve
	 * @param Materiel $materiel
	 * @return RedirectResponse
	 */
	public function attach(Eleve $eleve, Materiel $materiel): RedirectResponse
	{
		if ($materiel->eleve_id === null) {
			$materiel->update([
				'eleve_id'  => $eleve->id,
				'date_pret' => Carbon::now(),
			]);
			$eleve->update([
				'prix_global' => ($eleve->prix_global + $materiel->prix_ttc),
			]);

			return redirect(route("web.scolarites.eleves.show", [$eleve]));
		}

		return redirect(route("web.scolarites.eleves.show", [$eleve]))->withErrors("Ce matériel est déjà affecté.");
	}

	/**
	 * DELETE - Désaffecte le matériel de cet élève
	 *
	 * @param Eleve    $eleve
	 * @param Materiel $materiel
	 * @return RedirectResponse
	 */
	public function detach(Eleve $eleve, Materiel $materiel): RedirectResponse
	{
		if ($materiel->eleve_id == $eleve->id) {
			$materiel->update([
				"eleve_id"  => null,
				'date_pret' => null,
			]);

			return redirect(route("web.scolarites.eleves.show", [$eleve]));
		}

		return redirect(route("web.scolarites.eleves.show", [$eleve]))->withErrors("Ce matériel n'est pas affecté à cet élève");
	}
}
