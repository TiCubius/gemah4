<?php

namespace App\Http\Controllers\Administrations;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\Region;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AcademieController extends Controller
{
	/**
	 * GET - Affiche la liste des académies
	 *
	 * @return View
	 */
	public function index(): View
	{
		$academies = Academie::with("region")->orderBy("nom", "ASC")->get();

		return view("web.administrations.academies.index", compact("academies"));
	}

	/**
	 * GET - Affiche le formulaire de création d'une académie
	 *
	 * @return View
	 */
	public function create(): View
	{
		$regions = Region::orderBy("nom", "ASC")->get();

		return view("web.administrations.academies.create", compact("regions"));
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
			"region" => "required|exists:regions,id",
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
	 * @param Academie $academy
	 * @return void
	 */
	public function show(Academie $academy)
	{
		//
	}

	/**
	 * GET - Affiche le formulaire d'édition d'une académie
	 *
	 * @param Academie $academy
	 * @return View
	 */
	public function edit(Academie $academy): View
	{
		$regions = Region::orderBy("nom", "ASC")->get();

		return view("web.administrations.academies.edit", compact("academy", "regions"));
	}

	/**
	 * PUT - Enregistre les modifications apportés à l'académie
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Academie                  $academy
	 * @return RedirectResponse
	 */
	public function update(Request $request, Academie $academy): RedirectResponse
	{
		$request->validate([
			"nom"    => "required|max:191|unique:academies,nom,{$academy->id}",
			"region" => "required|exists:regions,id",
		]);

		$academy->update([
			"nom"       => $request->input("nom"),
			"region_id" => $request->input("region"),
		]);

		return redirect(route("web.administrations.academies.index"));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Academie $academy
	 * @return void
	 */
	public function destroy(Academie $academy)
	{
		//
	}
}