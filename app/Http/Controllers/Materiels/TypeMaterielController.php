<?php

namespace App\Http\Controllers\Materiels;

use App\Http\Controllers\Controller;
use App\Models\DomaineMateriel;
use App\Models\TypeMateriel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TypeMaterielController extends Controller
{
	/**
	 * GET - Affiche la liste des types matériel
	 *
	 * @return View
	 */
	public function index(): View
	{
		$types = TypeMateriel::with('domaine')->orderBy("libelle")->get();

		return view("web.materiels.types.index", compact("types"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un type matériel
	 *
	 * @return View
	 */
	public function create(): View
	{
		$domaines = DomaineMateriel::orderBy("libelle")->get();

		return view("web.materiels.types.create", compact("domaines"));
	}

	/**
	 * POST - Ajoute un nouveau type matériel
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			"libelle" => "required|max:191|unique:types_materiels",
			"domaine" => "required|exists:domaines_materiels,id",
		]);

		TypeMateriel::create([
			"libelle"    => $request->input("libelle"),
			"domaine_id" => $request->input("domaine"),
		]);

		return redirect(route("web.materiels.types.index"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param TypeMateriel $type
	 * @return void
	 */
	public function show(TypeMateriel $type)
	{
		//
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un type matériel
	 *
	 * @param TypeMateriel $type
	 * @return View
	 */
	public function edit(TypeMateriel $type): View
	{
		$domaines = DomaineMateriel::orderBy("libelle")->get();

		return view("web.materiels.types.edit", compact("type", "domaines"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au type matériel
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param TypeMateriel              $type
	 * @return RedirectResponse
	 */
	public function update(Request $request, TypeMateriel $type): RedirectResponse
	{
		$request->validate([
			"libelle" => "required|max:191|unique:types_materiels,libelle,{$type->id}",
			"domaine" => "required|exists:domaines_materiels,id",
		]);

		$type->update([
			"libelle"    => $request->input("libelle"),
			"domaine_id" => $request->input("domaine"),
		]);

		return redirect(route("web.materiels.types.index"));
	}

	/**
	 * DELETE - Supprime le type matériel
	 *
	 * @param TypeMateriel $type
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(TypeMateriel $type): RedirectResponse
	{
		$type->delete();

		return redirect(route("web.materiels.types.index"));
	}
}
