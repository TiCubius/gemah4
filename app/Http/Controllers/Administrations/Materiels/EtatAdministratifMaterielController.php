<?php

namespace App\Http\Controllers\Administrations\Materiels;

use App\Http\Controllers\Controller;
use App\Models\EtatAdministratifMateriel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EtatAdministratifMaterielController extends Controller
{

	/**
	 * GET - Affiche la liste des états administratifs matériel
	 *
	 * @return View
	 */
	public function index(): View
	{
		$etats = EtatAdministratifMateriel::orderBy("libelle")->get();

		return view("web.administrations.materiels.etats.administratifs.index", compact("etats"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un état administratif matériel
	 *
	 * @return View
	 */
	public function create(): View
	{
		return view("web.administrations.materiels.etats.administratifs.create");
	}

	/**
	 * POST - Ajoute un nouvel état administratif matériel
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			"libelle" => "required|max:191|unique:etats_administratifs_materiels",
			"couleur" => "required|max:7|unique:etats_administratifs_materiels",
		]);

		EtatAdministratifMateriel::create($request->only(["libelle", "couleur"]));

		return redirect(route("web.administrations.materiels.etats.administratifs.index"));
	}

    /**
     * GET - Affiche les données d'un état administratif matériel
     *
     * @param EtatAdministratifMateriel $administratif
     * @return View
     */
    public function show(EtatAdministratifMateriel $administratif): View
    {
        return view("web.administrations.materiels.etats.administratifs.show", compact("administratif"));
    }

	/**
	 * GET - Affiche le formulaire d'édition d'un état administratif matériel
	 *
	 * @param EtatAdministratifMateriel $administratif
	 * @return View
	 */
	public function edit(EtatAdministratifMateriel $administratif): View
	{
		return view("web.administrations.materiels.etats.administratifs.edit", compact("administratif"));
	}

	/**
	 * PUT - Enregistre les modifications apportés à l'état administratif matériel
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param EtatAdministratifMateriel $administratif
	 * @return RedirectResponse
	 */
	public function update(Request $request, EtatAdministratifMateriel $administratif): RedirectResponse
	{
		$request->validate([
			"libelle" => "required|max:191|unique:etats_administratifs_materiels,libelle,{$administratif->id}",
			"couleur" => "required|max:191|unique:etats_administratifs_materiels,couleur,{$administratif->id}",
		]);

		$administratif->update($request->only(["libelle", "couleur"]));

		return redirect(route("web.administrations.materiels.etats.administratifs.index"));
	}

	/**
	 * DELETE - Supprime l'état administratif matériel
	 *
	 * @param EtatAdministratifMateriel $administratif
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(EtatAdministratifMateriel $administratif): RedirectResponse
	{
		if ($administratif->materiels->isNotEmpty()) {
			return back()->withErrors("Impossible de supprimer un état associé à des matériels");
		}

		$administratif->delete();

		return redirect(route("web.administrations.materiels.etats.administratifs.index"));
	}
}
