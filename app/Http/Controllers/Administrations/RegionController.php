<?php

namespace App\Http\Controllers\Administrations;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegionController extends Controller
{
	/**
	 * GET - Affiche la liste des régions
	 *
	 * @return View
	 */
	public function index(): View
	{
		$Regions = Region::all();

		return view("web.administrations.regions.index", compact("Regions"));
	}

	/**
	 * GET - Affiche le formulaire de création d'une région
	 *
	 * @return View
	 */
	public function create(): View
	{
		return view("web.administrations.regions.create");
	}

	/**
	 * POST - Enregistre la région
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			"nom" => "required|max:191|unique:regions",
		]);

		Region::create($request->only(["nom"]));

		return redirect(route("web.administrations.regions.index"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Region $region
	 * @return \Illuminate\Http\Response
	 */
	public function show(Region $region)
	{
		//
	}

	/**
	 * GET - Affiche le formulaire d'édition d'une région
	 *
	 * @param int $id
	 * @return View
	 */
	public function edit(int $id): View
	{
		$Region = Region::findOrFail($id);

		return view("web.administrations.regions.edit", compact("Region"));
	}

	/**
	 * PUT - Enregistre les modifications apportés à la région
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param int                       $id
	 * @return RedirectResponse
	 */
	public function update(Request $request, int $id): RedirectResponse
	{
		$request->validate([
			"nom" => "required|max:191|unique:regions,nom,{$id}",
		]);

		$Region = Region::findOrFail($id);
		$Region->update($request->only(["nom"]));

		return redirect(route("web.administrations.regions.index"));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Region $region
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Region $region)
	{
		//
	}
}
