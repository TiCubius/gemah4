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
		$regions = Region::all();

		return view("web.administrations.regions.index", compact("regions"));
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
	 * GET - Affiche le formulaire d'édition d'une région
	 *
	 * @param Region $region
	 * @return View
	 */
	public function edit(Region $region): View
	{
		return view("web.administrations.regions.edit", compact("region"));
	}

	/**
	 * PUT - Enregistre les modifications apportés à la région
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Region                    $region
	 * @return RedirectResponse
	 */
	public function update(Request $request, Region $region): RedirectResponse
	{
		$request->validate([
			"nom" => "required|max:191|unique:regions,nom,{$region->id}",
		]);

		$region->update($request->only(["nom"]));

		return redirect(route("web.administrations.regions.index"));
	}

	/**
	 * DELETE - Supprime la région, sauf si elle est encore lié à au moins une Académie
	 *
	 * @param Region $region
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Region $region): RedirectResponse
	{
		if (!($region->academies->isNotEmpty())) {
			$region->delete();

			return redirect(route("web.administrations.regions.index"));
		}

		return redirect(route("web.administrations.regions.index"))->withErrors("Cette région est lié à au moins une académie");
	}
}
