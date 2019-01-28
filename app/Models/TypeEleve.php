<?php

namespace App\Models;

use App\Observers\TypeEleveObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TypeEleve extends Model
{
	/**
	 * Le nom de la table n'est pas celui attendu par défaut
	 *
	 * @var string
	 */
	public $table = "types_eleves";

	/**
	 * Liste des attributs remplissables
	 *
	 * @var array
	 */
	protected $fillable = [
		"libelle",
	];


	/**
	 * Un type d'élève possède plusieurs élève
	 * [Utilisation d'une table PIVOT]
	 *
	 * @return BelongsToMany
	 */
	public function eleves(): BelongsToMany
	{
		return $this->belongsToMany(Eleve::class);
	}
}
