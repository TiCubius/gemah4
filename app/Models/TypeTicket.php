<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeTicket extends Model
{
	/**
	 * Le nom de la table n'est pas celui attendu par défaut
	 *
	 * @var string
	 */
	protected $table = "types_tickets";

	/**
	 * Liste des attributs remplissables
	 *
	 * @var array
	 */
	protected $fillable = [
		"libelle",
	];


	/**
	 * Un type de ticket possède plusieurs tickets
	 *
	 * @return HasMany
	 */
	public function tickets(): hasMany
	{
		return $this->hasMany(Ticket::class, "type_ticket_id");
	}
}
