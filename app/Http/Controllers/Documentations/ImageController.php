<?php

namespace App\Http\Controllers\Documentations;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ImageController extends Controller
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
	 * GET - Affiche la liste des images
	 *
	 * @return View
	 */
	public function index(): View
	{
		$images = Image::orderBy("created_at", "DESC")->get();

		return view("docs.images.index", [
			"categories" => $this->categories,
			"images"     => $images,
		]);
	}

	/**
	 * POST - Enregistre une image
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			"file" => "required|image",
		]);

		$filename = Carbon::now()->timestamp . "-" . $request->file("file")->getClientOriginalName();

		$request->file("file")->storeAs("public/images/", $filename);
		Image::create([
			"path" => "images/{$filename}",
		]);

		return redirect(route("images.index"));
	}

	/**
	 * DELETE - Supprime une image
	 *
	 * @param Image $image
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Image $image): RedirectResponse
	{
		$image->delete();
		Storage::delete("public/{$image->path}");

		return redirect(route("images.index"));
	}

}

