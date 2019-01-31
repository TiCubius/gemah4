<?php

namespace App\Http\Controllers\Administrations;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\Departement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartementController extends Controller
{
	/**
	 * GET - Affiche la liste des départements
	 *
	 * @return View
	 */
	public function index(): View
	{
		$departements = Departement::with("academie")->orderBy("nom")->get();

		return view("web.administrations.departements.index", compact("departements"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un Département
	 *
	 * @return View
	 */
	public function create(): View
	{
		$academies = Academie::orderBy("nom")->get();

		return view("web.administrations.departements.create", compact("academies"));
	}

	/**
	 * POST - Enregistre un Departement
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			"id"       => "required|min:1|max:191|unique:departements",
			"nom"      => "required|max:191|unique:departements",
			"academie" => "required|exists:academies,id",
		]);

		Departement::create([
			"id"          => $request->input("id"),
			"nom"         => $request->input("nom"),
			"academie_id" => $request->input("academie"),
		]);

		return redirect(route("web.administrations.departements.index"));
	}

    /**
     * GET - Affiche les données d'une académie
     *
     * @param Departement $departement
     * @return View
     */
    public function show(Departement $departement): View
    {
        return view("web.administrations.departements.show", compact("departement"));
    }

	/**
	 * GET - Affiche le formulaire d'édition d'un Départements
	 *
	 * @param Departement $departement
	 * @return View
	 */
	public function edit(Departement $departement): View
	{
		$academies = Academie::orderBy("nom")->get();

		return view("web.administrations.departements.edit", compact("departement", "academies"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au Département
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Departement               $departement
	 * @return RedirectResponse
	 */
	public function update(Request $request, Departement $departement): RedirectResponse
	{
		$request->validate([
			"id"       => "required|min:1|max:191|unique:departements,id,{$departement->id}",
			"nom"      => "required|max:191|unique:departements,nom,{$departement->id}",
			"academie" => "required|exists:academies,id",
		]);

		$departement->update([
			"id"          => $request->input("id"),
			"nom"         => $request->input("nom"),
			"academie_id" => $request->input("academie"),
		]);

		return redirect(route("web.administrations.departements.index"));
	}

	/**
	 * DELETE - Supprime le Département
	 *
	 * @param Departement $departement
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Departement $departement): RedirectResponse
	{
		if (!($departement->eleves->isNotEmpty() or $departement->materiels->isNotEmpty() or $departement->responsables->isNotEmpty() or $departement->etablissements->isNotEmpty()  or $departement->services->isNotEmpty())) {
			$departement->delete();

			return redirect(route("web.administrations.departements.index"));
		}

		return redirect(route("web.administrations.departements.index"))->withErrors("Ce département est lié à au moins un élève, un matériel, un responsable ou un établissement");
	}
}
