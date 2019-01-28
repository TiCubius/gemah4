<?php

namespace App\Models;

use App\Models\Academie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
	/**
	 * Liste des attributs remplissables
	 *
	 * @var array
	 */
	protected $fillable = [
		"nom",
	];


	/**
	 * Une région possède plusieurs départements
	 *
	 * @return HasMany
	 */
	public function academies(): HasMany
	{
		return $this->hasMany(Academie::class);
	}
}
