<?php

namespace App\Http\Controllers\Scolarites\Affectations;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\Eleve;
use App\Models\Historique;
use App\Models\Responsable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResponsableController extends Controller
{
	/***
	 * GET - Liste des responsables qu'il est possible d'affecter
	 *
	 * @param Request $request
	 * @param Eleve   $eleve
	 * @return View
	 */
	public function index(Request $request, Eleve $eleve): View
	{
		$academies = Academie::with("departements")->get();

		$latestCreated = Responsable::latestCreated()->notRelated($eleve)->take(5)->get();
		$latestUpdated = Responsable::latestUpdated()->notRelated($eleve)->take(5)->get();

		if ($request->exists(["nom", "prenom", "email", "telephone", "departement_id"])) {
			$responsables = Responsable::search($request->input("nom"), $request->input("prenom"), $request->input("email"), $request->input("telephone"), $request->input("departement_id"))->notRelated($eleve)->get();
		}

		return view("web.scolarites.eleves.affectations.responsables.index", compact('academies', 'eleve', 'latestCreated', 'latestUpdated', 'responsables'));
	}

	/**
	 * GET - Affiche le formulaire de création d'un responsable
	 *
	 * @param Eleve $eleve
	 * @return View
	 */
	public function create(Eleve $eleve): View
	{
		$academies = Academie::with("departements")->get();

		return view("web.scolarites.eleves.affectations.responsables.create", compact("eleve", "academies"));
	}

	/**
	 * POST - Ajoute un nouveau responsable
	 *
	 * @param Request $request
	 * @param Eleve   $eleve
	 * @return RedirectResponse
	 */
	public function store(Request $request, Eleve $eleve): RedirectResponse
	{
		$request->validate([
			"civilite"       => "required",
			"nom"            => "required|max:191",
			"prenom"         => "required|max:191",
			"email"          => "nullable|email|max:191",
			"telephone"      => "nullable",
			"code_postal"    => "nullable|max:191",
			"ville"          => "nullable|max:191",
			"adresse"        => "nullable|max:191",
			"departement_id" => "required|exists:departements,id",
		]);

		$responsable = Responsable::create($request->only([
			"civilite",
			"nom",
			"prenom",
			"email",
			"telephone",
			"code_postal",
			"ville",
			"adresse",
			"departement_id",
		]));

		$responsable->eleves()->attach($eleve);

        $user = session("user");

        Historique::create([
            "from_id"           => $user["id"],
            "eleve_id"          => $eleve->id,
            "responsable_id"    => $responsable->id,
            "type"              => "responsable/affectation",
            "contenue"          => "Le responsable {$responsable->nom} {$responsable->prenom} à été affecté à l'élève {$eleve->nom} {$eleve->prenom} par {$user->nom} {$user->prenom}"
        ]);

		return redirect(route("web.scolarites.eleves.show", [$eleve]));
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

            $user = session("user");

            Historique::create([
                "from_id"           => $user["id"],
                "eleve_id"          => $eleve->id,
                "responsable_id"    => $responsable->id,
                "type"              => "responsable/affectation",
                "contenue"          => "Le responsable {$responsable->nom} {$responsable->prenom} à été affecté à l'élève {$eleve->nom} {$eleve->prenom} par {$user->nom} {$user->prenom}"
            ]);

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

            $user = session("user");

            Historique::create([
                "from_id"           => $user["id"],
                "eleve_id"          => $eleve->id,
                "responsable_id"    => $responsable->id,
                "type"              => "responsable/desaffectation",
                "contenue"          => "Le responsable {$responsable->nom} {$responsable->prenom} à été désaffecté de l'élève {$eleve->nom} {$eleve->prenom} par {$user->nom} {$user->prenom}"
            ]);

			return redirect(route("web.scolarites.eleves.show", [$eleve]));
		}

		return redirect(route("web.scolarites.eleves.show", [$eleve]))->withErrors("Ce responsable n'est pas affecté à cet élève");
	}
}
