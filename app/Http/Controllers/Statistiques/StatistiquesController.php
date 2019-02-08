<?php

namespace App\Http\Controllers\Statistiques;

use App\Filters\EleveFilters;
use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\Decision;
use App\Models\Eleve;
use App\Models\TypeDecision;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class StatistiquesController extends Controller
{
	/***
	 * GET - Affiche l'index du menu Statistiques de l'application
	 *
	 * @return View
	 */
	public function index(): View
	{
		return view('web.statistiques.index');
	}

	/***
	 * GET - Recher d'informations générales
	 *
	 * @param Request      $request
	 * @param EleveFilters $filter
	 * @return View
	 */
	public function generale(Request $request, EleveFilters $filter): View
	{
		$types = TypeDecision::all();
		$academies = Academie::with("departements")->get();

		if ($request->exists(["departement_id", "type_eleve_id", "nom", "prenom", "etablissement", "materiels", "responsables", "documents", "ordre"])) {
			$eleves = Eleve::filter($filter)->get();
		} else {
			$eleves = Eleve::where("departement_id", Session::get("user")->service->departement_id)->get();
		}

		return view('web.statistiques.generale', compact("academies", "eleves", "types"));
	}

	/**
	 * Retourne la liste des élèves dont la décision a expiré depuis 6 mois
	 *
	 * @return View
	 */
	public function listeDecisionsExpirees(): View
	{
		// On récupère tout les élèves
		$eleves = Eleve::with("decisions.types")->get();

		// On filtre les décisions
		// - On ne souhaite que les décisions Matériel
		$eleves->each(function (Eleve $eleve, $key) {
			$eleve->decisions = $eleve->decisions->reject(function (Decision $decision, $key) {
				return (!$decision->types->contains("libelle", "Matériel"));
			});
		});

		return view("web.statistiques.liste_decisions_expirees", compact("eleves"));
	}
}
