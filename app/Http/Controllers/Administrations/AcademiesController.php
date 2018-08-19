<?php

namespace App\Http\Controllers\Administrations;

use App\Academie;
use App\Http\Controllers\Controller;
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
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$request->validate([
			"nom"    => "required|max:191|unique:academies",
			"region" => "required",
		]);

		\App\Models\Academie::create([
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Academie $academie
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Academie $academie)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Academie            $academie
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Academie $academie)
	{
		//
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
