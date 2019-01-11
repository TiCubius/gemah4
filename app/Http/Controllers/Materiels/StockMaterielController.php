<?php

namespace App\Http\Controllers\Materiels;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\DomaineMateriel;
use App\Models\EtatMateriel;
use App\Models\Materiel;
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
		$domaines = DomaineMateriel::with("types")->orderBy("nom")->get();
		$etats = EtatMateriel::orderBy("nom")->get();

		if ($request->exists(["type_id", "etat_id", "marque", "modele", "num_serie"])) {
			$searchedMateriels = Materiel::search($request->input("type_id"), $request->input("etat_id"), $request->input("marque"), $request->input("modele"), $request->input("num_serie"))->get();
		}  else {
			$latestCreatedMateriels = Materiel::latestCreated()->take(10)->get();
			$latestUpdatedMateriels = Materiel::latestUpdated()->take(10)->get();
		}

		return view("web.materiels.stocks.index", compact("domaines", "etats", "latestCreatedMateriels", "latestUpdatedMateriels", "searchedMateriels"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un stock matériel
	 *
	 * @return View
	 */
	public function create(): View
	{
        $academies = Academie::with("departements")->get();
		$domaines = DomaineMateriel::with("types")->orderBy("nom")->get();
		$etats = EtatMateriel::orderBy("nom")->get();

		return view("web.materiels.stocks.create", compact("domaines", "etats", "types", "academies"));
	}

	/**
	 * POST - Ajoute un nouveau stock matériel
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			"type_id"         => "required",
			"marque"          => "required",
			"modele"          => "required",
			"num_serie"       => "nullable",
			"nom_fournisseur" => "nullable",
			"prix_ttc"        => "required",
			"etat_id"         => "required",

			"num_devis"             => "nullable",
			"num_formulaire_chorus" => "nullable",
			"num_facture_chorus"    => "nullable",
			"num_ej"                => "nullable",
			"date_ej"               => "nullable",
			"date_facture"          => "nullable",
			"date_service_fait"     => "nullable",
			"date_fin_garantie"     => "nullable",
			"acheter_pour"          => "nullable",
            "departement_id"        => "required"
		]);

		Materiel::create($request->only([
			"type_id",
			"marque",
			"modele",
			"num_serie",
			"nom_fournisseur",
			"prix_ttc",
			"etat_id",
			"num_devis",
			"num_formulaire_chorus",
			"num_facture_chrous",
			"num_ej",
			"date_ej",
			"date_facture",
			"date_service_fait",
			"date_fin_garantie",
			"acheter_pour",
            "departement_id",
		]));

		return redirect(route("web.materiels.stocks.index"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Materiel $stock
	 * @return void
	 */
	public function show(Materiel $stock)
	{
		//
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
		$domaines = DomaineMateriel::with("types")->orderBy("nom")->get();
		$etats = EtatMateriel::orderBy("nom")->get();

		return view("web.materiels.stocks.edit", compact("stock", "domaines", "etats", "types", "academies"));
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
		$request->validate([
			"type_id"         => "required",
			"marque"          => "required",
			"modele"          => "required",
			"num_serie"       => "nullable",
			"nom_fournisseur" => "nullable",
			"prix_ttc"        => "required",
			"etat_id"         => "required",
            "departement_id"  => "required",

            "num_devis"             => "nullable",
            "num_formulaire_chorus" => "nullable",
            "num_facture_chorus"    => "nullable",
            "num_ej"                => "nullable",
            "date_ej"               => "nullable",
            "date_facture"          => "nullable",
            "date_service_fait"     => "nullable",
            "date_fin_garantie"     => "nullable",
            "acheter_pour"          => "nullable",
		]);

		$stock->update($request->only([
			"type_id",
			"marque",
			"modele",
			"num_serie",
			"nom_fournisseur",
			"prix_ttc",
			"etat_id",
			"num_devis",
			"num_formulaire_chorus",
			"num_facture_chrous",
			"num_ej",
			"date_ej",
			"date_facture",
			"date_service_fait",
			"date_fin_garantie",
			"acheter_pour",
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
		$stock->delete();

		return redirect(route("web.materiels.stocks.index"));
	}
}
