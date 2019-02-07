<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeDocument extends Model
{
	/**
	 * Le nom de la table n'est pas celui attendu par défaut
	 *
	 * @var string
	 */
	protected $table = "types_documents";

	/**
	 * Liste des attributs remplissables
	 *
	 * @var array
	 */
	protected $fillable = [
		"libelle",
	];

	/***
	 * Un type de document défini plusieurs documents
	 *
	 * @return HasMany
	 */
	public function documents(): HasMany
	{
		return $this->hasMany(Document::class);
	}
}
