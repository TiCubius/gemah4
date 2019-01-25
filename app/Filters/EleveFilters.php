<?php

namespace App\Filters;

use App\Models\Eleve;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EleveFilters extends QueryFilters
{
	protected $request;

	public function __construct(Request $request)
	{
		parent::__construct($request);

		$this->request = $request;
	}


	/**
	 * FILTRE - Recherche sur le code INE
	 *
	 * @param null $term
	 * @return mixed
	 */
	public function code_ine($term = null)
	{
		if ($term) {
			return $this->builder->where("code_ine", "LIKE", "%{$term}%");
		}
	}

	/**
	 * FILTRE - Recherche sur la date de naissance
	 *
	 * @param null $term
	 * @return mixed
	 */
	public function date_naissance($term = null)
	{
		if ($term) {
			$term = Carbon::parse($term);
			return $this->builder->where("date_naissance", $term);
		}
	}

	/**
	 * FILTRE - Recherche sur le département
	 *
	 * @param null $term
	 * @return mixed
	 */
	public function departement_id($term = null)
	{
		if ($term) {
			return $this->builder->where("departement_id", $term);
		}
	}

	/**
	 * FILTRE - Recherche sur le nom
	 *
	 * @param null $term
	 * @return mixed
	 */
	public function nom($term = null)
	{
		if ($term) {
			return $this->builder->where("nom", "LIKE", "%{$term}%");
		}
	}

	/**
	 * FILTRE - Recherche sur le prénom
	 *
	 * @param null $term
	 * @return mixed
	 */
	public function prenom($term = null)
	{
		if ($term) {
			return $this->builder->where("prenom", "LIKE", "%{$term}%");
		}
	}

	/**
	 * FILTRE - Recherche sur le type d'élève
	 *
	 * @param null $term
	 * @return mixed
	 */
	public function type_eleve_id($term = null)
	{
		if ($term) {
			return $this->builder->whereHas("types", function ($query) use ($term) {
				return $query->where("id", $term);
			});
		}
	}
}