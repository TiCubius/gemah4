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
	 * GET - Affiche le formulaire de création d'un département
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
			"id"          => "required|max:191|unique:departements",
			"nom"         => "required|max:191|unique:departements",
			"academie_id" => "required|exists:academies,id",
		]);

		Departement::create($request->only(["id", "nom", "academie_id"]));

		return redirect(route("web.administrations.departements.index"));
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un département
	 *
	 * @param Departement $departement
	 * @return View
	 */
	public function edit(Departement $departement): View
	{
		$academies = Academie::orderBy("nom")->get();

		return view("web.administrations.departements.edit", compact("academies", "departement"));
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
			"id"          => "required|max:191|unique:departements,id,{$departement->id}",
			"nom"         => "required|max:191|unique:departements,nom,{$departement->id}",
			"academie_id" => "required|exists:academies,id",
		]);

		$departement->update($request->only(["id", "nom", "academie_id"]));

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
		$errors = [];
		if ($departement->eleves->isNotEmpty()) {
			$errors[] = "Impossible de supprimer un département associé à des élèves";
		}

		if ($departement->materiels->isNotEmpty()) {
			$errors[] = "Impossible de supprimer un département associé à du matériel";
		}

		if ($departement->responsables->isNotEmpty()) {
			$errors[] = "Impossible de supprimer un département associé à des responsables";
		}

		if ($departement->etablissements->isNotEmpty()) {
			$errors[] = "Impossible de supprimer un département associé à des établissements";
		}

		if ($departement->services->isNotempty()) {
			$errors[] = "Impossible de supprimer un département associé à des services";
		}

		if (count($errors) >= 1) {
			return back()->withErrors($errors);
		}

		$departement->delete();

		return redirect(route("web.administrations.departements.index"));
	}
}
