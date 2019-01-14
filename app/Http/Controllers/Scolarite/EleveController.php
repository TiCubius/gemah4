<?php

namespace App\Http\Controllers\Scolarite;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\Eleve;
use App\Models\Etablissement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EleveController extends Controller
{
	/**
	 * GET - Affiche la liste des élèves
	 *
	 * @param Request $request
	 * @return View
	 */
	public function index(Request $request): View
	{
		$latestCreatedEleves = Eleve::latestCreated()->take(10)->get();
		$latestUpdatedEleves = Eleve::latestUpdated()->take(10)->get();

		if ($request->exists(["nom", "prenom", "date_naissance", "code_ine"])) {
			$searchedEleves = Eleve::search($request->input("nom"), $request->input("prenom"), $request->input("date_naissance"), $request->input("code_ine"))
				->get();
		}

		return view("web.scolarites.eleves.index", compact('latestCreatedEleves', 'latestUpdatedEleves', 'searchedEleves'));
	}

	/**
	 * GET - Affiche le formulaire de création d'un eleve
	 *
	 * @return View
	 */
	public function create(): View
	{
		$academies = Academie::with("departements")->get();
		$etablissements = Etablissement::all();

		return view("web.scolarites.eleves.create", compact("academies", "etablissements"));
	}

	/**
	 * POST - Ajoute un nouvel élève
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			"nom"              => "required|max:255",
			"prenom"           => "required|max:255",
			"date_naissance"   => "required|date",
			"classe"           => "required",
			"departement_id"   => "required",
			"etablissement_id" => "required|exists:etablissements,id",
			"code_ine"         => "nullable |max:11|unique:eleves",
		]);

		Eleve::create($request->only([
			"nom",
			"prenom",
			"date_naissance",
			"classe",
			"departement_id",
			"etablissement_id",
			"code_ine",
		]));

		return redirect(route("web.scolarites.eleves.index"));
	}

	/**
	 * GET - Affiche les informations sur l'élève
	 *
	 * @param Eleve $eleve
	 * @return View
	 */
	public function show(Eleve $eleve): View
	{
		// Eager loading : charge les relations nécessaires avant l'affichage de la vue
		$eleve->load("etablissement", "materiels.type", "responsables");

		return view("web.scolarites.eleves.show", compact("eleve"));
	}


	/**
	 * GET - Affiche la liste du matériel affecté à l'élève
	 *
	 * @param Eleve $eleve
	 * @return View
	 */
	public function materiels(Eleve $eleve): View
	{
		$materiels = $eleve->materiels();

		return view("web.scolarites.eleves.materiels", compact("eleve", "materiels"));
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un élève
	 *
	 * @param Eleve $eleve
	 * @return View
	 */
	public function edit(Eleve $eleve): View
	{
		$academies = Academie::with("departements")->get();
		$etablissements = Etablissement::all();

		return view("web.scolarites.eleves.edit", compact("academies", "etablissements", "eleve"));
	}

	/**
	 * PUT - Enregistre les modifications apportés a l'élève
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Eleve                     $eleve
	 * @return RedirectResponse
	 */
	public function update(Request $request, Eleve $eleve): RedirectResponse
	{
		$request->validate([
			"nom"              => "required|max:255",
			"prenom"           => "required|max:255",
			"date_naissance"   => "required|date",
			"classe"           => "required",
			"departement_id"   => "required",
			"etablissement_id" => "required|exists:etablissements,id",
			"code_ine"         => "nullable|max:11|unique:eleves,id,{$eleve->id}",
		]);

		$eleve->update($request->only([
			"nom",
			"prenom",
			"date_naissance",
			"classe",
			"departement_id",
			"etablissement_id",
			"code_ine",
		]));

		return redirect(route("web.scolarites.eleves.index"));
	}

	/**
	 * DELETE - Supprime l'élève
	 *
	 * @param Eleve $eleve
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Eleve $eleve): RedirectResponse
	{
		$eleve->delete();

		return redirect(route("web.scolarites.eleves.index"));
	}
}
