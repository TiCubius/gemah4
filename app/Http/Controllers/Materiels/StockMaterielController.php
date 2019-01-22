<?php

namespace App\Http\Controllers\Materiels;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\DomaineMateriel;
use App\Models\EtatAdministratifMateriel;
use App\Models\EtatPhysiqueMateriel;
use App\Models\Materiel;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockMaterielController extends Controller
{
	/**
	 * GET - Affiche la liste des stocks matériel
	 *
	 * @param Request $request
	 * @return View
	 */
	public function index(Request $request): View
	{
		$academies = Academie::with("departements")->get();
		$domaines = DomaineMateriel::with("types")->orderBy("libelle")->get();
		$etats_administratifs = EtatAdministratifMateriel::orderBy("libelle")->get();
        $etats_physiques = EtatPhysiqueMateriel::orderBy("libelle")->get();

		if ($request->exists(["type_materiel_id", "etat_administratif_materiel_id", "etat_physique_materiel_id", "marque", "modele", "numero_serie", "cle_produit",])) {
			$searchedMateriels = Materiel::search($request->input("departement_id"), $request->input("type_materiel_id"), $request->input("etat_administratif_materiel_id"), $request->input("etat_physique_materiel_id"), $request->input("marque"), $request->input("modele"), $request->input("numero_serie"), $request->input("cle_produit"))->with("eleve", "etat_administratif", "etat_physique", "type", "type.domaine")->get();
		} else {
			$latestCreatedMateriels = Materiel::latestCreated()->take(10)->get();
			$latestUpdatedMateriels = Materiel::latestUpdated()->take(10)->get();
		}

		return view("web.materiels.stocks.index", compact("academies", "domaines", "etats_administratifs", "etats_physiques", "latestCreatedMateriels", "latestUpdatedMateriels", "searchedMateriels"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un stock matériel
	 *
	 * @return View
	 */
	public function create(): View
	{
		$academies = Academie::with("departements")->get();
		$domaines = DomaineMateriel::with("types")->orderBy("libelle")->get();
		$etats_administratifs = EtatAdministratifMateriel::orderBy("libelle")->get();
        $etats_physiques = EtatPhysiqueMateriel::orderBy("libelle")->get();

		return view("web.materiels.stocks.create", compact("domaines", "etats_administratifs", "etats_physiques", "types", "academies"));
	}

	/**
	 * POST - Ajoute un nouveau stock matériel
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$dateBefore = Carbon::now()->addYear(25);
		$dateAfter = Carbon::now()->subYear(25);

		$request->validate([
			"type_materiel_id" => "required",
			"marque"           => "required",
			"modele"           => "required",
			"numero_serie"     => "nullable",
			"nom_fournisseur"  => "nullable",
			"prix_ttc"         => "required",
			"etat_administratif_materiel_id" => "required",
            "etat_physique_materiel_id" => "required",

			"numero_devis"             => "nullable",
			"numero_formulaire_chorus" => "nullable",
			"numero_facture_chorus"    => "nullable",
			"numero_ej"                => "nullable",
			"date_ej"                  => "nullable|before:{$dateBefore},after:{$dateAfter}",
			"date_facture"             => "nullable|before:{$dateBefore},after:{$dateAfter}",
			"date_service_fait"        => "nullable|before:{$dateBefore},after:{$dateAfter}",
			"date_fin_garantie"        => "nullable|before:{$dateBefore},after:{$dateAfter}",
			"achat_pour"               => "nullable",
			"departement_id"           => "required|exists:departements,id",
		]);

		Materiel::create($request->only([
			"type_materiel_id",
			"marque",
			"modele",
			"numero_serie",
			"nom_fournisseur",
			"prix_ttc",
            "etat_administratif_materiel_id",
            "etat_physique_materiel_id",
            "numero_devis",
			"numero_formulaire_chorus",
			"numero_facture_chorus",
			"numero_ej",
			"date_ej",
			"date_facture",
			"date_service_fait",
			"date_fin_garantie",
			"achat_pour",
			"departement_id",
		]));

		return redirect(route("web.materiels.stocks.index"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Materiel $stock
	 * @return View
	 */
	public function show(Materiel $stock): View
	{
		return view("web.materiels.stocks.show", compact("stock"));
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un stock matériel
	 *
	 * @param Materiel $stock
	 * @return View
	 */
	public function edit(Materiel $stock): View
	{
		$academies = Academie::with("departements")->get();
		$domaines = DomaineMateriel::with("types")->orderBy("libelle")->get();
        $etats_administratifs = EtatAdministratifMateriel::orderBy("libelle")->get();
        $etats_physiques = EtatPhysiqueMateriel::orderBy("libelle")->get();

		return view("web.materiels.stocks.edit", compact("stock", "domaines", "etats_administratifs", "etats_physiques",         "types", "academies"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au stock matériel
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Materiel                  $stock
	 * @return RedirectResponse
	 */
	public function update(Request $request, Materiel $stock): RedirectResponse
	{
		$dateBefore = Carbon::now()->addYear(25);
		$dateAfter = Carbon::now()->subYear(25);

		$request->validate([
			"type_materiel_id" => "required",
			"marque"           => "required",
			"modele"           => "required",
			"numero_serie"     => "nullable",
			"nom_fournisseur"  => "nullable",
			"prix_ttc"         => "required",
            "etat_administratif_materiel_id" => "required",
            "etat_physique_materiel_id" => "required",
			"departement_id"   => "required|exists:departements,id",

			"numero_devis"             => "nullable",
			"numero_formulaire_chorus" => "nullable",
			"numero_facture_chorus"    => "nullable",
			"numero_ej"                => "nullable",
			"date_ej"                  => "nullable|before:{$dateBefore},after:{$dateAfter}",
			"date_facture"             => "nullable|before:{$dateBefore},after:{$dateAfter}",
			"date_service_fait"        => "nullable|before:{$dateBefore},after:{$dateAfter}",
			"date_fin_garantie"        => "nullable|before:{$dateBefore},after:{$dateAfter}",
			"achat_pour"               => "nullable",
		]);

		$stock->update($request->only([
			"type_materiel_id",
			"marque",
			"modele",
			"numero_serie",
			"nom_fournisseur",
			"prix_ttc",
            "etat_administratif_materiel_id",
            "etat_physique_materiel_id",
			"numero_devis",
			"numero_formulaire_chorus",
			"numero_facture_chorus",
			"numero_ej",
			"date_ej",
			"date_facture",
			"date_service_fait",
			"date_fin_garantie",
			"achat_pour",
			"departement_id",
		]));

		return redirect(route("web.materiels.stocks.index"));
	}

	/**
	 * DELETE - Supprime le stock matériel
	 *
	 * @param Materiel $stock
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Materiel $stock): RedirectResponse
	{
		if ($stock->eleve_id === null) {
			$stock->delete();

			return redirect(route("web.materiels.stocks.index"));
		}

		return back()->withErrors("Impossible de supprimer un matériel lorsqu'il est associé à un élève");
	}
}
