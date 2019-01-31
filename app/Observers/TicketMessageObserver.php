<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\TicketMessage;
use Illuminate\Support\Facades\Session;

class TicketMessageObserver
{
	/***
	 * EVENT - Déchlanché après la création d'un message de ticket
	 *
	 * @param TicketMessage $ticketMessage
	 */
	public function created(TicketMessage $ticketMessage)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"eleve_id"    => $ticketMessage->ticket->eleve->id,
				"ticket_id"   => $ticketMessage->ticket->id,
				"type"        => "ticket/message/created",
				"information" => "Le ticket {$ticketMessage->ticket->libelle} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la modification d'un message de ticket
	 *
	 * @param TicketMessage $ticketMessage
	 */
	public function updated(TicketMessage $ticketMessage)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"eleve_id"    => $ticketMessage->ticket->eleve->id,
				"ticket_id"   => $ticketMessage->ticket->id,
				"type"        => "ticket/message/modified",
				"information" => "Le ticket {$ticketMessage->ticket->libelle} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la suppression d'un message de ticket
	 *
	 * @param TicketMessage $ticketMessage
	 */
	public function deleted(TicketMessage $ticketMessage)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"eleve_id"    => $ticketMessage->ticket->eleve->id,
				"type"        => "ticket/message/deleted",
				"information" => "Le ticket {$ticketMessage->ticket->libelle} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>