<?php

namespace App\Http\Controllers\Scolarite;

use Illuminate\Http\Request;
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
