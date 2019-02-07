<?php

namespace App\Http\Controllers\Scolarites\Affectations;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\DomaineMateriel;
use App\Models\Eleve;
use App\Models\EtatAdministratifMateriel;
use App\Models\EtatPhysiqueMateriel;
use App\Models\Historique;
use App\Models\Materiel;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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
		$academies = Academie::with("departements")->get();
		$domaines = DomaineMateriel::with("types")->orderBy("libelle")->get();
		$etatsAdministratifs = EtatAdministratifMateriel::orderBy("libelle")->get();
		$etatsPhysiques = EtatPhysiqueMateriel::orderBy("libelle")->get();

		$latestCreated = Materiel::latestCreated()->where("eleve_id", null)->take(5)->get();
		$latestUpdated = Materiel::latestUpdated()->where("eleve_id", null)->take(5)->get();

		if ($request->exists(["type_materiel_id", "etat_administratif_materiel_id", "etat_physique_materiel_id", "marque", "modele", "numero_serie", "cle_produit",])) {
			$materiels = Materiel::search($request->input("departement_id"), $request->input("type_materiel_id"), $request->input("etat_administratif_materiel_id"), $request->input("etat_physique_materiel_id"), $request->input("marque"), $request->input("modele"), $request->input("numero_serie"), $request->input("cle_produit"))->where("eleve_id", null)->with("eleve", "etatAdministratif", "etatPhysique", "type", "type.domaine")->get();
		}

		return view("web.scolarites.eleves.affectations.materiels", compact("academies", "domaines", "eleve", "etatsAdministratifs", "etatsPhysiques", "latestCreated", "latestUpdated", "materiels"));
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
		if ($materiel->eleve_id != null) {
			return back()->withErrors("Impossible d'affecter un matériel qui est déjà affecté");
		}

		$materiel->update([
			'eleve_id'  => $eleve->id,
			'date_pret' => Carbon::now(),
		]);
		$eleve->update([
			'prix_global' => ($eleve->prix_global + $materiel->prix_ttc),
		]);


		// Historique : on souhaite enregistré l'affectation, il ne s'agit pas d'une modification classique
		$user = Session::get("user");
		Historique::create([
			"from_id"     => $user->id,
			"eleve_id"    => $eleve->id,
			"materiel_id" => $materiel->id,
			"type"        => "materiel/affectation",
			"information" => "Le materiel {$materiel->modele} à été affecté à l'élève {$eleve->nom} {$eleve->prenom} par {$user->nom} {$user->prenom}",
		]);

		return redirect(route("web.scolarites.eleves.show", [$eleve]));
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
		if ($materiel->eleve_id != $eleve->id) {
			return back()->withErrors("Impossible de désaffecter un matériel qui n'est pas affecté à cet élève");
		}

		$materiel->update([
			"eleve_id"  => null,
			'date_pret' => null,
		]);

		// Historique : on souhaite enregistré la désaffectation, il ne s'agit pas d'une modification classique
		$user = Session::get("user");
		Historique::create([
			"from_id"     => $user->id,
			"eleve_id"    => $eleve->id,
			"materiel_id" => $materiel->id,
			"type"        => "materiel/desaffectation",
			"information" => "Le materiel {$materiel->modele} à été désaffecté de l'élève {$eleve->nom} {$eleve->prenom} par {$user->nom} {$user->prenom}",
		]);

		return redirect(route("web.scolarites.eleves.show", [$eleve]));
	}
}
