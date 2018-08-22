<?php

namespace App\Http\Controllers\Responsables;

use App\Http\Controllers\Controller;
use App\Models\Responsable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ResponsablesController extends Controller
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
			$searchedResponsables = Responsable::search($request->input("nom"), $request->input("prenom"),
				$request->input("email"), $request->input("telephone"))->get();
		}

		return view("web.responsables.index",
			compact('latestCreatedResponsables', 'latestUpdatedResponsables', 'searchedResponsables'));
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
			"adresse"     => "nullable|max:191"
		]);

		Responsable::create($request->only(["civilite", "nom", "prenom", "email", "telephone", "code_postal", "ville", "adresse"]));

		return redirect(route("web.responsables.index"));
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Responsable $responsable
	 * @return \Illuminate\Http\Response
	 */
	public function show(Responsable $responsable)
	{
		//
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un responsable
	 *
	 * @param int $id
	 * @return View
	 */
	public function edit(int $id): View
	{
		$Responsable = Responsable::findOrFail($id);

		return view("web.responsables.edit", compact("Responsable"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au responsable
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param int                       $id
	 * @return RedirectResponse
	 */
	public function update(Request $request, int $id): RedirectResponse
	{
		$request->validate([
			"civilite"    => "required",
			"nom"         => "required|max:191|unique_with:responsables,prenom,{$id}",
			"prenom"      => "required|max:191",
			"email"       => "nullable|email|max:191",
			"telephone"   => "nullable|max:191",
			"code_postal" => "nullable|max:191",
			"ville"       => "nullable|max:191",
			"adresse"     => "nullable|max:191"
		]);

		$Responsable = Responsable::findOrFail($id);
		$Responsable->update($request->only(["civilite", "nom", "prenom", "email", "telephone", "code_postal", "ville", "adresse"]));

		return redirect(route("web.responsables.index"));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return RedirectResponse
	 */
	public function destroy(int $id): RedirectResponse
	{
		$Responsable = Responsable::findOrFail($id);
		$Responsable->delete();

		return redirect(route("web.responsables.index"));
	}
}
