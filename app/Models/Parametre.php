<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
	public $primaryKey = ["departement_id", "key"];

	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = ["departement_id", "libelle", "key", "value"];


	/**
	 * Récupère tout les paramètres concernant les conventions
	 *
	 * @param $query
	 * @param $departementId
	 * @return Builder
	 */
	public function scopeConventions($query, $departementId): Builder
	{
		return $query->where("key", "LIKE", "conventions/%")->where("departement_id", $departementId);
	}
}
