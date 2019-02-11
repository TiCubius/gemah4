<?php

namespace App\Http\Controllers\Responsables;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\Responsable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResponsableController extends Controller
{
	/**
	 * GET - Affiche la liste des responsables
	 *
	 * @param Request $request
	 * @return View
	 */
	public function index(Request $request): View
	{
		$academies = Academie::with("departements")->get();

		$latestCreated = Responsable::latestCreated()->take(5)->get();
		$latestUpdated = Responsable::latestUpdated()->take(5)->get();

		if ($request->hasAny(["nom", "prenom", "email", "telephone", "departement_id"])) {
			$responsables = Responsable::search($request->input("nom"), $request->input("prenom"), $request->input("email"), $request->input("telephone"), $request->input("departement_id"))->get();
		}

		return view("web.responsables.index", compact('academies', 'latestCreated', 'latestUpdated', 'responsables'));
	}

	/**
	 * GET - Affiche le formulaire de création d'un responsable
	 *
	 * @return View
	 */
	public function create(): View
	{
		$academies = Academie::with("departements")->get();

		return view("web.responsables.create", compact("academies"));
	}

	/**
	 * POST - Ajoute un nouveau responsable
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
			"email"          => "nullable|email|max:191",
			"telephone"      => "nullable",
			"code_postal"    => "nullable|max:191",
			"ville"          => "nullable|max:191",
			"adresse"        => "nullable|max:191",
			"departement_id" => "required|exists:departements,id",
		]);

		Responsable::create($request->all());

		return redirect(route("web.responsables.index"));
	}

	/**
	 * GET - Affiche les données d'un responsable
	 *
	 * @param Responsable $responsable
	 * @return View
	 */
	public function show(Responsable $responsable): View
	{
		$responsable->load("eleves", "eleves.materiels", "eleves.materiels.type");
		return view("web.responsables.show", compact("responsable"));
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un responsable
	 *
	 * @param Responsable $responsable
	 * @return View
	 */
	public function edit(Responsable $responsable): View
	{
		$academies = Academie::with("departements")->get();

		return view("web.responsables.edit", compact("responsable", "academies"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au responsable
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Responsable               $responsable
	 * @return RedirectResponse
	 */
	public function update(Request $request, Responsable $responsable): RedirectResponse
	{
		$request->validate([
			"civilite"       => "required",
			"nom"            => "required|max:191",
			"prenom"         => "required|max:191",
			"email"          => "nullable|email|max:191",
			"telephone"      => "nullable",
			"code_postal"    => "nullable|max:191",
			"ville"          => "nullable|max:191",
			"adresse"        => "nullable|max:191",
			"departement_id" => "required|exists:departements,id",
		]);

		$responsable->update($request->all());

		return redirect(route("web.responsables.index"));
	}

	/**
	 * DELETE - Supprime le responsable
	 *
	 * @param Responsable $responsable
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Responsable $responsable): RedirectResponse
	{
		if ($responsable->eleves->isNotEmpty()) {
			return back()->withErrors("Impossible de supprimer un responsable associé à des élèves");
		}

		$responsable->delete();

		return redirect(route("web.responsables.index"));
	}
}
