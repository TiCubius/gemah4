<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Utilisateur extends Model
{
	/**
	 * Liste des attributs remplissables
	 *
	 * @var array
	 */
	protected $fillable = [
		"nom",
		"prenom",
		"identifiant",
		"email",
		"password",
		"service_id",
		"reception_email",
	];


	/**
	 * Un utilisateur appartient à un service
	 *
	 * @return BelongsTo
	 */
	public function service(): BelongsTo
	{
		return $this->belongsTo(Service::class);
	}
}
