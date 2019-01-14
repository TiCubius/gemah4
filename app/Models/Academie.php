<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Academie extends Model
{

	protected $fillable = [
	    "nom",
        "region_id"
    ];


	/**
	 * Une Académie est présente dans au plus une Région
	 *
	 * @return BelongsTo
	 */
	public function region(): BelongsTo
	{
		return $this->belongsTo(Region::class);
	}

	/**
     * Une Académie est lié à plusieurs départements
     *
     * @return hasMany
     */
	public function departements(): HasMany
    {
        return $this->hasMany(Departement::class);
    }

}
