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

class UtilisateurController extends Controller
{
	/**
	 * GET - Affiche la liste des utilisateurs
	 *
	 * @return View
	 */
	public function index(): View
	{
		$utilisateurs = Utilisateur::with("service")->orderBy("nom")->get();

		return view("web.administrations.utilisateurs.index", compact("utilisateurs"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un utilisateur
	 *
	 * @return View
	 */
	public function create(): View
	{
		$academies = Academie::with("region", "departements")->orderBy("nom")->get();
		$services = Service::orderBy("nom")->get();

		return view("web.administrations.utilisateurs.create", compact("academies", "services"));
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
			"service"  => "required|exists:services,id",
		]);

		Utilisateur::create([
			"nom"      => $request->input("nom"),
			"prenom"   => $request->input("prenom"),
			"email"    => $request->input("email"),
			"password" => Hash::make($request->input("password")),
			"service_id"  => $request->input("service"),
		]);

		return redirect(route("web.administrations.utilisateurs.index"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Utilisateur $utilisateur
	 * @return void
	 */
	public function show(Utilisateur $utilisateur)
	{
		//
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un utilisateur
	 *
	 * @param Utilisateur $utilisateur
	 * @return View
	 */
	public function edit(Utilisateur $utilisateur): View
	{
		$academies = Academie::with("region", "departements")->orderBy("nom")->get();
		$services = Service::orderBy("nom")->get();

		return view("web.administrations.utilisateurs.edit", compact("utilisateur", "academies", "services"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au utilisateur
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Utilisateur               $utilisateur
	 * @return RedirectResponse
	 */
	public function update(Request $request, Utilisateur $utilisateur): RedirectResponse
	{
		$request->validate([
			"nom"      => "required|max:191",
			"prenom"   => "required|max:191",
			"email"    => "required|max:191|email|unique:utilisateurs,email,{$utilisateur->id}",
			"service"  => "required|exists:services,id",
		]);

		$utilisateur->update($request->all());

		return redirect(route("web.administrations.utilisateurs.index"));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Utilisateur $utilisateur
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Utilisateur $utilisateur): RedirectResponse
	{
		$utilisateur->delete();

		return redirect(route("web.administrations.utilisateurs.index"));
	}
}
