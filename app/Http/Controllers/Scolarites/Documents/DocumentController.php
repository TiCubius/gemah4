<?php

namespace App\Http\Controllers\Scolarites\Documents;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Eleve;
use App\Models\TypeDocument;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
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
		$nomEleve = $eleve->nom . '-' . $eleve->prenom;
		$timestamp = Carbon::now()->timestamp;
		$extension = $file->getClientOriginalExtension();

		return $nomEleve . '-' . $timestamp . '.' . $extension;
	}

	/**
	 * PRIVATE - Supprime les accents
	 *
	 * @param $str
	 * @return string
	 */
	private function stripAccents($str)
	{
		return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
	}

	/**
	 * GET - Affiche la liste des documents pour l'élève
	 *
	 * @param Eleve $eleve
	 * @return View
	 */
	public function index(Eleve $eleve): View
	{
		$typesDocument = TypeDocument::all();
		$eleve->load("documents.typeDocument", "documents.decision.enseignant");

		return view('web.scolarites.eleves.documents.index', compact('eleve', 'typesDocument'));
	}

	/**
	 * GET - Affiche le formulaire de création d'un document
	 *
	 * @param Eleve $eleve
	 * @return View
	 */
	public function create(Eleve $eleve): View
	{
		$types = TypeDocument::all();

		return view('web.scolarites.eleves.documents.create', compact('eleve', 'types'));
	}

	/**
	 * POST - Enregistre une décision
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Eleve                     $eleve
	 * @return RedirectResponse
	 */
	public function store(Request $request, Eleve $eleve): RedirectResponse
	{
		$request->validate([
			'nom'              => 'required|max:191',
			'description'      => 'required|max:191',
			'type_document_id' => 'required|exists:types_documents,id',
			'file'             => 'required',
		]);

		// On enregistre le fichier
		$filename = $this->generateFilename($eleve, $request->file('file'));
		$request->file('file')->storeAs('public/documents/', $filename);

		Document::create([
			'nom'              => $request->input('nom'),
			'description'      => $request->input('description'),
			'type_document_id' => $request->input('type_document_id'),
			'path'             => $filename,
			'eleve_id'         => $eleve->id,
		]);

		return redirect(route('web.scolarites.eleves.documents.index', $eleve->id));
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un document
	 *
	 * @param Eleve    $eleve
	 * @param Document $document
	 * @return View|RedirectResponse
	 */
	public function edit(Eleve $eleve, Document $document)
	{
		if ($document->eleve_id == $eleve->id) {
			return view('web.scolarites.eleves.documents.edit', compact('eleve', 'document'));
		}

		return back()->withErrors("Ce document n'appartient pas à cet élève");
	}

	/**
	 * PATCH - Met a jour le document
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param Eleve                     $eleve
	 * @param Document                  $document
	 * @return RedirectResponse
	 */
	public function update(Request $request, Eleve $eleve, Document $document): RedirectResponse
	{
		if ($document->eleve_id == $eleve->id) {
			$request->validate([
				'nom'         => 'required|max:191',
				'description' => 'required|max:191',
				'file'        => 'nullable',
			]);

			if ($request->hasFile('file')) {
				// On supprime l'ancien fichier
				if ($document->path !== null) {
					Storage::delete('public/documents/' . $document->path);
				}

				// On enregistre le fichier
				$filename = $this->generateFilename($eleve, $request->file('file'));
				$request->file('file')->storeAs('public/documents/', $filename);
			}

			$document->update([
				'nom'         => $request->input('nom'),
				'description' => $request->input('description'),
				'path'        => $filename ?? $document->path,
			]);

			return redirect(route('web.scolarites.eleves.documents.index', [$eleve->id]));
		}

		return back()->withErrors("Ce document n'appartient pas à cet élève");
	}


	/**
	 * DELETE - Supprime le document
	 *
	 * @param Eleve    $eleve
	 * @param Document $document
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Eleve $eleve, Document $document): RedirectResponse
	{
		if ($document->eleve_id == $eleve->id) {
			// On supprime le fichier associé
			Storage::delete('public/documents/' . $document->path);

			// On supprime le Document
			$document->delete();

			return redirect(route('web.scolarites.eleves.documents.index', $eleve->id));
		}

		return back()->withErrors("Ce document n'appartient pas à cet élève");
	}

	/**
	 * GET - Télécharge le document
	 *
	 * @param Eleve    $eleve
	 * @param Document $document
	 * @return StreamedResponse|RedirectResponse
	 */
	public function download(Eleve $eleve, Document $document)
	{
		if ($document->eleve_id == $eleve->id) {
			return Storage::download('public/documents/' . $document->path, $this->stripAccents($document->path));
		}

		return back()->withErrors("Ce document n'appartient pas cet élève");
	}
}
