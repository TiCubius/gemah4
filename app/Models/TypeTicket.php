<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeTicket extends Model
{
	protected $table = "types_ticket";

	protected $fillable = [
	    "libelle"
    ];

    /***
     * Un type de ticket à plusieurs tickets
     *
     * @return HasMany
     */
	public function tickets(): hasMany
    {
        return $this->hasMany(Ticket::class, "type_ticket_id");
    }
}
