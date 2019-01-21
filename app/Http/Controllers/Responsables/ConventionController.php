<?php

namespace App\Http\Controllers\Responsables;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\Eleve;
use App\Models\Parametre;
use App\Models\Responsable;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ConventionController extends Controller
{
	/**
	 * GET - Affiche la liste de tous les responsables liés à un élève avec l'état de signature (et la date si défini)
	 *
	 * @return View
	 */
	public function index(): View
	{
		$eleves = Eleve::has("responsables")->with("responsables")->orderBy("nom")->orderBy("prenom")->get();

		$allParametres = Parametre::conventions(42)->orderBy("key")->get();

		$parametres = [];
		foreach ($allParametres as $parametre) {
			$parametres[$parametre->key] = ["libelle" => $parametre->libelle, "value" => $parametre->value];
		}


		return view("web.conventions.index", compact("eleves", "parametres"));
	}

	/**
	 * PATCH - Met à jour les signatures (et la date de ces dernières) des conventions
	 *
	 * @param  Request $request
	 * @return RedirectResponse
	 */
	public function update(Request $request): RedirectResponse
	{
		$eleves = Eleve::with("responsables")->has("responsables")->get();

		foreach ($eleves as $eleve) {
			foreach ($eleve->responsables as $responsable) {
				if ($request->input("eleve-{$eleve->id}_responsable-{$responsable->id}") != null && $responsable->pivot->etat_signature == 0) {
					// Si la convention n'était pas signée, mais que la checkbox correspondant est maintenant cochée
					$responsable->pivot->update([
						"etat_signature" => 1,
						"date_signature" => Carbon::now(),
					]);
				} elseif (($request->input("eleve-{$eleve->id}_responsable-{$responsable->id}") == null)) {
					// Si la convention était signée, mais que la checkbox est maintenant décochée
					$responsable->pivot->update([
						"etat_signature" => 0,
						"date_signature" => null,
					]);
				}
			}
		}

		return redirect(route("web.conventions.index"));
	}


	/***
	 * Génération d'un PDF comprennant la liste des responsables ayant signé (avec le/les élèves impacté)
	 *
	 * @return Response
	 */
	public function signatures_effectues(): Response
	{
		$titre = "Liste des responsables ayant signé";
		$responsables = Responsable::with("eleves")->has("eleves")->get();
		$etatAttendu = 1;

		return PDF::loadView('pdf.signatures', compact('titre', 'responsables', 'etatAttendu'))->stream();
	}

	/***
	 * Génération d'un PDF comprennant la liste des responsables n'ayant pas signé (avec le/les élèves impacté)
	 *
	 * @return Response
	 */
	public function signatures_manquantes(): Response
	{
		$titre = "Liste des responsables n'ayant pas signé";
		$responsables = Responsable::with("eleves")->has("eleves")->get();
		$etatAttendu = 0;

		return PDF::loadView('pdf.signatures', compact('titre', 'responsables', 'etatAttendu'))->stream();
	}

	/***
	 * Génération des PDF de conventions pour tous les élèves ayant au moins un responsable, un matériel, une décision et étant lié à un établissement
	 * Et où le responsable n'a pas signé
	 *
	 * @return Response
	 */
	public function impressions_toutes_conventions()
	{
		$eleves = Eleve::with("responsables", "etablissement", "decisions", "materiels", "materiels.type", "materiels.type.domaine")->join("eleve_responsable", "eleves.id", "=", "eleve_responsable.eleve_id")->has("etablissement")->has("decisions")->has("materiels")->has("responsables")->where("eleve_responsable.etat_signature", "=", 0)->get();

		// Récupération de tout les paramètres pour imprimer les conventions
		$allParametres = Parametre::conventions(42)->get();
		$parametres = [];
		foreach ($allParametres as $parametre) {
			$parametres[$parametre->key] = $parametre->value;
		}

		return PDF::loadView('pdf.conventions', compact('eleves', 'parametres'))->stream();
	}
}
