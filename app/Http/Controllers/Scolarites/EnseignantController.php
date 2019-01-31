<?php

namespace App\Http\Controllers\Scolarites;

use App\Http\Controllers\Controller;
use App\Models\Academie;
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
		$academies = Academie::with("departements")->get();
		$latestCreated = Enseignant::latestCreated()->take(5)->get();
		$latestUpdated = Enseignant::latestUpdated()->take(5)->get();

		if ($request->exists(["nom", "prenom", "email", "telephone", "departement_id"])) {
			$enseignants = Enseignant::search($request->input("nom"), $request->input("prenom"), $request->input("email"), $request->input("telephone"), $request->input("departement_id"))->get();
		}

		return view("web.scolarites.enseignants.index", compact('academies', 'enseignants', 'latestCreated', 'latestUpdated'));
	}

	/**
	 * GET - Affiche le formulaire de création d'un enseignant
	 *
	 * @return View
	 */
	public function create(): View
	{
		$academies = Academie::with("departements")->get();

		return view("web.scolarites.enseignants.create", compact("academies"));
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
			"civilite"       => "required",
			"nom"            => "required|max:191",
			"prenom"         => "required|max:191",
			"email"          => "required|email|max:191|unique:enseignants,email",
			"telephone"      => "nullable|max:191",
			"departement_id" => "required",
		]);

		Enseignant::create($request->only([
			"civilite",
			"nom",
			"prenom",
			"email",
			"telephone",
			"departement_id",
		]));

		return redirect(route("web.scolarites.enseignants.index"));
	}

    /**
     * GET - Affiche les données d'un enseignant
     *
     * @param Enseignant $enseignant
     * @return View
     */
    public function show(Enseignant $enseignant): View
    {
        return view("web.scolarites.enseignants.show", compact("enseignant"));
    }

	/**
	 * GET - Affiche le formulaire d'édition d'un enseignant
	 *
	 * @param Enseignant $enseignant
	 * @return View
	 */
	public function edit(Enseignant $enseignant): View
	{
		$academies = Academie::with("departements")->get();

		return view("web.scolarites.enseignants.edit", compact("enseignant", "academies"));
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
			"civilite"       => "required",
			"nom"            => "required|max:191",
			"prenom"         => "required|max:191",
			"email"          => "required|email|max:191|unique:enseignants,email,{$enseignant->id}",
			"telephone"      => "nullable|max:191",
			"departement_id" => "required",
		]);

		$enseignant->update($request->only([
			"civilite",
			"nom",
			"prenom",
			"email",
			"telephone",
			"departement_id",
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
		// On enlève le liens avec toutes les décisions
		foreach ($enseignant->decisions as $decision) {
			$decision->update(["enseignant_id" => null]);
		}

		$enseignant->delete();

		return redirect(route("web.scolarites.enseignants.index"));
	}
}
