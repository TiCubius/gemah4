<?php

namespace App\Http\Controllers\Administrations;

use App\Http\Controllers\Controller;
use App\Region;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegionsController extends Controller
{
	/**
	 * GET - Affiche la liste des régions
	 *
	 * @return View
	 */
	public function index(): View
	{
		$Regions = \App\Models\Region::all();

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
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$request->validate([
			"nom" => "required|max:191|unique:regions",
		]);

		\App\Models\Region::create([
			"nom" => $request->input("nom"),
		]);

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
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Region $region
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Region $region)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Region              $region
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Region $region)
	{
		//
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
