<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ResponsableFilters extends QueryFilters
{
	protected $request;

	public function __construct(Request $request)
	{
		parent::__construct($request);

		$this->request = $request;
	}


	/**
	 * FILTRE - Recherche sur l'adresse
	 *
	 * @param null $term
	 * @return Builder|null
	 */
	public function adresse($term = null): ?Builder
	{
		if ($term) {
			return $this->builder->where("adresse", "LIKE", "%{$term}%");
		}

		return null;
	}

	/**
	 * FILTRE - Recherche sur la civilité
	 *
	 * @param null $term
	 * @return Builder|null
	 */
	public function civilite($term = null): ?Builder
	{
		if ($term) {
			return $this->builder->where("civilite", $term);
		}

		return null;
	}

	/**
	 * FILTRE - Recherche sur le code postal
	 *
	 * @param null $term
	 * @return Builder|null
	 */
	public function code_postal($term = null): ?Builder
	{
		if ($term) {
			return $this->builder->where("code_postal", $term);
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
	 * FILTRE - Recherche sur l'adresse E-Mail
	 *
	 * @param null $term
	 * @return Builder|null
	 */
	public function email($term = null): ?Builder
	{
		if ($term) {
			return $this->builder->where("email", "LIKE", "%{$term}%");
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
	 * FILTRE - Tri de la recherche
	 *
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
		} elseif ($term === "DESC/updated_at") {
			return $this->builder->orderBy("updated_at", "DESC");
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
	 * FILTRE - Recherche sur le téléphone
	 *
	 * @param null $term
	 * @return Builder|null
	 */
	public function telephone($term = null): ?Builder
	{
		if ($term) {
			return $this->builder->where("telephone", "LIKE", "%{$term}%");
		}

		return null;
	}

	/**
	 * FILTRE - Recherche sur la ville
	 *
	 * @param null $term
	 * @return Builder|null
	 */
	public function ville($term = null): ?Builder
	{
		if ($term) {
			return $this->builder->where("ville", "LIKE", "%{$term}%");
		}

		return null;
	}

}
