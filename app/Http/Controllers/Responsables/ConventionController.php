<?php

namespace App\Http\Controllers\Responsables;

use App\Http\Controllers\Controller;
use App\Models\Decision;
use App\Models\Eleve;
use App\Models\Parametre;
use App\Models\Responsable;
use App\Models\TypeDecision;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class ConventionController extends Controller
{
	/**
	 * GET - Affiche la liste de tous les responsables liés à un élève avec l'état de signature (et la date si défini)
	 *
	 * @return View
	 */
	public function index(): View
	{
		$departement = Session::get("user")->service->departement_id;
		$allParametres = Parametre::conventions($departement)->get();
		$eleves = Eleve::has("responsables")->with("responsables")->orderBy("nom")->orderBy("prenom")->get();

		// Réorganisation des paramètres
		$parametres = [];
		foreach ($allParametres as $parametre) {
			$parametres[$parametre->key] = ["libelle" => $parametre->libelle, "value" => $parametre->value];
		}

		return view("web.conventions.index", compact("eleves", "parametres"));
	}

	/**
	 * PATCH - Met à jour l'état des signatures des conventions
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
	 * GET - Génération d'un PDF comprennant la liste des responsables ayant signé
	 *
	 * @return Response
	 */
	public function signaturesEffectuees(): Response
	{
		$titre = "Liste des responsables ayant signé";
		$responsables = Responsable::with("eleves")->has("eleves")->orderBy('nom')->orderBy('prenom')->get();
		$etatAttendu = 1;

		return PDF::loadView('pdf.signatures', compact('titre', 'responsables', 'etatAttendu'))->stream();
	}

	/***
	 * GET - Génération d'un PDF comprennant la liste des responsables n'ayant pas signé
	 *
	 * @return Response
	 */
	public function signaturesManquantes(): Response
	{
		$titre = "Liste des responsables n'ayant pas signé";
		$responsables = Responsable::with("eleves")->has("eleves")->orderBy('nom')->orderBy('prenom')->get();
		$etatAttendu = 0;

		return PDF::loadView('pdf.signatures', compact('titre', 'responsables', 'etatAttendu'))->stream();
	}

	/***
	 * GET - Génération des PDF de conventions pour tous les responsables n'ayant pas signé
	 *
	 * @return Response
	 */
	public function impressionsToutesConventions()
	{
		// On récupère le département de l'utilisateur
		$departement = Session::get("user")->service->departement_id;

		// On récupère le type décision "Matériel"
		$typeDecision = TypeDecision::where("libelle", "Matériel")->first();

		// On récupère toutes les décisions qui possèdent ce type matériel
		$decisions = Decision::whereHas("types", function ($query) use ($typeDecision) {
			return $query->where("id", $typeDecision->id);
		})->get()->pluck("id");

		// On récupère tout les élèves qui ont :
		// - une des décision ci-dessus
		// - du matériel
		// - un établissement
		// - des responsavles
		// - les responsales n'ont pas signés
		$eleves = Eleve::with("responsables", "etablissement", "decisions", "materiels", "materiels.type", "materiels.type.domaine")->join("eleve_responsable", "eleves.id", "=", "eleve_responsable.eleve_id")->has("etablissement")->has("decisions")->has("materiels")->has("responsables")->where("eleve_responsable.etat_signature", "=", 0)->whereHas("decisions", function ($query) use ($decisions) {
			return $query->whereIn("decisions.id", $decisions);
		})->orderBy("eleves.nom")->get();

		// Récupération de tout les paramètres pour imprimer les conventions
		$allParametres = Parametre::conventions($departement)->get();
		$parametres = [];
		foreach ($allParametres as $parametre) {
			$parametres[$parametre->key] = $parametre->value;
		}

		return PDF::loadView("pdf.conventions", compact('eleves', 'parametres'))->stream();
	}
}
