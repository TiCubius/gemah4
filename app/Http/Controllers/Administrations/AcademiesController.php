<?php

namespace App\Http\Controllers\Administrations;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\Region;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AcademiesController extends Controller
{
	/**
	 * GET - Affiche la liste des académies
	 *
	 * @return View
	 */
	public function index(): View
	{
		$Academies = \App\Models\Academie::with("region")->orderBy("nom", "ASC")->get();

		return view("web.administrations.academies.index", compact("Academies"));
	}

	/**
	 * GET - Affiche le formulaire de création d'une académie
	 *
	 * @return View
	 */
	public function create(): View
	{
		$Regions = \App\Models\Region::orderBy("nom", "ASC")->get();

		return view("web.administrations.academies.create", compact("Regions"));
	}

	/**
	 * POST - Enregistre une académie
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			"nom"    => "required|max:191|unique:academies",
			"region" => "required",
		]);

		Academie::create([
			"nom"       => $request->input("nom"),
			"region_id" => $request->input("region"),
		]);

		return redirect(route("web.administrations.academies.index"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Academie $academie
	 * @return \Illuminate\Http\Response
	 */
	public function show(Academie $academie)
	{
		//
	}

	/**
	 * GET - Affiche le formulaire d'édition d'une académie
	 *
	 * @param int $id
	 * @return View
	 */
	public function edit(int $id): View
	{
		$Academie = Academie::findOrFail($id);
		$Regions = Region::orderBy("nom", "ASC")->get();

		return view("web.administrations.academies.edit", compact("Academie", "Regions"));
	}

	/**
	 * PUT - Enregistre les modifications apportés à l'académie
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param int                       $id
	 * @return RedirectResponse
	 */
	public function update(Request $request, int $id): RedirectResponse
	{
		$request->validate([
			"nom"    => "required|max:191|unique:academies,nom,{$id}",
			"region" => "required",
		]);

		$Academie = Academie::findOrFail($id);
		$Academie->update([
			"nom"       => $request->input("nom"),
			"region_id" => $request->input("region"),
		]);

		return redirect(route("web.administrations.academies.index"));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Academie $academie
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Academie $academie)
	{
		//
	}
}
