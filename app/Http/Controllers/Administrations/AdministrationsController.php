<?php

namespace App\Http\Controllers\Administrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdministrationsController extends Controller
{

	/**
	 * Affiche l'index du menu Admunistration de l'application
	 *
	 * @return View
	 */
	public function index(): View
	{
		return view('web.administrations.index');
	}

}
