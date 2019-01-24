<?php

namespace App\Http\Controllers\Scolarites\Affectations;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\Eleve;
use App\Models\Responsable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResponsableController extends Controller
{
	/***
	 * GET - Liste des responsables qu'il est possible d'affecter
	 *
	 * @param Eleve   $eleve
	 * @param Request $request
	 * @return View
	 */
	public function index(Eleve $eleve, Request $request): View
	{
		$academies = Academie::with("departements")->get();

		$latestCreated = Responsable::latestCreated()->notRelated($eleve)->take(5)->get();
		$latestUpdated = Responsable::latestUpdated()->notRelated($eleve)->take(5)->get();

		if ($request->exists(["nom", "prenom", "email", "telephone", "departement_id"])) {
			$responsables = Responsable::search($request->input("nom"), $request->input("prenom"), $request->input("email"), $request->input("telephone"), $request->input("departement_id"))->notRelated($eleve)->get();
		}

		return view("web.scolarites.eleves.affectations.responsables", compact('academies', 'eleve', 'latestCreated', 'latestUpdated', 'responsables'));
	}

	/***
	 * POST - Affecte l'élève au responsable
	 *
	 * @param Eleve       $eleve
	 * @param Responsable $responsable
	 * @return RedirectResponse
	 */
	public function attach(Eleve $eleve, Responsable $responsable): RedirectResponse
	{
		if (!$responsable->eleves->contains($eleve)) {
			$responsable->eleves()->attach($eleve);

			return redirect(route("web.scolarites.eleves.show", [$eleve]));
		}

		return redirect(route("web.scolarites.eleves.show", [$eleve]))->withErrors("Ce responsable est déjà affecté à cet élève.");
	}

	/***
	 * DELETE - Désaffecte le responsable de cet élève
	 *
	 * @param Eleve       $eleve
	 * @param Responsable $responsable
	 * @return RedirectResponse
	 */
	public function detach(Eleve $eleve, Responsable $responsable): RedirectResponse
	{
		if ($responsable->eleves->contains($eleve)) {
			$responsable->eleves()->detach($eleve);

			return redirect(route("web.scolarites.eleves.show", [$eleve]));
		}

		return redirect(route("web.scolarites.eleves.show", [$eleve]))->withErrors("Ce responsable n'est pas affecté à cet élève");
	}
}
