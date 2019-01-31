<?php

namespace App\Http\Controllers\Administrations\Types;

use App\Http\Controllers\Controller;
use App\Models\TypeEtablissement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TypeEtablissementController extends Controller
{
	/**
	 * GET - Affiche la liste des types établissements
	 *
	 * @return View
	 */
	public function index(): View
	{
		$etablissements = TypeEtablissement::orderBy("libelle")->get();

		return view("web.administrations.types.etablissements.index", compact("etablissements"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un type établissement
	 *
	 * @return View
	 */
	public function create(): View
	{
		return view("web.administrations.types.etablissements.create");
	}

	/**
	 * POST - Ajoute un nouveau type établissement
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$request->validate([
			"libelle" => "required|max:191|unique:types_etablissements,libelle",
		]);

		TypeEtablissement::create($request->only(["libelle"]));

		return redirect(route("web.administrations.types.etablissements.index"));
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un type établissement
	 *
	 * @param TypeEtablissement $etablissement
	 * @return View
	 */
	public function edit(TypeEtablissement $etablissement): View
	{
		return view("web.administrations.types.etablissements.edit", compact("etablissement"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au type établissement
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param TypeEtablissement         $etablissement
	 * @return RedirectResponse
	 */
	public function update(Request $request, TypeEtablissement $etablissement): RedirectResponse
	{
		$request->validate([
			"libelle" => "required|max:191|unique:types_etablissements,libelle,{$etablissement->id}",
		]);

		$etablissement->update($request->only(["libelle"]));

		return redirect(route("web.administrations.types.etablissements.index"));
	}

	/**
	 * DELETE - Supprime le type établissement
	 *
	 * @param TypeEtablissement $etablissement
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(TypeEtablissement $etablissement): RedirectResponse
	{
		if ($etablissement->etablissements->isNotEmpty()) {
			return back()->withErrors("Impossible de supprimer un type qui possède des établissements affectés");
		}

		$etablissement->delete();

		return redirect(route("web.administrations.types.etablissements.index"));
	}
}
