<?php

namespace App\Http\Controllers\Scolarites\Documents;

use App\Http\Controllers\Controller;
use App\Models\Decision;
use App\Models\Document;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\TypeDecision;
use App\Models\TypeDocument;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DecisionController extends Controller
{
	/**
	 * PRIVATE - Génère un nom de fichier avec les données envoyées
	 *
	 * @param Eleve        $eleve
	 * @param UploadedFile $file
	 * @return string
	 */
	private function generateFilename(Eleve $eleve, UploadedFile $file): string
	{
		$nom = $eleve->nom . "-" . $eleve->prenom;
		$timestamp = Carbon::now()->timestamp;
		$extension = $file->getClientOriginalExtension();

		return $nom . "-" . $timestamp . "." . $extension;
	}

	/**
	 * PRIVATE - Supprime les accents
	 *
	 * @param $str
	 * @return string
	 */
	private function stripAccents($str)
	{
		return strtr(utf8_decode($str), utf8_decode("àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ"), "aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY");
	}

	/**
	 * GET - Affiche le formulaire de création d"une Décision
	 *
	 * @param Eleve $eleve
	 * @return View
	 */
	public function create(Eleve $eleve): View
	{
		$enseignants = Enseignant::all();
		$types = TypeDecision::all();

		return view("web.scolarites.eleves.documents.decisions.create", compact("eleve", "enseignants", 'types'));
	}

	/**
	 * POST - Enregistre la décision et le document associé
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Eleve                     $eleve
	 * @return RedirectResponse
	 */
	public function store(Request $request, Eleve $eleve): RedirectResponse
	{
		$dateAfter = Carbon::now()->subYear(50);
		$dateBefore = Carbon::now()->addYear(50);

		$request->validate([
			"date_limite"       => "nullable|date|before:{$dateBefore},after:{$dateAfter}",
			"date_cda"          => "nullable|date|before:{$dateBefore},after:{$dateAfter}",
			"date_notification" => "nullable|date|before:{$dateBefore},after:{$dateAfter}",
			"date_convention"   => "nullable|date|before:{$dateBefore},after:{$dateAfter}",
			"numero_dossier"    => "nullable|max:191",
			"enseignant_id"     => "nullable|exists:enseignants,id",
			"types"             => "required|exists:types_decisions,id",
			"file"              => "required",
		]);

		// On génère un nom de fichier
		$filename = $this->generateFilename($eleve, $request->file('file'));

		// On enregistre le fichier
		$request->file('file')->storeAs('public/decisions/', $filename);

		$document = Document::create([
			"nom"              => "Décision du " . Carbon::parse($request->input("date_notif"))->format("d/m/Y"),
			"description"      => $request->input("description"),
			"type_document_id" => TypeDocument::where("libelle", "Décision")->first()->id,
			"path"             => $filename,
			"eleve_id"         => $eleve->id,
		]);

		$decision = Decision::create([
			"date_cda"          => $request->input("date_cda"),
			"date_notification" => $request->input("date_notification"),
			"date_limite"       => $request->input("date_limite"),
			"date_convention"   => $request->input("date_convention"),
			"numero_dossier"    => $request->input("numero_dossier"),

			"document_id"   => $document->id,
			"enseignant_id" => $request->input("enseignant_id"),
		]);

		$decision->types()->sync($request->input("types"));

		return redirect(route("web.scolarites.eleves.documents.index", [$eleve]));
	}

	/**
	 * GET - Affiche le formulaire d"édition d"une décision
	 *
	 * @param Eleve    $eleve
	 * @param Decision $decision
	 * @return View|RedirectResponse
	 */
	public function edit(Eleve $eleve, Decision $decision)
	{
		if ($decision->document->eleve_id != $eleve->id) {
			return back()->withErrors("Impossible d'éditer une décision qui n'appartient pas à cet élève");
		}

		$enseignants = Enseignant::all();
		$types = TypeDecision::all();

		return view('web.scolarites.eleves.documents.decisions.edit', compact('eleve', 'enseignants', 'decision', 'types'));
	}

	/**
	 * PATCH - Met à jour la décision et le document asocié
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Eleve                     $eleve
	 * @param Decision                  $decision
	 * @return RedirectResponse
	 */
	public function update(Request $request, Eleve $eleve, Decision $decision): RedirectResponse
	{
		$dateBefore = Carbon::now()->addYear(25);
		$dateAfter = Carbon::now()->subYear(25);

		if ($decision->document->eleve_id != $eleve->id) {
			return back()->withErrors("Impossible d'éditer une décision qui n'appartient pas à cet élève");
		}

		$request->validate([
			"date_limite"       => "nullable|date|before:{$dateBefore},after:{$dateAfter}",
			"date_cda"          => "nullable|date|before:{$dateBefore},after:{$dateAfter}",
			"date_notification" => "nullable|date|before:{$dateBefore},after:{$dateAfter}",
			"date_convention"   => "nullable|date|before:{$dateBefore},after:{$dateAfter}",
			"numero_dossier"    => "nullable|max:191",
			"enseignant_id"     => "nullable|exists:enseignants,id",
		]);

		if ($request->hasFile("file")) {
			// On supprime l"ancien fichier
			Storage::delete("public/{$decision->document->path}");

			// On enregistre le fichier
			$filename = $this->generateFilename($eleve, $request->file("file"));
			$request->file("file")->storeAs("public/decisions/", $filename);

			// Mise a jours du document
			$decision->document->update([
				"path" => $filename,
			]);
		}

		$decision->update([
			"date_cda"          => $request->input("date_cda"),
			"date_notification" => $request->input("date_notification"),
			"date_limite"       => $request->input("date_limite"),
			"date_convention"   => $request->input("date_convention"),
			"numero_dossier"    => $request->input("numero_dossier"),

			"enseignant_id" => $request->input("enseignant_id"),
			"document_id"   => isset($document) ? $document->id : $decision->document_id,
		]);

		$decision->types()->sync($request->input("types"));

		return redirect(route("web.scolarites.eleves.documents.index", [$eleve]));
	}

	/**
	 * DELETE - Supprime la décision et le document associé
	 *
	 * @param Eleve    $eleve
	 * @param Decision $decision
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Eleve $eleve, Decision $decision): RedirectResponse
	{
		if ($decision->document->eleve_id != $eleve->id) {
			return back()->withErrors("Impossible de supprimer une décision qui n'appartient pas à cet élève");
		}
		$decision->delete();

		return redirect(route("web.scolarites.eleves.documents.index", [$eleve]));
	}

	/**
	 * GET - Télécharge la décision
	 *
	 * @param Eleve    $eleve
	 * @param Decision $decision
	 * @return StreamedResponse|RedirectResponse
	 */
	public function download(Eleve $eleve, Decision $decision)
	{
		if ($decision->document->eleve_id != $eleve->id) {
			return back()->withErrors("Impossible de télécharger une décision qui n'appartient pas cet élève");
		}

		return Storage::download("public/decisions/{$decision->document->path}", $this->stripAccents($decision->document->path));
	}

}
