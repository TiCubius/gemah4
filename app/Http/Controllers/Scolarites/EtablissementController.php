<?php

namespace App\Http\Controllers\Scolarites;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\Enseignant;
use App\Models\Etablissement;
use App\Models\TypeEtablissement;
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
		$academies = Academie::with("departements")->get();
		$types = TypeEtablissement::all();

		$latestCreated = Etablissement::latestCreated()->take(5)->get();
		$latestUpdated = Etablissement::latestUpdated()->take(5)->get();

		if ($request->exists(["departement_id", "type_etablissement_id", "nom", "ville", "telephone"])) {
			$etablissements = Etablissement::search($request->input("departement_id"), $request->input("type_etablissement_id"), $request->input("nom"), $request->input("ville"), $request->input("telephone"))->get();
		}

		return view("web.scolarites.etablissements.index", compact("academies", "eleve", "etablissements", "latestCreated", "latestUpdated", "types"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un établissement
	 *
	 * @return View
	 */
	public function create(): View
	{
		$academies = Academie::with("departements")->get();
		$enseignants = Enseignant::all();
		$types = TypeEtablissement::all();

		return view("web.scolarites.etablissements.create", compact("academies", "enseignants", "types"));
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
			"id"                    => "required|max:191|unique:etablissements",
			"nom"                   => "required|max:191",
			"type_etablissement_id" => "required|exists:types_etablissements,id",
			"degre"                 => "required|max:191",
			"regime"                => "required|max:191",
			"ville"                 => "required|max:191",
			"code_postal"           => "required",
			"adresse"               => "required|max:191",
			"telephone"             => "required",
			"enseignant_id"         => "nullable|exists:enseignants,id",
			"departement_id"        => "required|exists:departements,id",
		]);

		Etablissement::create($request->only([
			"departement_id",
			"enseignant_id",
			"type_etablissement_id",

			"id",
			"nom",
			"degre",
			"regime",
			"ville",
			"code_postal",
			"adresse",
			"telephone",
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
		$academies = Academie::with("departements")->get();
		$enseignants = Enseignant::all();
		$types = TypeEtablissement::all();

		return view("web.scolarites.etablissements.edit", compact("academies", "enseignants", "etablissement", "types"));
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
			"id"                    => "required|max:191|unique:etablissements,id,{$etablissement->id}",
			"nom"                   => "required|max:191",
			"type_etablissement_id" => "required|exists:types_etablissements,id",
			"degre"                 => "required|max:191",
			"regime"                => "required|max:191",
			"ville"                 => "required|max:191",
			"code_postal"           => "required",
			"adresse"               => "required|max:191",
			"telephone"             => "required",
			"enseignant_id"         => "nullable|exists:enseignants,id",
			"departement_id"        => "required|exists:departements,id",
		]);

		$etablissement->update($request->only([
			"id",
			"nom",
			"type_etablissement_id",
			"degre",
			"regime",
			"ville",
			"code_postal",
			"adresse",
			"telephone",
			"enseignant_id",
			"departement_id",
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
