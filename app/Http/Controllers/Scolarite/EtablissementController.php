<?php

namespace App\Http\Controllers\Scolarite;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\Enseignant;
use App\Models\Etablissement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EtablissementController extends Controller
{
	/**
	 * GET - Affiche la liste des etablissements
	 *
	 * @param Request $request
	 * @return View
	 */
	public function index(Request $request): View
	{
		$latestCreatedEtablissements = Etablissement::latestCreated()->take(10)->get();
		$latestUpdatedEtablissements = Etablissement::latestUpdated()->take(10)->get();

		if ($request->exists(["nom", "ville", "telephone"])) {
			$searchedEtablissements = Etablissement::search($request->input("nom"), $request->input("ville"), $request->input("telephone"))
				->get();
		}

		return view("web.scolarites.etablissements.index", compact('latestCreatedEtablissements', 'latestUpdatedEtablissements', 'searchedEtablissements'));
	}

	/**
	 * GET - Affiche le formulaire de création d'un établissement
	 *
	 * @return View
	 */
	public function create(): View
	{
		$academies = Academie::all();
		$enseignants = Enseignant::all();

		return view("web.scolarites.etablissements.create", compact("enseignants", "academies"));
	}

	/**
	 * POST - Ajoute un nouveau établissement
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			"id"            => "required|max:191|unique:etablissements",
			"nom"           => "required|max:191",
			"type"          => "required|max:191",
			"degre"         => "required|max:191",
			"regime"        => "required|max:191",
			"ville"         => "required|max:191",
			"code_postal"   => "required|numeric|digits:5",
			"adresse"       => "required|max:191",
			"telephone"     => "required|numeric",
			"enseignant_id" => "required|exists:enseignants,id",
			"academie_id"   => "required|exists:academies,id",
		]);

		Etablissement::create($request->only([
			"id",
			"nom",
			"type",
			"degre",
			"regime",
			"ville",
			"code_postal",
			"adresse",
			"telephone",
			"enseignant_id",
			"academie_id",
		]));

		return redirect(route("web.scolarites.etablissements.index"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Etablissement $etablissement
	 * @return void
	 */
	public function show(Etablissement $etablissement)
	{
		//
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un établissement
	 *
	 * @param Etablissement $etablissement
	 * @return View
	 */
	public function edit(Etablissement $etablissement): View
	{
		$academies = Academie::all();
		$enseignants = Enseignant::all();

		return view("web.scolarites.etablissements.edit", compact("etablissement", "academies", "enseignants"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au établissement
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Etablissement             $etablissement
	 * @return RedirectResponse
	 */
	public function update(Request $request, Etablissement $etablissement): RedirectResponse
	{
		$request->validate([
			"id"            => "required|max:191|unique:etablissements,id,{$etablissement->id}",
			"nom"           => "required|max:191",
			"type"          => "required|max:191",
			"degre"         => "required|max:191",
			"regime"        => "required|max:191",
			"ville"         => "required|max:191",
			"code_postal"   => "required|numeric|digits:5",
			"adresse"       => "required|max:191",
			"telephone"     => "required|numeric",
			"enseignant_id" => "required|exists:enseignants,id",
			"academie_id"   => "required|exists:academies,id",
		]);

		$etablissement->update($request->only([
			"id",
			"nom",
			"type",
			"degre",
			"regime",
			"ville",
			"code_postal",
			"adresse",
			"telephone",
			"enseignant_id",
			"academie_id",
		]));

		return redirect(route("web.scolarites.etablissements.index"));
	}

	/**
	 * DELETE - Supprime le établissement
	 *
	 * @param Etablissement $etablissement
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Etablissement $etablissement): RedirectResponse
	{
		$etablissement->delete();

		return redirect(route("web.scolarites.etablissements.index"));
	}
}
