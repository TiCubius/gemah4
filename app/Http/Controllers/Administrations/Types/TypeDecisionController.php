<?php

namespace App\Http\Controllers\Administrations\Types;

use App\Http\Controllers\Controller;
use App\Models\TypeDecision;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TypeDecisionController extends Controller
{
	/**
	 * GET - Affiche la liste des types de décisions
	 *
	 * @return View
	 */
	public function index(): View
	{
		$types = TypeDecision::orderBy("libelle")->get();

		return view("web.administrations.types.decisions.index", compact("types"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un type de décision
	 *
	 * @return View
	 */
	public function create(): View
	{
		return view("web.administrations.types.decisions.create");
	}

	/**
	 * POST - Ajoute un nouveau type de décision
	 *
	 * @param  Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			"libelle" => "required|max:191|unique:types_decisions,libelle",
		]);

		TypeDecision::create($request->only(["libelle"]));

		return redirect(route("web.administrations.types.decisions.index"));
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un type de décision
	 *
	 * @param TypeDecision $decision
	 * @return View
	 */
	public function edit(TypeDecision $decision): View
	{
		return view("web.administrations.types.decisions.edit", compact("decision"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au type de décision
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param TypeDecision              $decision
	 * @return RedirectResponse
	 */
	public function update(Request $request, TypeDecision $decision): RedirectResponse
	{
		$request->validate([
			"libelle" => "required|max:191|unique:types_decisions,libelle,{$decision->id}",
		]);

		$decision->update($request->only(["libelle"]));

		return redirect(route("web.administrations.types.decisions.index"));
	}

	/**
	 * DELETE - Supprime le type de décision
	 *
	 * @param TypeDecision $decision
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(TypeDecision $decision): RedirectResponse
	{
		if ($decision->decisions->isNotEmpty()) {
			return back()->withErrors("Impossible de supprimer un type associé à des décisions");
		}

		$decision->delete();

		return redirect(route("web.administrations.types.decisions.index"));
	}
}
