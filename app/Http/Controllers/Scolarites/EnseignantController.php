<?php

namespace App\Http\Controllers\Scolarites;

use App\Http\Controllers\Controller;
use App\Models\Enseignant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EnseignantController extends Controller
{
	/**
	 * GET - Affiche la liste des enseignants
	 *
	 * @param Request $request
	 * @return View
	 */
	public function index(Request $request): View
	{
		$latestCreatedEnseignants = Enseignant::latestCreated()->take(10)->get();
		$latestUpdatedEnseignants = Enseignant::latestUpdated()->take(10)->get();

		if ($request->exists(["nom", "prenom", "email", "telephone"])) {
			$searchedEnseignants = Enseignant::search($request->input("nom"), $request->input("prenom"), $request->input("email"), $request->input("telephone"))->get();
		}

		return view("web.scolarites.enseignants.index", compact('latestCreatedEnseignants', 'latestUpdatedEnseignants', 'searchedEnseignants'));
	}

	/**
	 * GET - Affiche le formulaire de création d'un enseignant
	 *
	 * @return View
	 */
	public function create(): View
	{
		return view("web.scolarites.enseignants.create");
	}

	/**
	 * POST - Ajoute un nouveau enseignant
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			"civilite"  => "required",
			"nom"       => "required|max:191",
			"prenom"    => "required|max:191",
			"email"     => "required|email|max:191|unique:enseignants,email",
			"telephone" => "nullable|max:191",
		]);

		Enseignant::create($request->only([
			"civilite",
			"nom",
			"prenom",
			"email",
			"telephone",
		]));

		return redirect(route("web.scolarites.enseignants.index"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Enseignant $enseignant
	 * @return void
	 */
	public function show(Enseignant $enseignant)
	{
		//
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un enseignant
	 *
	 * @param Enseignant $enseignant
	 * @return View
	 */
	public function edit(Enseignant $enseignant): View
	{
		return view("web.scolarites.enseignants.edit", compact("enseignant"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au enseignant
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Enseignant                $enseignant
	 * @return RedirectResponse
	 */
	public function update(Request $request, Enseignant $enseignant): RedirectResponse
	{
		$request->validate([
			"civilite"  => "required",
			"nom"       => "required|max:191",
			"prenom"    => "required|max:191",
			"email"     => "required|email|max:191|unique:enseignants,email,{$enseignant->id}",
			"telephone" => "nullable|max:191",
		]);

		$enseignant->update($request->only([
			"civilite",
			"nom",
			"prenom",
			"email",
			"telephone",
		]));

		return redirect(route("web.scolarites.enseignants.index"));
	}

	/**
	 * DELETE - Supprime le enseignant
	 *
	 * @param Enseignant $enseignant
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Enseignant $enseignant): RedirectResponse
	{
		$enseignant->delete();

		return redirect(route("web.scolarites.enseignants.index"));
	}
}
