<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\TypeTicket;
use Illuminate\Support\Facades\Session;

class TypeTicketObserver
{
	/***
	 * EVENT - Déchlanché après la création d'un type de ticket
	 *
	 * @param TypeTicket $typeTicket
	 */
	public function created(TypeTicket $typeTicket)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"        => $user->id,
				"type_ticket_id" => $typeTicket->id,
				"type"           => "type/ticket/created",
				"information"    => "Le type de ticket {$typeTicket->libelle} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la modification d'un type de ticket
	 *
	 * @param TypeTicket $typeTicket
	 */
	public function updated(TypeTicket $typeTicket)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"        => $user->id,
				"type_ticket_id" => $typeTicket->id,
				"type"           => "type/ticket/modified",
				"information"    => "Le type de ticket {$typeTicket->libelle} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la suppression d'un type de ticket
	 *
	 * @param TypeTicket $typeTicket
	 */
	public function deleted(TypeTicket $typeTicket)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"type"        => "type/ticket/deleted",
				"information" => "Le type de ticket {$typeTicket->libelle} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>