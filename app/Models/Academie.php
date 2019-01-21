<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Academie extends Model
{

	/**
	 * Liste des attributs remplissables
	 *
	 * @var array
	 */
	protected $fillable = [
		"nom",
		"region_id",
	];


	/**
	 * Une académie appartient à une région
	 *
	 * @return BelongsTo
	 */
	public function region(): BelongsTo
	{
		return $this->belongsTo(Region::class);
	}

	/**
	 * Une académie possède plusieurs départements
	 *
	 * @return hasMany
	 */
	public function departements(): HasMany
	{
		return $this->hasMany(Departement::class);
	}
}
