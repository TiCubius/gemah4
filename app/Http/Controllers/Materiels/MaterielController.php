<?php

namespace App\Http\Controllers\Materiels;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class MaterielController extends Controller
{
	/**
	 * GET - Affiche l'index du menu matériels
	 *
	 * @return View
	 */
	public function index(): View
	{
		return view('web.materiels.index');
	}
}
