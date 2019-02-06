<?php

namespace App\Http\Controllers\Scolarites;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\Eleve;
use App\Models\Responsable;
use App\Models\TypeDecision;
use Carbon\Carbon;
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
		$academies = Academie::with("departements")->get();
		$typesEleve = TypeDecision::all();

		$latestCreated = Eleve::latestCreated()->take(5)->get();
		$latestUpdated = Eleve::latestUpdated()->take(5)->get();

		if ($request->exists(["departement_id", "type_eleve_id", "nom", "prenom", "date_naissance", "code_ine"])) {
			$eleves = Eleve::search($request->input("departement_id"), $request->input("type_eleve_id"), $request->input("nom"), $request->input("prenom"), $request->input("date_naissance"), $request->input("code_ine"), null)->get();
		}

		return view("web.scolarites.eleves.index", compact("academies", "eleves", "latestCreated", "latestUpdated", "typesEleve"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un eleve
	 *
	 * @return View
	 */
	public function create(): View
	{
		$academies = Academie::with("departements")->get();
		$types = TypeDecision::all();

		return view("web.scolarites.eleves.create", compact("academies", "types"));
	}

	/**
	 * POST - Ajoute un nouvel élève
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$dateAfter = Carbon::now()->subYear(50);
		$dateBefore = Carbon::now()->addYear(50);

		$request->validate([
			"nom"            => "required|max:255",
			"prenom"         => "required|max:255",
			"date_naissance" => "required|date|before:{$dateBefore},after:{$dateAfter}",
			"classe"         => "nullable|max:255",
			"departement_id" => "required|exists:departements,id",
			"code_ine"       => "nullable|max:11|unique:eleves",
		]);

		Eleve::create($request->all());

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
		$eleve->load("etablissement.type", "materiels.type", "responsables");

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
		$types = TypeDecision::all();
		$eleve->load("responsables.eleves");

		return view("web.scolarites.eleves.edit", compact("academies", "eleve", "types"));
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
		$dateAfter = Carbon::now()->subYear(50);
		$dateBefore = Carbon::now()->addYear(50);

		$request->validate([
			"nom"            => "required|max:255",
			"prenom"         => "required|max:255",
			"date_naissance" => "required|date|before:{$dateBefore},after:{$dateAfter}",
			"classe"         => "nullable|max:255",
			"departement_id" => "required|exists:departements,id",
			"code_ine"       => "nullable|max:11|unique:eleves,code_ine,{$eleve->id}",
		]);

		$eleve->update($request->all());

		return redirect(route("web.scolarites.eleves.show", [$eleve]));
	}

	/**
	 * DELETE - Supprime l'élève
	 *
	 * @param Eleve   $eleve
	 * @param Request $request
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Eleve $eleve, Request $request): RedirectResponse
	{
		$eleve->delete();
		if ($request->has("delete-responsables")) {
			foreach ($request->input("delete-responsables") as $responsbale) {
				Responsable::find("$responsbale")->delete();
			}
		}

		return redirect(route("web.scolarites.eleves.index"));
	}
}
