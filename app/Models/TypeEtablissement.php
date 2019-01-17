<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeEtablissement extends Model
{
	protected $table = "types_etablissements";
	protected $fillable = [
		"libelle",
	];

	/**
	 * Un type d'établissement possède plusieurs établissements
	 *
	 * @return HasMany
	 */
	public function etablissements(): HasMany
	{
		return $this->hasMany(Etablissement::class);
	}

}
