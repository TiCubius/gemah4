<?php

namespace App\Http\Controllers\Api\Scolarites;

use App\Filters\EleveFilters;
use App\Http\Controllers\Controller;
use App\Models\Eleve;

class EleveController extends Controller
{
	/**
	 * GET - Recherche tout les élèves à l'aide du filtre
	 *
	 * @param EleveFilters $filters
	 * @return mixed
	 */
	public function index(EleveFilters $filters)
	{
		$eleves = Eleve::filter($filters)->get();

		return $eleves;
	}
}
