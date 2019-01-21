<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
	/**
	 * Liste des attributs remplissables
	 *
	 * @var array
	 */
	protected $fillable = [
		"eleve_id",
		"type_ticket_id",
		"libelle",
		"description",
	];


	/**
	 * Un ticket appartient à un élève
	 *
	 * @return BelongsTo
	 */
	public function eleve(): BelongsTo
	{
		return $this->belongsTo(Eleve::class);
	}

	/**
	 * Un ticket possède plusieurs messages
	 *
	 * @return HasMany
	 */
	public function messages(): HasMany
	{
		return $this->hasMany(TicketMessage::class);
	}

	/**
	 * Un ticket appartient à un type de ticket
	 *
	 * @return BelongsTo
	 */
	public function type(): BelongsTo
	{
		return $this->belongsTo(TypeTicket::class, "type_ticket_id");
	}


	/**
	 * Rechercher pour un élève précis
	 *
	 * @param Builder $query
	 * @param Eleve   $eleve
	 * @return Builder
	 */
	public function scopeEleve(Builder $query, Eleve $eleve)
	{
		return $query->where('eleve_id', $eleve->id);
	}
}
