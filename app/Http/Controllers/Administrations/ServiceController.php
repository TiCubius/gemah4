<?php

namespace App\Http\Controllers\Administrations;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\Permission;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
	/**
	 * GET - Affiche la liste des services
	 *
	 * @return View
	 */
	public function index(): View
	{
		$academies = Academie::with("departements")->get();
		$services = Service::orderBy("nom")->get();

		return view("web.administrations.services.index", compact("academies", "services"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un service
	 *
	 * @return View
	 */
	public function create(): View
	{
		$academies = Academie::with("departements")->get();
		$permissions = Permission::all();

		$groupedPermissions = $permissions->mapToGroups(function ($item, $key) {
			$permissionStart = implode('/', explode('/', $item->id, -1));
			return [$permissionStart => $item];
		})->sortKeys();

		return view("web.administrations.services.create", compact("academies", "groupedPermissions"));
	}

	/**
	 * POST - Ajoute un nouveau service
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$request->validate([
			"nom"            => "required|max:191|unique_with:services,departement_id",
			"description"    => "required|max:191",
			"departement_id" => "required|max:191|exists:departements,id",
		]);

		$service = Service::create($request->only(["nom", "description", "departement_id"]));

		if ($request->has("permissions")) {
			// On récupère toutes les permissions
			$permissions = Permission::all();

			// On affecte les nouvelles permissions
			foreach ($request->input("permissions") as $key => $value) {
				$permission = $permissions->find("id", $key);
				$service->permissions()->attach($permission);
			}
		}

		return redirect(route("web.administrations.services.index"));
	}

	/**
	 * GET - Affiche les données d'un service
	 *
	 * @param Service $service
	 * @return View
	 */
	public function show(Service $service): View
	{
		return view("web.administrations.services.show", compact("service"));
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un service
	 *
	 * @param Service $service
	 * @return View
	 */
	public function edit(Service $service): View
	{
		$academies = Academie::with("departements")->get();
		$permissions = Permission::all();

		$groupedPermissions = $permissions->mapToGroups(function ($item, $key) {
			$permissionStart = implode('/', explode('/', $item->id, -1));
			return [$permissionStart => $item];
		})->sortKeys();


		return view("web.administrations.services.edit", compact("academies", "groupedPermissions", "service"));
	}

	/**
	 * PATCH - Enregistre les modifications apportés au service
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Service                   $service
	 * @return RedirectResponse
	 */
	public function update(Request $request, Service $service)
	{
		$request->validate([
			"nom"            => "required|max:191|unique_with:services,departement_id,{$service->id}",
			"description"    => "required|max:191",
			"departement_id" => "required|exists:departements,id",
		]);

		$service->update($request->only(["nom", "description", "departement_id"]));

		if ($request->has("permissions")) {
			// On récupère les permissions
			$permissions = Permission::all();

			// On supprime toutes les permissions du service
			$service->permissions()->detach();

			// On indique que le service a été modifié
			$service->touch();

			// On réaffecte les nouvelles permissions
			foreach ($request->input("permissions") as $key => $value) {
				$permission = $permissions->find("id", $key);
				$service->permissions()->attach($permission);
			}
		}

		return redirect(route("web.administrations.services.index"));
	}

	/**
	 * DELETE - Supprime le service
	 *
	 * @param Service $service
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Service $service): RedirectResponse
	{
		if ($service->utilisateurs->isNotEmpty()) {
			return back()->withErrors("Impossible de supprimer un service associé à des utilisateurs");
		}

		$service->delete();

		return redirect(route("web.administrations.services.index"));
	}
}
