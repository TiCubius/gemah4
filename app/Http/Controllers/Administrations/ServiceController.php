<?php

namespace App\Http\Controllers\Administrations;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\Departement;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
	/**
	 * GET - Affiche la liste des services
	 *
	 * @return View
	 */
	public function index(): View
	{
		$services = Service::orderBy("nom")->get();

		return view("web.administrations.services.index", compact("services"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un service
	 *
	 * @return View
	 */
	public function create(): View
	{
		$academies = Academie::with("departements")->get();

		return view("web.administrations.services.create", compact("academies"));
	}

	/**
	 * POST - Ajoute un nouveau service
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$request->validate([
			"nom"            => "required|max:191|unique_with:services,departement_id",
			"description"    => "required|max:191",
			"departement_id" => "required|max:191|exists:departements,id",
		]);

		Service::create($request->only(["nom", "description", "departement_id"]));

		return redirect(route("web.administrations.services.index"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Service $service
	 * @return void
	 */
	public function show(Service $service)
	{
		//
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un service
	 *
	 * @param Service $service
	 * @return View
	 */
	public function edit(Service $service): View
	{
		$academies = Academie::with("departements")->get();

		return view("web.administrations.services.edit", compact("service", "academies"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au service
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Service                   $service
	 * @return RedirectResponse
	 */
	public function update(Request $request, Service $service): RedirectResponse
	{
		$request->validate([
			"nom"            => "required|max:191|unique_with:departement_id,{$service->id}",
			"description"    => "required|max:191",
			"departement_id" => "required|max:191|exists:departement,id",
		]);

		$service->update($request->only(["nom", "description", "departement_id"]));

		return redirect(route("web.administrations.services.index"));
	}

	/**
	 * DELETE - Supprime le service
	 *
	 * @param Service $service
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Service $service): RedirectResponse
	{
		if ($service->utilisateurs->isNotEmpty()) {
			return back()->withErrors("Impossible de supprimer un service associé à des utilisateurs");
		}

		$service->delete();

		return redirect(route("web.administrations.services.index"));
	}
}
