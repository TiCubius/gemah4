<?php

namespace App\Http\Controllers\Responsables;

use App\Http\Controllers\Controller;
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
		$latestCreatedResponsables = Responsable::latestCreated()->take(10)->get();
		$latestUpdatedResponsables = Responsable::latestUpdated()->take(10)->get();

		if ($request->exists(["nom", "prenom", "email", "telephone"])) {
			$searchedResponsables = Responsable::search($request->input("nom"), $request->input("prenom"), $request->input("email"), $request->input("telephone"))->get();
		}

		return view("web.responsables.index", compact('latestCreatedResponsables', 'latestUpdatedResponsables', 'searchedResponsables'));
	}

	/**
	 * GET - Affiche le formulaire de création d'un responsable
	 *
	 * @return View
	 */
	public function create(): View
	{
		return view("web.responsables.create");
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
			"civilite"    => "required",
			"nom"         => "required|max:191|unique_with:responsables,prenom",
			"prenom"      => "required|max:191",
			"email"       => "nullable|email|max:191",
			"telephone"   => "nullable|max:191",
			"code_postal" => "nullable|max:191",
			"ville"       => "nullable|max:191",
			"adresse"     => "nullable|max:191",
		]);

		Responsable::create($request->only([
			"civilite",
			"nom",
			"prenom",
			"email",
			"telephone",
			"code_postal",
			"ville",
			"adresse",
		]));

		return redirect(route("web.responsables.index"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Responsable $responsable
	 * @return void
	 */
	public function show(Responsable $responsable)
	{
		//
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un responsable
	 *
	 * @param Responsable $responsable
	 * @return View
	 */
	public function edit(Responsable $responsable): View
	{
		return view("web.responsables.edit", compact("responsable"));
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
			"civilite"    => "required",
			"nom"         => "required|max:191|unique_with:responsables,prenom,{$responsable->id}",
			"prenom"      => "required|max:191",
			"email"       => "nullable|email|max:191",
			"telephone"   => "nullable|max:191",
			"code_postal" => "nullable|max:191",
			"ville"       => "nullable|max:191",
			"adresse"     => "nullable|max:191",
		]);

		$responsable->update($request->only([
			"civilite",
			"nom",
			"prenom",
			"email",
			"telephone",
			"code_postal",
			"ville",
			"adresse",
		]));

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
		$responsable->delete();

		return redirect(route("web.responsables.index"));
	}
}