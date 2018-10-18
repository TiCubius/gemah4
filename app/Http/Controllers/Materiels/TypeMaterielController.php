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
		$TypesMateriel = TypeMateriel::with('domaine')->orderBy("nom", "ASC")->get();

		return view("web.materiels.types.index", compact("TypesMateriel"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un type matériel
	 *
	 * @return View
	 */
	public function create(): View
	{
		$DomainesMateriel = DomaineMateriel::orderBy("nom", "ASC")->get();

		return view("web.materiels.types.create", compact("DomainesMateriel"));
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
			"nom"     => "required|max:191|unique:types_materiel",
			"domaine" => "required|exists:domaines_materiel,id",
		]);

		TypeMateriel::create([
			"nom"        => $request->input("nom"),
			"domaine_id" => $request->input("domaine"),
		]);

		return redirect(route("web.materiels.types.index"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param TypeMateriel $typeMateriel
	 * @return void
	 */
	public function show(TypeMateriel $typeMateriel)
	{
		//
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un type matériel
	 *
	 * @param int $id
	 * @return View
	 */
	public function edit(int $id): View
	{
		$TypeMateriel = TypeMateriel::findOrFail($id);
		$DomainesMateriel = DomaineMateriel::orderBy("nom", "ASC")->get();

		return view("web.materiels.types.edit", compact("TypeMateriel", "DomainesMateriel"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au type matériel
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param int                       $id
	 * @return RedirectResponse
	 */
	public function update(Request $request, int $id): RedirectResponse
	{
		$request->validate([
			"nom"     => "required|max:191|unique:types_materiel,nom,{$id}",
			"domaine" => "required|exists:domaines_materiel,id",
		]);

		$TypeMateriel = TypeMateriel::findOrFail($id);
		$TypeMateriel->update([
			"nom"        => $request->input("nom"),
			"domaine_id" => $request->input("domaine"),
		]);

		return redirect(route("web.materiels.types.index"));
	}

	/**
	 * DELETE - Supprime le type matériel
	 *
	 * @param int $id
	 * @return RedirectResponse
	 */
	public function destroy(int $id): RedirectResponse
	{
		$TypeMateriel = TypeMateriel::findOrFail($id);
		$TypeMateriel->delete();

		return redirect(route("web.materiels.types.index"));
	}
}
