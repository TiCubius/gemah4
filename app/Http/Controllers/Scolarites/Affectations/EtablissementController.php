<?php

namespace App\Http\Controllers\Scolarites\Affectations;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\Eleve;
use App\Models\Etablissement;
use App\Models\Historique;
use App\Models\TypeEtablissement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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
		if ($eleve->etablissement_id != null) {
			return back()->withErrors("L'élève est déjà affecté à un établissement.");
		}

		$academies = Academie::with("departements")->get();
		$types = TypeEtablissement::all();

		$latestCreated = Etablissement::latestCreated()->take(5)->get();
		$latestUpdated = Etablissement::latestUpdated()->take(5)->get();

		if ($request->exists(["departement_id", "type_etablissement_id", "nom", "ville", "telephone"])) {
			$etablissements = Etablissement::search($request->input("departement_id"), $request->input("type_etablissement_id"), $request->input("nom"), $request->input("ville"), $request->input("telephone"))->get();
		}

		return view("web.scolarites.eleves.affectations.etablissements", compact("academies", "eleve", "etablissements", "latestCreated", "latestUpdated", "types"));
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
		if ($eleve->etablissement_id != null) {
			return back()->withErrors("Impossible d'affecter un établissement à un élève qui possède déjà un établissement");
		}

		$eleve->update([
			"etablissement_id" => $etablissement->id,
		]);

		// Historique : on souhaite enregistré l'affectation, il ne s'agit pas d'une modification classique
		$user = Session::get("user");
		Historique::create([
			"from_id"          => $user->id,
			"eleve_id"         => $eleve->id,
			"etablissement_id" => $etablissement->id,
			"type"             => "etablissement/affectation",
			"information"      => "L'élève {$eleve->nom} {$eleve->prenom} à été affecté à l'établissement {$etablissement->nom} par {$user->nom} {$user->prenom}",
		]);

		return redirect(route("web.scolarites.eleves.show", [$eleve]));
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
		if ($eleve->etablissement_id != $etablissement->id) {
			return back()->withErrors("Impossible de désaffecter un établissement qui n'est pas affecté à cet élève");
		}

		$eleve->update([
			"etablissement_id" => null,
		]);

		// Historique : on souhaite enregistré la désaffectation, il ne s'agit pas d'une modification classique
		$user = Session::get("user");
		Historique::create([
			"from_id"          => $user->id,
			"eleve_id"         => $eleve->id,
			"etablissement_id" => $etablissement->id,
			"type"             => "etablissement/desaffectation",
			"information"      => "L'élève {$eleve->nom} {$eleve->prenom} à été désaffecté de l'établissement {$etablissement->nom} par {$user->nom} {$user->prenom}",
		]);

		return redirect(route("web.scolarites.eleves.show", [$eleve]));
	}
}
