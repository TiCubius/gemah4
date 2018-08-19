<?php

namespace App\Http\Controllers\Administrations;

use App\Http\Controllers\Controller;
use App\Service;
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
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Service $service
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Service $service)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Service             $service
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Service $service)
	{
		//
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
