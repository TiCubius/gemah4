<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeEtablissement extends Model
{
	/**
	 * Le nom de la table n'est pas celui attendu par défaut
	 *
	 * @var string
	 */
	public $table = "types_etablissements";

	/**
	 * Liste des attributs remplissables
	 *
	 * @var array
	 */
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
