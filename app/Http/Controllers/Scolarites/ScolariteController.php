<?php

namespace App\Http\Controllers\Scolarites;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ScolariteController extends Controller
{

	/**
	 * @return View
	 */
	public function index(): View
	{
		return view("web.scolarites.index");
	}
}
