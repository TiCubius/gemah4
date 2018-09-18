<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{

	protected $fillable = ["nom"];


	/**
	 * Une Région possède 0, 1, ou plusieurs Académies
	 *
	 * @return HasMany
	 */
	public function academies(): HasMany
	{
		return $this->hasMany(Academie::class);
	}

}
