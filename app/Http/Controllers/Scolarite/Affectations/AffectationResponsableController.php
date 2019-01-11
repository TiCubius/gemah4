<?php

namespace App\Http\Controllers\Scolarite\Affectations;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\Responsable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AffectationResponsableController extends Controller
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
		$responsables = Responsable::notRelated($eleve);

		if ($request->exists(["nom", "prenom", "email", "telephone"])) {
			$searchedResponsables = $responsables->search($request->input("nom"), $request->input("prenom"), $request->input("email"), $request->input("telephone"))
				->get();
		}

		return view("web.scolarites.eleves.affectations.responsables", compact("eleve", "latestCreatedResponsables", "latestUpdatedResponsables", "searchedResponsables"));
	}

	/***
	 * Crée la relation entre l'élève et le responsable indiqué
	 *
	 * @param Eleve       $eleve
	 * @param Responsable $responsable
	 * @return RedirectResponse
	 */
	public function attach(Eleve $eleve, Responsable $responsable): RedirectResponse
	{
		if (!($responsable->eleves()->find($eleve->id))) {
			$responsable->eleves()->attach($eleve->id);

			return redirect()->route("web.scolarites.eleves.show", [$eleve]);
		}

		return redirect()
			->route("web.scolarites.eleves.show", [$eleve])
			->withErrors("Le responsable est deja affecte à l'eleve");
	}

	/***
	 * Efface la relation entre l'élève et le responsable indiqué
	 *
	 * @param Eleve       $eleve
	 * @param Responsable $responsable
	 * @return RedirectResponse
	 */
	public function detach(Eleve $eleve, Responsable $responsable): RedirectResponse
	{
		if ($responsable->eleves()->find($eleve->id)) {
			$responsable->eleves()->detach($eleve->id);

			return redirect()->route("web.scolarites.eleves.show", [$eleve]);
		}

		return redirect()
			->route("web.scolarites.eleves.show", [$eleve])
			->withErrors("Le responsable n'est deja pas/plus affecte a l'eleve");
	}
}
