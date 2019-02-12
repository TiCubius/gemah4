<?php

namespace App\Http\Controllers\Documentations;

use App\Models\Categorie;
use App\Models\Documentation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DocumentationController extends Controller
{
	/**
	 * @var Collection
	 */
	private $categories;

	public function __construct()
	{
		// On récupère toutes les catégories sans parent
		$this->categories = Categorie::whereNull("categorie_id")->with("enfants", "documentations")->orderBy("libelle")->get();
	}

	/**
	 * GET - Affiche la documentation
	 *
	 * @return View
	 */
	public function index(): View
	{
		$documentations = Documentation::with("categorie")->get();

		return view("docs.documentations.index", [
			"categories"     => $this->categories,
			"documentations" => $documentations,
		]);
	}

	/**
	 * GET - Affiche un documentation précise
	 *
	 * @param Documentation $documentation
	 * @return View
	 */
	public function show(Documentation $documentation): View
	{
		return view("docs.documentations.show", [
			"categories"    => $this->categories,
			"documentation" => $documentation,
		]);
	}

	/**
	 * GET - Affiche la page de création d'une documentation
	 *
	 * @return View
	 */
	public function create(): View
	{
		return view("docs.documentations.create", [
			"categories" => $this->categories,
		]);
	}

	/**
	 * POST - Ajoute une nouvelle documentation
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			"libelle"      => "required|max:255",
			"categorie_id" => "required|exists:categories,id",
			"contenu"      => "required",
		]);

		Documentation::create($request->only(["categorie_id", "libelle", "contenu"]));

		return redirect(route("documentations.index"));
	}

	/**
	 * GET - Affiche la page d'édition d'une documentation
	 *
	 * @param Documentation $documentation
	 * @return View
	 */
	public function edit(Documentation $documentation): View
	{
		return view("docs.documentations.edit", [
			"categories"    => $this->categories,
			"documentation" => $documentation,
		]);
	}

	/**
	 * PATCH - Met à jour une documentation
	 *
	 * @param Request       $request
	 * @param Documentation $documentation
	 * @return RedirectResponse
	 */
	public function update(Request $request, Documentation $documentation): RedirectResponse
	{
		$request->validate([
			"libelle"      => "required|max:255",
			"categorie_id" => "required|exists:categories,id",
			"contenu"      => "required",
		]);

		$documentation->update($request->all());

		return redirect(route("documentations.show", [$documentation]));
	}

	/**
	 * DELETE - Supprime une documentation
	 *
	 * @param Documentation $documentation
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Documentation $documentation): RedirectResponse
	{
		$documentation->delete();

		return redirect(route("documentations.index"));
	}
}