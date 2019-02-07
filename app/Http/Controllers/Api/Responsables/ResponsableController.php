<?php

namespace App\Http\Controllers\Api\Responsables;

use App\Filters\ResponsableFilters;
use App\Http\Controllers\Controller;
use App\Models\Responsable;

class ResponsableController extends Controller
{
	/**
	 * GET - Recherche tout les responsables à l'aide du filtre
	 *
	 * @param ResponsableFilters $filters
	 * @return mixed
	 */
	public function index(ResponsableFilters $filters)
	{
		$responsables = Responsable::filter($filters)->get();

		return $responsables;
	}
}