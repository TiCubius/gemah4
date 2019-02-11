<?php

namespace App\Http\Controllers\Scolarites;

use App\Http\Controllers\Controller;
use App\Models\Academie;
use App\Models\Eleve;
use App\Models\Responsable;
use App\Models\TypeDecision;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use ZanySoft\Zip\Zip;

class EleveController extends Controller
{
	/**
	 * GET - Affiche la liste des élèves
	 *
	 * @param Request $request
	 * @return View
	 */
	public function index(Request $request): View
	{
		$academies = Academie::with("departements")->get();
		$typesEleve = TypeDecision::all();

		$latestCreated = Eleve::latestCreated()->take(5)->get();
		$latestUpdated = Eleve::latestUpdated()->take(5)->get();

		if ($request->hasAny(["departement_id", "type_eleve_id", "nom", "prenom", "date_naissance", "code_ine"])) {
			$eleves = Eleve::search($request->input("departement_id"), $request->input("type_eleve_id"), $request->input("nom"), $request->input("prenom"), $request->input("date_naissance"), $request->input("code_ine"), null)->get();
		}

		return view("web.scolarites.eleves.index", compact("academies", "eleves", "latestCreated", "latestUpdated", "typesEleve"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un eleve
	 *
	 * @return View
	 */
	public function create(): View
	{
		$academies = Academie::with("departements")->get();
		$types = TypeDecision::all();

		return view("web.scolarites.eleves.create", compact("academies", "types"));
	}

	/**
	 * POST - Ajoute un nouvel élève
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$dateAfter = Carbon::now()->subYear(50);
		$dateBefore = Carbon::now()->addYear(50);

		$request->validate([
			"nom"            => "required|max:255",
			"prenom"         => "required|max:255",
			"date_naissance" => "required|date|before:{$dateBefore},after:{$dateAfter}",
			"classe"         => "nullable|max:255",
			"departement_id" => "required|exists:departements,id",
			"code_ine"       => "nullable|max:11|unique:eleves",
		]);

        $request->merge(["joker" => $request->input("joker") ? 1 : 0]);

		Eleve::create($request->all());

		return redirect(route("web.scolarites.eleves.index"));
	}

	/**
	 * GET - Affiche les informations sur l'élève
	 *
	 * @param Eleve $eleve
	 * @return View
	 */
	public function show(Eleve $eleve): View
	{
		// Eager loading : charge les relations nécessaires avant l'affichage de la vue
		$eleve->load("etablissement.type", "materiels.type", "responsables");

		return view("web.scolarites.eleves.show", compact("eleve"));
	}


	/**
	 * GET - Affiche la liste du matériel affecté à l'élève
	 *
	 * @param Eleve $eleve
	 * @return View
	 */
	public function materiels(Eleve $eleve): View
	{
		$materiels = $eleve->materiels();

		return view("web.scolarites.eleves.materiels", compact("eleve", "materiels"));
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un élève
	 *
	 * @param Eleve $eleve
	 * @return View
	 */
	public function edit(Eleve $eleve): View
	{
		$academies = Academie::with("departements")->get();
		$types = TypeDecision::all();
		$eleve->load("responsables.eleves");

		return view("web.scolarites.eleves.edit", compact("academies", "eleve", "types"));
	}

	/**
	 * PUT - Enregistre les modifications apportés a l'élève
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Eleve                     $eleve
	 * @return RedirectResponse
	 */
	public function update(Request $request, Eleve $eleve): RedirectResponse
	{
		$dateAfter = Carbon::now()->subYear(50);
		$dateBefore = Carbon::now()->addYear(50);

		$request->validate([
			"nom"            => "required|max:255",
			"prenom"         => "required|max:255",
			"date_naissance" => "required|date|before:{$dateBefore},after:{$dateAfter}",
			"classe"         => "nullable|max:255",
			"departement_id" => "required|exists:departements,id",
			"code_ine"       => "nullable|max:11|unique:eleves,code_ine,{$eleve->id}",
		]);

		$request->merge(["joker" => $request->input("joker") ? 1 : 0]);

		$eleve->update($request->all());

		return redirect(route("web.scolarites.eleves.show", [$eleve]));
	}

	/**
	 * DELETE - Supprime l'élève
	 *
	 * @param Eleve   $eleve
	 * @param Request $request
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Eleve $eleve, Request $request): RedirectResponse
	{
		$eleve->delete();
		if ($request->has("delete-responsables")) {
			foreach ($request->input("delete-responsables") as $responsbale) {
				Responsable::find("$responsbale")->delete();
			}
		}

		return redirect(route("web.scolarites.eleves.index"));
	}

	/**
	 * GET - Exporte toutes les données d'un élève
	 *
	 * @param Eleve $eleve
	 * @return Eleve
	 * @throws \Exception
	 */
	public function export(Eleve $eleve)
	{
		$eleve->load("departement.academie.region", "documents.type", "documents.decision.enseignant", "documents.decision.types", "etablissement.type", "materiels.departement.academie.region", "materiels.etatAdministratif", "materiels.etatPhysique", "materiels.type.domaine", "responsables.departement.academie.region", "tickets.type", "tickets.messages");

		// On génère le fichier .json
		Storage::put("export/eleves/{$eleve->nom} {$eleve->prenom}/{$eleve->nom} {$eleve->prenom}.json", json_encode($eleve, JSON_PRETTY_PRINT));

		// On récupère toutes les décisions & documents
		$eleve->documents()->each(function ($document) use ($eleve) {
			if ($document->type->libelle === "Décision") {
				Storage::copy("public/decisions/{$document->path}", "export/eleves/{$eleve->nom} {$eleve->prenom}/decisions/{$document->path}");
			} else {
				Storage::copy("public/decisions/{$document->path}", "export/eleves/{$eleve->nom} {$eleve->prenom}/documents/{$document->path}");
			}
		});

		// On génère le .zip
		$zip = Zip::create(storage_path("app/export/{$eleve->nom}_{$eleve->prenom}.zip"));
		$zip->add(storage_path("app/export/eleves/{$eleve->nom} {$eleve->prenom}/"));
		$zip->close();

		// On supprime les fichiers
		Storage::deleteDirectory("export/eleves/{$eleve->nom} {$eleve->prenom}");

		// On télécharge et supprime le zip
		return response()->download((storage_path("app/export/{$eleve->nom}_{$eleve->prenom}.zip")))->deleteFileAfterSend();
	}
}
