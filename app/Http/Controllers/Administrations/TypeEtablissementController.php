<?php

namespace App\Http\Controllers\Administrations;

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
		$typeEtablissements = TypeEtablissement::orderBy("nom")->get();

		return view("web.administrations.etablissements.types.index", compact("typeEtablissements"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un type établissement
	 *
	 * @return View
	 */
	public function create(): View
	{
		return view("web.administrations.etablissements.types.create");
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
			"nom" => "required|max:191|unique:types_etablissements,nom",
		]);

		TypeEtablissement::create($request->only(["nom"]));

		return redirect(route("web.administrations.etablissements.types.index"));
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un type établissement
	 *
	 * @param TypeEtablissement $type
	 * @return View
	 */
	public function edit(TypeEtablissement $type): View
	{
		return view("web.administrations.etablissements.types.edit", compact("type"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au type établissement
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param TypeEtablissement         $type
	 * @return RedirectResponse
	 */
	public function update(Request $request, TypeEtablissement $type): RedirectResponse
	{
		$request->validate([
			"nom" => "required|max:191|unique:types_etablissements,nom,{$type->id}",
		]);

		$type->update($request->only(["nom"]));

		return redirect(route("web.administrations.etablissements.types.index"));
	}

	/**
	 * DELETE - Supprime le type établissement
	 *
	 * @param TypeEtablissement $type
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(TypeEtablissement $type): RedirectResponse
	{
		if ($type->etablissements->isNotEmpty()) {
			return back()->withErrors("Impossible de supprimer un type d'établissement tant qu'il a des établissements affectés");
		}

		$type->delete();

		return redirect(route("web.administrations.etablissements.types.index"));
	}
}
