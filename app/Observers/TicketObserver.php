<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\Ticket;
use Illuminate\Support\Facades\Session;

class TicketObserver
{
	/***
	 * EVENT - Déchlanché après la création d'un ticket
	 *
	 * @param Ticket $ticket
	 */
	public function created(Ticket $ticket)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"eleve_id"    => $ticket->eleve->id,
				"ticket_id"   => $ticket->id,
				"type"        => "ticket/created",
				"information" => "Le ticket {$ticket->libelle} à été créé par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/***
	 * EVENT - Déchlanché après la modification d'un ticket
	 *
	 * @param Ticket $ticket
	 */
	public function updated(Ticket $ticket)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"eleve_id"    => $ticket->eleve->id,
				"ticket_id"   => $ticket->id,
				"type"        => "ticket/modified",
				"information" => "Le ticket {$ticket->libelle} à été modifié par {$user->nom} {$user->prenom}",
			]);
		}
	}

	/**
	 * EVENT - Déclanché lors de la suppression d'un ticket
	 *
	 * @param Ticket $ticket
	 */
	public function deleting(Ticket $ticket)
	{
		// On supprime tout les messages du ticket
		$ticket->messages()->delete();
	}

	/***
	 * EVENT - Déchlanché après la suppression d'un ticket
	 *
	 * @param Ticket $ticket
	 */
	public function deleted(Ticket $ticket)
	{
		if (Session::has("user")) {
			$user = Session::get("user");
			Historique::create([
				"from_id"     => $user->id,
				"eleve_id"    => $ticket->eleve->id,
				"type"        => "ticket/deleted",
				"information" => "Le ticket {$ticket->libelle} à été supprimé par {$user->nom} {$user->prenom}",
			]);
		}
	}
}

?>