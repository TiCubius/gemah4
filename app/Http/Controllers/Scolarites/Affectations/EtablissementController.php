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
			$types = TypeEtablissement::all();

			$latestCreated = Etablissement::latestCreated()->take(5)->get();
			$latestUpdated = Etablissement::latestUpdated()->take(5)->get();

			if ($request->exists(["departement_id", "type_etablissement_id", "nom", "ville", "telephone"])) {
				$etablissements = Etablissement::search($request->input("departement_id"), $request->input("type_etablissement_id"), $request->input("nom"), $request->input("ville"), $request->input("telephone"))->get();
			}

			return view("web.scolarites.eleves.affectations.etablissements", compact("academies", "eleve", "etablissements", "latestCreated", "latestUpdated", "types"));
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

            $user = session("user");

            Historique::create([
                "from_id"           => $user["id"],
                "eleve_id"          => $eleve->id,
                "etablissement_id"  => $etablissement->id,
                "type"              => "etablissement/affectation",
                "contenue"          => "L'élève {$eleve->nom} {$eleve->prenom} à été affecté à l'établissement {$etablissement->nom} par {$user->nom} {$user->prenom}"
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

            $user = session("user");

            Historique::create([
                "from_id"           => $user["id"],
                "eleve_id"          => $eleve->id,
                "etablissement_id"  => $etablissement->id,
                "type"              => "etablissement/desaffectation",
                "contenue"          => "L'élève {$eleve->nom} {$eleve->prenom} à été désaffecté de l'établissement {$etablissement->nom} par {$user->nom} {$user->prenom}"
            ]);

			return redirect(route("web.scolarites.eleves.show", [$eleve]));
		}

		return redirect(route("web.scolarites.eleves.show", [$eleve]))->withErrors("L'élève n'est pas affecté à cet établissement.");
	}
}
