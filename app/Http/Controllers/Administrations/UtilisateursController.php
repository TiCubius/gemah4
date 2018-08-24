<?php

namespace App\Http\Controllers\Administrations;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\Service;
use App\Models\Utilisateur;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UtilisateursController extends Controller
{
	/**
	 * GET - Affiche la liste des utilisateurs
	 *
	 * @return View
	 */
	public function index(): View
	{
		$Utilisateurs = Utilisateur::with("service")->orderBy("nom", "ASC")->get();

		return view("web.administrations.utilisateurs.index", compact("Utilisateurs"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un utilisateur
	 *
	 * @return View
	 */
	public function create(): View
	{
		$Academies = Academie::with("region")->orderBy("nom", "ASC")->get();
		$Services = Service::orderBy("nom", "ASC")->get();

		return view("web.administrations.utilisateurs.create", compact("Academies", "Services"));
	}

	/**
	 * POST - Ajoute un nouvel utilisateur
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			"nom"      => "required|max:191",
			"prenom"   => "required|max:191",
			"email"    => "required|max:191|email|unique:utilisateurs",
			"password" => "required|min:8|confirmed",
			"academie" => "required",
			"service"  => "required",
		]);

		Utilisateur::create([
			"nom"      => $request->input("nom"),
			"prenom"   => $request->input("prenom"),
			"email"    => $request->input("email"),
			"password" => Hash::make($request->input("password")),

			"academie_id" => $request->input("academie"),
			"service_id"  => $request->input("service"),
		]);

		return redirect(route("web.administrations.utilisateurs.index"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Utilisateur $utilisateur
	 * @return \Illuminate\Http\Response
	 */
	public function show(Utilisateur $utilisateur)
	{
		//
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un utilisateur
	 *
	 * @param int $id
	 * @return View
	 */
	public function edit(int $id): View
	{
		$Utilisateur = Utilisateur::findOrFail($id);
		$Academies = Academie::with("region")->orderBy("nom", "ASC")->get();
		$Services = Service::orderBy("nom", "ASC")->get();

		return view("web.administrations.utilisateurs.edit", compact("Utilisateur", "Academies", "Services"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au utilisateur
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param int                       $id
	 * @return RedirectResponse
	 */
	public function update(Request $request, int $id): RedirectResponse
	{
		$request->validate([
			"nom"      => "required|max:191",
			"prenom"   => "required|max:191",
			"email"    => "required|max:191|email|unique:utilisateurs,email,{$id}",
			"academie" => "required",
			"service"  => "required",
		]);

		$Utilisateur = Utilisateur::findOrFail($id);
		$Utilisateur->update($request->all());

		return redirect(route("web.administrations.utilisateurs.index"));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return RedirectResponse
	 */
	public function destroy(int $id): RedirectResponse
	{
		$Utilisateur = Utilisateur::findOrFail($id);
		$Utilisateur->delete();

		return redirect(route("web.administrations.utilisateurs.index"));
	}
}
