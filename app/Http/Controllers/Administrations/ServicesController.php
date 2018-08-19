<?php

namespace App\Http\Controllers\Administrations;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServicesController extends Controller
{
	/**
	 * GET - Affiche la liste des services
	 *
	 * @return View
	 */
	public function index(): View
	{
		$Services = \App\Models\Service::orderBy("nom", "ASC")->get();

		return view("web.administrations.services.index", compact("Services"));
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
	 * Store a newly created resource in storage.
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

		\App\Models\Service::create([
			"nom"         => $request->input("nom"),
			"description" => $request->input("description"),
		]);

		return redirect(route("web.administrations.services.index"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Service $service
	 * @return \Illuminate\Http\Response
	 */
	public function show(Service $service)
	{
		//
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un service
	 *
	 * @param int $id
	 * @return View
	 */
	public function edit(int $id): View
	{
		$Service = Service::findOrFail($id);

		return view("web.administrations.services.edit", compact("Service"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au service
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param int                       $id
	 * @return RedirectResponse
	 */
	public function update(Request $request, int $id): RedirectResponse
	{
		$request->validate([
			"nom" => "required|max:191|unique:services,nom,{$id}",
		]);

		$Service = Service::findOrFail($id);
		$Service->update($request->all());

		return redirect(route("web.administrations.services.index"));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Service $service
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Service $service)
	{
		//
	}
}
