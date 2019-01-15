<?php

namespace App\Http\Controllers\Administrations\Materiels;

use App\Http\Controllers\Controller;
use App\Models\EtatMateriel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EtatController extends Controller
{

	/**
	 * GET - Affiche la liste des États Matériel
	 *
	 * @return View
	 */
	public function index(): View
	{
		$etats = EtatMateriel::orderBy("nom")->get();

		return view("web.administrations.materiels.etats.index", compact("etats"));
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
	 * @param EtatMateriel $etat
	 * @return View
	 */
            public function edit(EtatMateriel $etat): View
	{
		return view("web.administrations.materiels.etats.edit", compact("etat"));
	}

	/**
	 * PUT - Enregistre les modifications apportés à l'état matériel
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param EtatMateriel              $etat
	 * @return RedirectResponse
	 */
	public function update(Request $request, EtatMateriel $etat): RedirectResponse
	{
		$request->validate([
			"nom"     => "required|max:191|unique:etats_materiel,nom,{$etat->id}",
			"couleur" => "required|max:191|unique:etats_materiel,couleur,{$etat->id}",
		]);

		$etat->update($request->only(["nom", "couleur"]));

		return redirect(route("web.administrations.materiels.etats.index"));
	}

	/**
	 * DELETE - Supprime l'état matériel
	 *
	 * @param EtatMateriel $etat
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(EtatMateriel $etat): RedirectResponse
	{
		if ($etat->materiels->isNotEmpty()) {
			return back()->withErrors("Impossible de supprimer un état associé à des matériels");
		}

		$etat->delete();

		return redirect(route("web.administrations.materiels.etats.index"));
	}
}
