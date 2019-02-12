<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Documentation extends Model
{
	protected $guarded = [];

	/**
	 * Une documentation appartient à une catégorie
	 *
	 * @return BelongsTo
	 */
	public function categorie(): BelongsTo
	{
		return $this->belongsTo(Categorie::class);
	}
}
