<?php

namespace App\Http\Controllers\Materiels;

use App\Http\Controllers\Controller;
use App\Models\DomaineMateriel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DomaineMaterielController extends Controller
{
	/**
	 * GET - Affiche la liste des domaines matériel
	 *
	 * @return View
	 */
	public function index(): View
	{
		$domaines = DomaineMateriel::orderBy("nom", "ASC")->get();

		return view("web.materiels.domaines.index", compact("domaines"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un domaine matériel
	 *
	 * @return View
	 */
	public function create(): View
	{
		return view("web.materiels.domaines.create");
	}

	/**
	 * POST - Ajoute un nouveau domaine matériel
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			"nom" => "required|max:191|unique:domaines_materiel",
		]);

		DomaineMateriel::create($request->only(["nom"]));

		return redirect(route("web.materiels.domaines.index"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param DomaineMateriel $domaineMateriel
	 * @return void
	 */
	public function show(DomaineMateriel $domaineMateriel)
	{
		//
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un domaine matériel
	 *
	 * @param DomaineMateriel $domaine
	 * @return View
	 */
	public function edit(DomaineMateriel $domaine): View
	{
		return view("web.materiels.domaines.edit", compact("domaine"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au domaine matériel
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param DomaineMateriel           $domaine
	 * @return RedirectResponse
	 */
	public function update(Request $request, DomaineMateriel $domaine): RedirectResponse
	{
		$request->validate([
			"nom" => "required|max:191|unique:domaines_materiel,nom,{$domaine->id}",
		]);

		$domaine->update($request->only(["nom"]));

		return redirect(route("web.materiels.domaines.index"));
	}

	/**
	 * DELETE - Supprime le domaine matériel
	 *
	 * @param DomaineMateriel $domaine
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(DomaineMateriel $domaine): RedirectResponse
	{
		if ($domaine->types->isNotEmpty()) {
			return back()->withErrors("Impossible de supprimer un domaine associé à des types de matériel");
		}

		$domaine->delete();

		return redirect(route("web.materiels.domaines.index"));
	}
}