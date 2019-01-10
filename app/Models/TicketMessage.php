<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketMessage extends Model
{

	protected $fillable = ["ticket_id", "contenu"];

	/**
	 * Un message appartient à un ticket
	 *
	 * @return BelongsTo
	 */
	public function ticket(): BelongsTo
	{
		return $this->belongsTo(Ticket::class);
	}
}
