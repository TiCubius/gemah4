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
	 * GET - Affiche la liste des type_eleves
	 *
	 * @return View
	 */
	public function index(): View
	{

		$typeEleves = TypeEleve::orderBy("libelle")->get();

		return view("web.administrations.eleves.types.index", compact("typeEleves"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un type_eleve
	 *
	 * @return View
	 */
	public function create(): View
	{
		return view("web.administrations.eleves.types.create");
	}

	/**
	 * POST - Ajoute un nouveau type_eleve
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$request->validate([
			"libelle" => "required|max:191|unique:types_eleves,libelle",
		]);

		TypeEleve::create($request->only(["libelle"]));

		return redirect(route("web.administrations.eleves.types.index"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param TypeEleve $type_eleve
	 * @return void
	 */
	public function show(TypeEleve $type_eleve)
	{
		//
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un type_eleve
	 *
	 * @param TypeEleve $type
	 * @return View
	 */
	public function edit(TypeEleve $type): View
	{
		return view("web.administrations.eleves.types.edit", compact("type"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au type_eleve
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param TypeEleve                 $type
	 * @return RedirectResponse
	 */
	public function update(Request $request, TypeEleve $type): RedirectResponse
	{
		$request->validate([
			"libelle" => "required|max:191|unique:types_eleves,libelle,{$type->id}",
		]);

		$type->update($request->only(["libelle"]));

		return redirect(route("web.administrations.eleves.types.index"));
	}

	/**
	 * DELETE - Supprime le type_eleve
	 *
	 * @param TypeEleve $type_eleve
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(TypeEleve $type): RedirectResponse
	{
		if ($type->eleves->isNotEmpty()) {
			return back()->withErrors("Le type que vous essayez de supprimer est associer a un ou plusieurs élèves");
		} else {
			$type->delete();
			return redirect(route("web.administrations.eleves.types.index"));
		}
	}
}
