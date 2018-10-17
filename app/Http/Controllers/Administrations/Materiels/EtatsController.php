<?php

namespace App\Http\Controllers\Administrations\Materiels;

use App\Http\Controllers\Controller;
use App\Models\EtatMateriel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EtatsController extends Controller
{

	/**
	 * GET - Affiche la liste des États Matériel
	 *
	 * @return View
	 */
	public function index(): View
	{
		$Etats = EtatMateriel::orderBy("nom", "ASC")->get();

		return view("web.administrations.materiels.etats.index", compact("Etats"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un état
	 *
	 * @return View
	 */
	public function create(): View
	{
		return view("web.administrations.materiels.etats.create");
	}

	/**
	 * POST - Ajoute un nouvel état matériel
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			"nom"     => "required|max:191|unique:etats_materiel",
			"couleur" => "required|max:7|unique:etats_materiel",
		]);

		EtatMateriel::create($request->only(["nom", "couleur"]));

		return redirect(route("web.administrations.materiels.etats.index"));
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un état matériel
	 *
	 * @param EtatMateriel $Etat
	 * @return View
	 */
	public function edit(EtatMateriel $Etat): View
	{
		return view("web.administrations.materiels.etats.edit", compact("Etat"));
	}

	/**
	 * PUT - Enregistre les modifications apportés à l'état matériel
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param EtatMateriel              $Etat
	 * @return RedirectResponse
	 */
	public function update(Request $request, EtatMateriel $Etat): RedirectResponse
	{
		$request->validate([
			"nom"     => "required|max:191|unique:etats_materiel,nom,{$Etat->id}",
			"couleur" => "required|max:191|unique:etats_materiel,couleur,{$Etat->id}",
		]);

		$Etat->update($request->only(["nom", "couleur"]));

		return redirect(route("web.administrations.materiels.etats.index"));
	}

	/**
	 * DELETE - Supprime l'état matériel
	 *
	 * @param EtatMateriel $Etat
	 * @return RedirectResponse
	 */
	public function destroy(EtatMateriel $Etat): RedirectResponse
	{
		if ($Etat->materiels->isNotEmpty()) {
			return back()->withErrors("Impossible de supprimer un état associé à des matériels");
		}

		$Etat->delete();

		return redirect(route("web.materiels.domaines.index"));
	}
}
