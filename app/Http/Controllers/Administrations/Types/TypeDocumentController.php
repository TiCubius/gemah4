<?php

namespace App\Http\Controllers\Administrations\Types;

use App\Http\Controllers\Controller;
use App\Models\TypeDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TypeDocumentController extends Controller
{
	/**
	 * GET - Affiche la liste des types de document
	 *
	 * @return View
	 */
	public function index(): View
	{

		$documents = TypeDocument::orderBy("libelle")->get();

		return view("web.administrations.types.documents.index", compact("types_documents"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un type de document
	 *
	 * @return View
	 */
	public function create(): View
	{
		return view("web.administrations.types.documents.create");
	}

	/**
	 * POST - Ajoute un nouveau type de document
	 *
	 * @param  Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			"libelle" => "required|max:191|unique:types_documents,libelle",
		]);

		TypeDocument::create($request->only(["libelle"]));

		return redirect(route("web.administrations.types.documents.index"));
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un type de document
	 *
	 * @param TypeDocument $document
	 * @return View
	 */
	public function edit(TypeDocument $document): View
	{
		return view("web.administrations.types.documents.edit", compact("document"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au type de document
	 *
	 * @param Request      $request
	 * @param TypeDocument $document
	 * @return RedirectResponse
	 */
	public function update(Request $request, TypeDocument $document): RedirectResponse
	{
		$request->validate([
			"libelle" => "required|max:191|unique:types_documents,libelle,{$document->id}",
		]);

		$document->update($request->only(["libelle"]));

		return redirect(route("web.administrations.types.documents.index"));
	}

	/**
	 * DELETE - Supprime le type de document
	 *
	 * @param TypeDocument $document
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(TypeDocument $document): RedirectResponse
	{
		if ($document->documents->isNotEmpty()) {
			return back()->withErrors("Impossible de supprimer un type associé à des documents");
		}

		$document->delete();

		return redirect(route("web.administrations.types.documents.index"));
	}
}
