<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{

	protected $fillable = ["nom", "description"];


	/**
	 * Un Service possède 0, 1, ou plusieurs Utilisateurs
	 *
	 * @return HasMany
	 */
	public function utilisateurs(): HasMany
	{
		return $this->hasMany(Utilisateur::class);
	}
}
