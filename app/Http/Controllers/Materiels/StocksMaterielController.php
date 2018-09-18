<?php

namespace App\Http\Controllers\Materiels;

use App\Http\Controllers\Controller;
use App\Models\DomaineMateriel;
use App\Models\EtatMateriel;
use App\Models\Materiel;
use App\Models\TypeMateriel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StocksMaterielController extends Controller
{
	/**
	 * GET - Affiche la liste des stocks matériel
	 *
	 * @return View
	 */
	public function index(): View
	{
		$Materiels = Materiel::orderBy("modele", "ASC")->get();

		return view("web.materiels.stocks.index", compact("Materiels"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un stock matériel
	 *
	 * @return View
	 */
	public function create(): View
	{
		$DomainesMateriel = DomaineMateriel::orderBy("nom", "ASC")->get();
		$EtatsMateriel = EtatMateriel::orderBy("nom", "ASC")->get();
		$TypesMateriel = TypeMateriel::orderBy("nom", "ASC")->get();

		return view("web.materiels.stocks.create", compact("DomainesMateriel", "EtatsMateriel", "TypesMateriel"));
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
			"domaine_id"      => "required",
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
		]));

		return redirect(route("web.materiels.stocks.index"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Materiel $materiel
	 * @return void
	 */
	public function show(Materiel $materiel)
	{
		//
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un stock matériel
	 *
	 * @param int $id
	 * @return View
	 */
	public function edit(int $id): View
	{
		$DomainesMateriel = DomaineMateriel::orderBy("nom", "ASC")->get();
		$EtatsMateriel = EtatMateriel::orderBy("nom", "ASC")->get();
		$TypesMateriel = TypeMateriel::orderBy("nom", "ASC")->get();
		$Materiel = Materiel::findOrFail($id);

		return view("web.materiels.stocks.edit",
			compact("Materiel", "DomainesMateriel", "EtatsMateriel", "TypesMateriel"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au stock matériel
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param int                       $id
	 * @return RedirectResponse
	 */
	public function update(Request $request, int $id): RedirectResponse
	{
		$request->validate([
			"domaine_id"      => "required",
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
		]);

		$Materiel = Materiel::findOrFail($id);
		$Materiel->update($request->only([
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
		]));

		return redirect(route("web.materiels.stocks.index"));
	}

	/**
	 * DELETE - Supprime le stock matériel
	 *
	 * @param int $id
	 * @return RedirectResponse
	 */
	public function destroy(int $id): RedirectResponse
	{
		$Materiel = Materiel::findOrFail($id);
		$Materiel->delete();

		return redirect(route("web.materiels.stocks.index"));
	}
}
