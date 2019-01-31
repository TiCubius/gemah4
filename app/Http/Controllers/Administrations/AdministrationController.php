<?php

namespace App\Http\Controllers\Administrations;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdministrationController extends Controller
{

	/**
	 * GET - Affiche l'index du menu administration de l'application
	 *
	 * @return View
	 */
	public function index(): View
	{
		return view('web.administrations.index');
	}

}
