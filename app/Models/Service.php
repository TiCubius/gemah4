<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
	/**
	 * Liste des attributs remplissables
	 *
	 * @var array
	 */
	protected $fillable = [
	    "nom",
        "description",
        "departement_id",
    ];


	/**
	 * Un service possède plusieurs utilisateurs
	 *
	 * @return HasMany
	 */
	public function utilisateurs(): HasMany
	{
		return $this->hasMany(Utilisateur::class);
	}
}
