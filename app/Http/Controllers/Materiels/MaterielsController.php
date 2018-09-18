<?php

namespace App\Http\Controllers\Materiels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaterielsController extends Controller
{

	/**
	 * GET - Affiche l'index du menu Matériels
	 *
	 * @return View
	 */
	public function index(): View
	{
		return view('web.materiels.index');
	}

}
