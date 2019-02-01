<?php

namespace App\Http\Controllers\Administrations;

use App\Http\Controllers\Controller;
use App\Models\Historique;
use Carbon\Carbon;
use Illuminate\View\View;

class HistoriqueController extends Controller
{
	/***
	 * GET - Retourne l'index de l'historique
	 *
	 * @return View
	 */
	public function index(): View
	{
	    Historique::where("created_at", "<=", Carbon::now()->subMonth(6)->toDateTimeString())->delete();

        $historiques = Historique::all();

        return view("web.administrations.historiques.index", compact("historiques"));
	}

	/***
	 * GET - Affiche une ligne de l'historique
	 *
	 * @param Historique $historique
	 * @return View
	 */
	public function show(Historique $historique): View
	{
		return view("web.administrations.historiques.show", compact("historique"));
	}
}
