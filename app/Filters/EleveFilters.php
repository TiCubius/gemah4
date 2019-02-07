<?php

namespace App\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
	 * @return Builder|null
	 */
	public function code_ine($term = null): ?Builder
	{
		if ($term) {
			return $this->builder->where("code_ine", "LIKE", "%{$term}%");
		}

		return null;
	}

	/**
	 * FILTRE - Recherche sur la date de naissance
	 *
	 * @param null $term
	 * @return Builder|null
	 */
	public function date_naissance($term = null): ?Builder
	{
		if ($term) {
			$term = Carbon::parse($term);
			return $this->builder->where("date_naissance", $term);
		}

		return null;
	}

	/**
	 * FILTRE - Recherche sur le département
	 *
	 * @param null $term
	 * @return Builder
	 */
	public function departement_id($term = null): ?Builder
	{
		if ($term) {
			return $this->builder->where("departement_id", $term);
		}

		return null;
	}

	/**
	 * FILTRE - REcherche sur l'établissement
	 *
	 * @param null $term
	 * @return Builder|null
	 */
	public function etablissement($term = null): ?Builder
	{
		if ($term === "with") {
			return $this->builder->whereNotNull("etablissement_id");
		} elseif ($term === "without") {
			return $this->builder->whereNull("etablissement_id");
		} elseif ($term) {
			return $this->builder->whereHas("etablissement", function ($query) use ($term) {
				return $query->where("nom", "LIKE", "%{$term}%");
			});
		}

		return null;
	}

	/**
	 * FILTRE - Recherche sur les matériels
	 *
	 * @param null $term
	 * @return Builder|null
	 */
	public function materiels($term = null): ?Builder
	{
		if ($term === "with") {
			return $this->builder->whereHas("materiels");
		} elseif ($term === "without") {
			return $this->builder->whereDoesntHave("materiels");
		} elseif ($term) {
			return $this->builder->whereHas("materiels", function ($query) use ($term) {
				return $query->where("marque", "LIKE", "%{$term}%")->orWhere("modele", "LIKE", "%{$term}%");
			});
		}

		return null;
	}

	/**
	 * FILTRE - Recherche sur le nom
	 *
	 * @param null $term
	 * @return Builder|null
	 */
	public function nom($term = null): ?Builder
	{
		if ($term) {
			return $this->builder->where("nom", "LIKE", "%{$term}%");
		}

		return null;
	}

	/**
	 * Tri de la recherche
	 * @param null $term
	 * @return Builder|null
	 */
	public function ordre($term = null): ?Builder
	{
		if ($term === "ASC/created_at") {
			return $this->builder->orderBy("created_at", "ASC");
		} elseif ($term === "DESC/created_at") {
			return $this->builder->orderBy("created_at", "DESC");
		} elseif ($term === "ASC/updated_at") {
			return $this->builder->orderBy("updated_at", "ASC");
		} elseif ($term === "DESC/created_at") {
			return $this->builder->orderBy("updated_at", "DESC");
		} elseif ($term === "ASC/date_naissance") {
			return $this->builder->orderBy("date_naissance", "ASC");
		} elseif ($term === "DESC/date_naissance") {
			return $this->builder->orderBy("date_naissance", "DESC");
		} elseif ($term === "ASC/alphabetique") {
			return $this->builder->orderBy("nom", "ASC")->orderBy("prenom", "ASC");
		} elseif ($term === "DESC/alphabetique") {
			return $this->builder->orderBy("nom", "DESC")->orderBy("prenom", "DESC");
		}

		return null;
	}

	/**
	 * FILTRE - Recherche sur le prénom
	 *
	 * @param null $term
	 * @return Builder|null
	 */
	public function prenom($term = null): ?Builder
	{
		if ($term) {
			return $this->builder->where("prenom", "LIKE", "%{$term}%");
		}

		return null;
	}

	/**
	 * FILTRE - Recherche sur les responsables
	 *
	 * @param null $term
	 * @return Builder|null
	 */
	public function responsables($term = null): ?Builder
	{
		if ($term === "with") {
			return $this->builder->whereHas("responsables");
		} elseif ($term === "without") {
			return $this->builder->whereDoesntHave("responsables");
		} elseif ($term) {
			return $this->builder->whereHas("responsables", function ($query) use ($term) {
				return $query->where("nom", "LIKE", "%{$term}%")->orWhere("prenom", "LIKE", "%{$term}%");
			});
		}

		return null;
	}

	/**
	 * FILRE - Recherche sur le type d'élève
	 *
	 * @param null $term
	 * @return Builder|null
	 */
	public function type_eleve_id($term = null): ?Builder
	{
		return $this->builder->whereHas("decisions", function ($query) use ($term) {
			return $query->whereHas("types", function ($query) use ($term) {
				return $query->where("id", $term);
			});
		});
	}

}