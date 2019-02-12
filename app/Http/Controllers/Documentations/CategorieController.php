<?php

namespace App\Http\Controllers\Documentations;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class CategorieController extends Controller
{
	/**
	 * @var Collection
	 */
	private $categories;

	public function __construct()
	{
		// On récupère toutes les catégories sans parent
		$this->categories = Categorie::whereNull("categorie_id")->with("enfants", "documentations")->get();
	}

	/**
	 * GET - Affiche la documentation
	 *
	 * @return View
	 */
	public function index(): View
	{
		return view("docs.categories.index", [
			"categoriesList" => Categorie::with("parent")->get(),
			"categories"     => $this->categories,
		]);
	}

	/**
	 * GET - Affiche la page de création d'une documentation
	 *
	 * @return View
	 */
	public function create(): View
	{
		return view("docs.categories.create", [
			"categories" => $this->categories,
		]);
	}

	/**
	 * POST - Ajoute une nouvelle catégorie
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			"libelle" => "required|max:255",
		]);

		Categorie::create($request->all());

		return redirect(route("categories.index"));
	}

	/**
	 * GET - Affiche la page d'édition d'une documentation
	 *
	 * @param Categorie $categorie
	 * @return View
	 */
	public function edit(Categorie $categorie): View
	{
		return view("docs.categories.edit", [
			"categorie"  => $categorie,
			"categories" => $this->categories,
		]);
	}

	/**
	 * PATCH - Met à jour une documentation
	 *
	 * @param Request   $request
	 * @param Categorie $categorie
	 * @return RedirectResponse
	 */
	public function update(Request $request, Categorie $categorie): RedirectResponse
	{
		$request->validate([
			"libelle" => "required|max:255",
		]);

		$categorie->update($request->all());

		return redirect(route("categories.index"));
	}

	/**
	 * DELETE - Supprime une documentation
	 *
	 * @param Categorie $categorie
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Categorie $categorie): RedirectResponse
	{
		$categorie->enfants()->delete();
		$categorie->delete();

		return redirect(route("categories.index"));
	}
}