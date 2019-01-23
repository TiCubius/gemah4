<?php

namespace App\Http\Controllers\Administrations\Types;

use App\Http\Controllers\Controller;
use App\Models\TypeEleve;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TypeEleveController extends Controller
{
	/**
	 * GET - Affiche la liste des types d'élèves
	 *
	 * @return View
	 */
	public function index(): View
	{
		$types_eleves = TypeEleve::orderBy("libelle")->get();

		return view("web.administrations.types.eleves.index", compact("types_eleves"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un type d'élève
	 *
	 * @return View
	 */
	public function create(): View
	{
		return view("web.administrations.types.eleves.create");
	}

	/**
	 * POST - Ajoute un nouveau type d'élève
	 *
	 * @param  Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			"libelle" => "required|max:191|unique:types_eleves,libelle",
		]);

		TypeEleve::create($request->only(["libelle"]));

		return redirect(route("web.administrations.types.eleves.index"));
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un type d'élève
	 *
	 * @param TypeEleve $eleve
	 * @return View
	 */
	public function edit(TypeEleve $eleve): View
	{
		return view("web.administrations.types.eleves.edit", compact("eleve"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au type d'élève
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param TypeEleve                 $eleve
	 * @return RedirectResponse
	 */
	public function update(Request $request, TypeEleve $eleve): RedirectResponse
	{
		$request->validate([
			"libelle" => "required|max:191|unique:types_eleves,libelle,{$eleve->id}",
		]);

		$eleve->update($request->only(["libelle"]));

		return redirect(route("web.administrations.types.eleves.index"));
	}

	/**
	 * DELETE - Supprime le type d'élève
	 *
	 * @param TypeEleve $eleve
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(TypeEleve $eleve): RedirectResponse
	{
		if ($eleve->eleves->isNotEmpty()) {
			return back()->withErrors("Le type que vous essayez de supprimer est associer a un ou plusieurs élèves");
		}

		$eleve->delete();

		return redirect(route("web.administrations.types.eleves.index"));
	}
}
