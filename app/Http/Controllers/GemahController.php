<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class GemahController extends Controller
{

	/**
	 * Affiche l'Index de l'application
	 * @return View
	 */
	public function index(): View
	{
		return view('web.index');
	}

}
