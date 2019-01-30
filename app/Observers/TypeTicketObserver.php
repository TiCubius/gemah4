<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\TypeTicket;
use Illuminate\Support\Facades\Session;

class TypeTicketObserver
{
	/***
	 * Ajoute une ligne à l'historique dès qu'un type de ticket est créé
	 *
	 * @param TypeTicket $typeTicket
	 */
	public function created(TypeTicket $typeTicket)
	{
		if (Session::has("user")) {
			$user = session("user");
			Historique::create([
				"from_id"        => $user["id"],
				"type_ticket_id" => $typeTicket->id,
				"type"           => "type/ticket/created",
				"contenue"       => "Le type de ticket {$typeTicket->libelle} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * Ajoute une ligne à l'historique dès qu'un type de ticket est modifié
	 *
	 * @param TypeTicket $typeTicket
	 */
	public function updated(TypeTicket $typeTicket)
	{
		if (Session::has("user")) {
			$user = session("user");
			Historique::create([
				"from_id"        => $user["id"],
				"type_ticket_id" => $typeTicket->id,
				"type"           => "type/ticket/modified",
				"contenue"       => "Le type de ticket {$typeTicket->libelle} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * Ajoute une ligne à l'historique dès qu'un type de ticket est supprimé
	 *
	 * @param TypeTicket $typeTicket
	 */
	public function deleted(TypeTicket $typeTicket)
	{
		if (Session::has("user")) {
			$user = session("user");
			Historique::create([
				"from_id"  => $user["id"],
				"type"     => "type/ticket/deleted",
				"contenue" => "Le type de ticket {$typeTicket->libelle} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>