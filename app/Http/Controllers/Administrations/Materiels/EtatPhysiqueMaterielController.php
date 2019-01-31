<?php

namespace App\Http\Controllers\Administrations\Materiels;

use App\Http\Controllers\Controller;
use App\Models\EtatPhysiqueMateriel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EtatPhysiqueMaterielController extends Controller
{

	/**
	 * GET - Affiche la liste des États Physiques Matériel
	 *
	 * @return View
	 */
	public function index(): View
	{
		$etats = EtatPhysiqueMateriel::orderBy("libelle")->get();

		return view("web.administrations.materiels.etats.physiques.index", compact("etats"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un état
	 *
	 * @return View
	 */
	public function create(): View
	{
		return view("web.administrations.materiels.etats.physiques.create");
	}

	/**
	 * POST - Ajoute un nouvel état physique matériel
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			"libelle" => "required|max:191|unique:etats_physiques_materiels",
		]);

		EtatPhysiqueMateriel::create($request->only(["libelle"]));

		return redirect(route("web.administrations.materiels.etats.physiques.index"));
	}

    /**
     * GET - Affiche les données d'un état administratif matériel
     *
     * @param EtatPhysiqueMateriel $physique
     * @return View
     */
    public function show(EtatPhysiqueMateriel $physique): View
    {
        return view("web.administrations.materiels.etats.physiques.show", compact("physique"));
    }

	/**
	 * GET - Affiche le formulaire d'édition d'un état physique matériel
	 *
	 * @param EtatPhysiqueMateriel $physique
	 * @return View
	 */
	public function edit(EtatPhysiqueMateriel $physique): View
	{
		return view("web.administrations.materiels.etats.physiques.edit", compact("physique"));
	}

	/**
	 * PUT - Enregistre les modifications apportés à l'état physique matériel
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param EtatPhysiqueMateriel      $physique
	 * @return RedirectResponse
	 */
	public function update(Request $request, EtatPhysiqueMateriel $physique): RedirectResponse
	{
		$request->validate([
			"libelle" => "required|max:191|unique:etats_physiques_materiels,libelle,{$physique->id}",
		]);

		$physique->update($request->only(["libelle"]));

		return redirect(route("web.administrations.materiels.etats.physiques.index"));
	}

	/**
	 * DELETE - Supprime l'état physique matériel
	 *
	 * @param EtatPhysiqueMateriel $physique
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(EtatPhysiqueMateriel $physique): RedirectResponse
	{
		if ($physique->materiels->isNotEmpty()) {
			return back()->withErrors("Impossible de supprimer un état associé à des matériels");
		}

		$physique->delete();

		return redirect(route("web.administrations.materiels.etats.physiques.index"));
	}
}
