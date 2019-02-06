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
		$academies = Academie::with("region")->orderBy("nom")->get();

		return view("web.administrations.academies.index", compact("academies"));
	}

	/**
	 * GET - Affiche le formulaire de création d'une académie
	 *
	 * @return View
	 */
	public function create(): View
	{
		$regions = Region::orderBy("nom")->get();

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
	 * GET - Affiche les données d'une académie
	 *
	 * @param Academie $academie
	 * @return View
	 */
	public function show(Academie $academie): View
	{
		return view("web.administrations.academies.show", compact("academie"));
	}

	/**
	 * GET - Affiche le formulaire d'édition d'une académie
	 *
	 * @param Academie $academie
	 * @return View
	 */
	public function edit(Academie $academie): View
	{
		$regions = Region::orderBy("nom")->get();

		return view("web.administrations.academies.edit", compact("academie", "regions"));
	}

	/**
	 * PUT - Enregistre les modifications apportés à l'académie
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Academie                  $academie
	 * @return RedirectResponse
	 */
	public function update(Request $request, Academie $academie): RedirectResponse
	{
		$request->validate([
			"nom"    => "required|max:191|unique:academies,nom,{$academie->id}",
			"region" => "required|exists:regions,id",
		]);

		$academie->update([
			"nom"       => $request->input("nom"),
			"region_id" => $request->input("region"),
		]);

		return redirect(route("web.administrations.academies.index"));
	}

	/**
	 * DELETE - Supprime l'académie
	 *
	 * @param Academie $academie
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Academie $academie): RedirectResponse
	{
		if ($academie->departements->isNotEmpty()) {
			return back()->withErrors("Impossible de supprimer une académie associé à des départements");
		}

		$academie->delete();

		return redirect(route("web.administrations.academies.index"));
	}
}
