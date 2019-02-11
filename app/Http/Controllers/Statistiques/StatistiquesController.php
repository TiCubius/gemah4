<?php

namespace App\Http\Controllers\Statistiques;

use App\Exports\EleveExport;
use App\Exports\MaterielExport;
use App\Filters\EleveFilters;
use App\Filters\MaterielFilters;
use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\Decision;
use App\Models\DomaineMateriel;
use App\Models\Eleve;
use App\Models\EtatAdministratifMateriel;
use App\Models\EtatPhysiqueMateriel;
use App\Models\Materiel;
use App\Models\TypeDecision;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
	 * GET - Recherche d'informations sur les élèves
	 *
	 * @param Request      $request
	 * @param EleveFilters $filter
	 * @return View
	 */
	public function eleves(Request $request, EleveFilters $filter): View
	{
		$types = TypeDecision::all();
		$academies = Academie::with("departements")->get();

		if ($request->hasAny(["departement_id", "type_eleve_id", "nom", "prenom", "etablissement", "materiels", "responsables", "documents", "ordre"])) {
			$eleves = Eleve::filter($filter)->get();
		}

		return view('web.statistiques.eleve', compact("academies", "eleves", "types"));
	}

	/**
	 * GET - Exporte les données de la recherche
	 *
	 * @param Request      $request
	 * @param EleveFilters $filter
	 * @return BinaryFileResponse
	 */
	public function elevesExport(Request $request, EleveFilters $filter): BinaryFileResponse
	{
		if ($request->hasAny(["departement_id", "type_eleve_id", "nom", "prenom", "etablissement", "materiels", "responsables", "documents", "ordre"])) {
			$eleves = Eleve::filter($filter)->get();
		} else {
			$eleves = Eleve::where("departement_id", Session::get("user")->service->departement_id)->get();
		}

		return Excel::download(new EleveExport($eleves), "eleves.csv");
	}


	/***
	 * GET - Recherche d'informations sur les matériels
	 *
	 * @param Request         $request
	 * @param MaterielFilters $filter
	 * @return View
	 */
	public function materiels(Request $request, MaterielFilters $filter): View
	{
		$academies = Academie::with("departements")->get();
		$etat_administratifs = EtatAdministratifMateriel::all();
		$etat_physiques = EtatPhysiqueMateriel::all();
		$domaines = DomaineMateriel::with("types")->get();

		if ($request->hasAny(["departement_id", "etat_administratif_materiel_id", "etat_physique_materiel_id", "type_materiel_id", "numero_serie", "cle_produit", "marque", "modele", "nom_fournisseur", "numero_devis", "numero_formulaire_chorus", "numero_facture_chorus", "numero_ej", "date_ej", "date_facture", "date_service_fait", "date_fin_garantie", "date_pret", "achat_pour", "ordre"])) {
			$materiels = Materiel::filter($filter)->get();
			$materiels->load("eleve", "type", "etatAdministratif", "etatPhysique");
		}

		return view('web.statistiques.materiel', compact("etat_administratifs", "etat_physiques", "domaines", "materiels", "types_materiel", "academies"));
	}

	/**
	 * GET - Exporte les données de la recherche
	 *
	 * @param Request         $request
	 * @param MaterielFilters $filter
	 * @return BinaryFileResponse
	 */
	public function materielsExport(Request $request, MaterielFilters $filter): BinaryFileResponse
	{
		if ($request->hasAny(["departement_id", "etat_administratif_materiel_id", "etat_physique_materiel_id", "type_materiel_id", "numero_serie", "cle_produit", "marque", "modele", "nom_fournisseur", "numero_devis", "numero_formulaire_chorus", "numero_facture_chorus", "numero_ej", "date_ej", "date_facture", "date_service_fait", "date_fin_garantie", "date_pret", "achat_pour", "ordre"])) {
			$materiels = Materiel::filter($filter)->get();
		} else {
			$materiels = Materiel::where("departement_id", Session::get("user")->service->departement_id)->get();
		}

		return Excel::download(new MaterielExport($materiels), "materiels.csv");
	}


	/**
	 * Recherche d'informations sur les décisions
	 *
	 * @param Request $request
	 * @return View
	 */
	public function decisions(Request $request): View
	{
		$date = $request->input("date") ?? Carbon::now()->subMonth(6);

		// On récupère tout les élèves
		$eleves = Eleve::with("decisions.types")->get();

		// On filtre les décisions
		// - On ne souhaite que les décisions Matériel
		$eleves->each(function (Eleve $eleve, $key) {
			$eleve->decisions = $eleve->decisions->reject(function (Decision $decision, $key) {
				return (!$decision->types->contains("libelle", "Matériel"));
			});
		});

		return view("web.statistiques.decisions", compact("date", "eleves"));
	}
}
