<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Utilisateur extends Model
{

	protected $fillable = [
	    "nom",
        "prenom",
        "pseudo",
        "email",
        "password",
        "service_id"
    ];


	/**
	 * Un Utilisateur appartient à au plus un Service
	 *
	 * @return BelongsTo
	 */
	public function service(): BelongsTo
	{
		return $this->belongsTo(Service::class);
	}

}
