<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TypeDecision extends Model
{
	/**
	 * Le nom de la table n'est pas celui attendu par défaut
	 *
	 * @var string
	 */
	public $table = "types_decisions";

	/**
	 * Liste des attributs remplissables
	 *
	 * @var array
	 */
	protected $fillable = [
		"libelle",
	];


	/**
	 * Un type de décision possède plusieurs décisions
	 * [Utilisation d'une table PIVOT]
	 *
	 * @return BelongsToMany
	 */
	public function decisions(): BelongsToMany
	{
		return $this->belongsToMany(Decision::class);
	}
}
