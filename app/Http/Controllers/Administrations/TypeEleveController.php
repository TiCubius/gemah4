<?php

namespace App\Http\Controllers\Administrations;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\Departement;
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

		$typeEleves = TypeEleve::orderBy("nom")->get();

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
			"nom"         => "required|max:191|unique:types_eleves,nom",
		]);

		TypeEleve::create($request->only(["nom"]));

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
	 * @param TypeEleve                   $type_eleve
	 * @return RedirectResponse
	 */
	public function update(Request $request, TypeEleve $type): RedirectResponse
	{
		$request->validate([
			"nom" => "required|max:191|unique:types_eleves,nom,{$type->id}",
		]);

		$type->update($request->only(["nom"]));

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
		$type->delete();

		return redirect(route("web.administrations.eleves.types.index"));
	}
}
