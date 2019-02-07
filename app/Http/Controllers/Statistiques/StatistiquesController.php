<?php

namespace App\Http\Controllers\Statistiques;

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
use App\Models\TypeMateriel;
use Carbon\Carbon;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
	public function listeEleves(Request $request, EleveFilters $filter): View
	{
		$types = TypeDecision::all();
		$academies = Academie::with("departements")->get();

		if ($request->exists(["departement_id", "type_eleve_id", "nom", "prenom", "etablissement", "materiels", "responsables", "documents", "ordre"])) {
			$eleves = Eleve::filter($filter)->get();
		} else {
			$eleves = Eleve::where("departement_id", Session::get("user")->service->departement_id)->get();
		}

		return view('web.statistiques.eleve', compact("academies", "eleves", "types"));

	}
    /***
     * GET - Recher d'informations générales
     *
     * @param Request      $request
     * @param EleveFilters $filter
     * @return View
     */
    public function listeMateriels(Request $request, MaterielFilters $filter): View
    {
        $types = TypeMateriel::all();
        $academies = Academie::with("departements")->get();
        $etat_administratifs = EtatAdministratifMateriel::all();
        $etat_physiques = EtatPhysiqueMateriel::all();
        $domaines = DomaineMateriel::with("types")->get();

        if ($request->exists(["departement_id", "etat_administratif_materiel_id", "etat_physique_materiel_id", "type_materiel_id", "numero_serie", "cle_produit", "marque", "modele" ,"nom_fournisseur", "numero_devis", "numero_formulaire_chorus", "numero_facture_chorus", "numero_ej", "date_ej", "date_facture", "date_service_fait", "date_fin_garantie", "date_pret", "achat_pour", "ordre"])) {
            $materiels = Materiel::filter($filter)->get();
        } else {
            $materiels = Materiel::where("departement_id", Session::get("user")->service->departement_id)->get();
        }
        $materiels->load("eleve", "type", "etatAdministratif", "etatPhysique");
        return view('web.statistiques.materiel', compact("etat_administratifs", "etat_physiques", "domaines", "materiels", "types_materiel", "academies"));

    }

	/**
	 * Retourne la liste des élèves dont la décision a expiré depuis 6 mois
	 *
	 * @return View
	 */
	public function listeDecisionsExpirees(): View
	{
		$date = Carbon::now()->subMonth(6)->format('Y-m-d');

		$eleves = Eleve::join("documents", "documents.eleve_id", "eleves.id")->join("decisions", "decisions.document_id", "documents.id")->groupBy("eleves.id")->havingRaw("date_limite < '{$date}'")->selectRaw("eleves.*, MAX(decisions.date_limite) as date_limite")->get();
		$eleves->load("decisions");

		return view("web.statistiques.liste_decisions_expirees", compact("eleves"));
	}
}
