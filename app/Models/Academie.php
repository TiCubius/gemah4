<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Academie extends Model
{

	protected $fillable = ["nom", "region_id"];


	/**
	 * Une Académie est présente dans au plus un Departement
	 *
	 * @return BelongsTo
	 */
	public function region(): BelongsTo
	{
		return $this->belongsTo(Departement::class);
	}

}
