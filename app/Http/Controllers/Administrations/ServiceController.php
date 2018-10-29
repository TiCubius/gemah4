<?php

namespace App\Http\Controllers\Administrations;

use App\Http\Controllers\Controller;
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
		return view("web.administrations.services.create");
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
			"nom"         => "required|max:191|unique:services",
			"description" => "required|max:191",
		]);

		Service::create($request->only(["nom", "description"]));

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
		return view("web.administrations.services.edit", compact("service"));
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
			"nom" => "required|max:191|unique:services,nom,{$service->id}",
		]);

		$service->update($request->only(["nom", "description"]));

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
