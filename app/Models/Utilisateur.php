<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Utilisateur extends Model
{

	protected $fillable = ["nom", "prenom", "email", "password", "academie_id", "service_id"];

	/**
	 * @return BelongsTo
	 */
	public function service()
	{
		return $this->belongsTo(Service::class);
	}

}
