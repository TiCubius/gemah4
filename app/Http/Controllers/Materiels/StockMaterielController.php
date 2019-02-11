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
		$etatsAdministratifs = EtatAdministratifMateriel::orderBy("libelle")->get();
		$etatsPhysiques = EtatPhysiqueMateriel::orderBy("libelle")->get();

		$latestCreated = Materiel::latestCreated()->take(5)->get();
		$latestUpdated = Materiel::latestUpdated()->take(5)->get();

		if ($request->exists(["type_materiel_id", "etat_administratif_materiel_id", "etat_physique_materiel_id", "marque", "modele", "numero_serie", "cle_produit", "achat_pour"])) {
			$materiels = Materiel::search($request->input("departement_id"), $request->input("type_materiel_id"), $request->input("etat_administratif_materiel_id"), $request->input("etat_physique_materiel_id"), $request->input("marque"), $request->input("modele"), $request->input("numero_serie"), $request->input("cle_produit"), $request->input("achat_pour"))->with("eleve", "etatAdministratif", "etatPhysique", "type", "type.domaine")->get();
		}

		return view("web.materiels.stocks.index", compact("academies", "domaines", "etatsAdministratifs", "etatsPhysiques", "latestCreated", "latestUpdated", "materiels"));
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
		$etatsAdministratifs = EtatAdministratifMateriel::orderBy("libelle")->get();
		$etatsPhysiques = EtatPhysiqueMateriel::orderBy("libelle")->get();

		return view("web.materiels.stocks.create", compact("academies", "domaines", "etatsAdministratifs", "etatsPhysiques", "types"));
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
			"type_materiel_id"               => "required|exists:types_materiels,id",
			"marque"                         => "required",
			"modele"                         => "required",
			"numero_serie"                   => "nullable",
			"nom_fournisseur"                => "nullable",
			"prix_ttc"                       => "required",
			"etat_administratif_materiel_id" => "required|exists:etats_administratifs_materiels,id",
			"etat_physique_materiel_id"      => "required|exists:etats_physiques_materiels,id",
			"departement_id"                 => "required|exists:departements,id",

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
		$etatsAdministratifs = EtatAdministratifMateriel::orderBy("libelle")->get();
		$etatsPhysiques = EtatPhysiqueMateriel::orderBy("libelle")->get();

		return view("web.materiels.stocks.edit", compact("academies", "domaines", "etatsAdministratifs", "etatsPhysiques", "stock", "types"));
	}

	/**
	 * PATCH - Enregistre les modifications apportés au stock matériel
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Materiel                  $stock
	 * @return RedirectResponse
	 */
	public function update(Request $request, Materiel $stock): RedirectResponse
	{
		$dateAfter = Carbon::now()->subYear(25);
		$dateBefore = Carbon::now()->addYear(25);

		$request->validate([
			"type_materiel_id"               => "required|exists:types_materiels,id",
			"marque"                         => "required",
			"modele"                         => "required",
			"numero_serie"                   => "nullable",
			"nom_fournisseur"                => "nullable",
			"prix_ttc"                       => "required",
			"etat_administratif_materiel_id" => "required|exists:etats_administratifs_materiels,id",
			"etat_physique_materiel_id"      => "required|exists:etats_physiques_materiels,id",
			"departement_id"                 => "required|exists:departements,id",

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
		if ($stock->eleve_id !== null) {
			return back()->withErrors("Impossible de supprimer un matériel associé à un élève");
		}

		$stock->delete();

		return redirect(route("web.materiels.stocks.index"));
	}
}
