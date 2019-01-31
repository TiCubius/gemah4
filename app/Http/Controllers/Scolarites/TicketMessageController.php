<?php

namespace App\Http\Controllers\Scolarites;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketMessageController extends Controller
{
	/**
	 * POST - Ajoute un nouveau message pour un ticket
	 *
	 * @param Request $request
	 * @param Eleve   $eleve
	 * @param Ticket  $ticket
	 * @return RedirectResponse
	 */
	public function store(Request $request, Eleve $eleve, Ticket $ticket): RedirectResponse
	{
		$request->validate([
			"contenu" => "required",
		]);

		TicketMessage::create([
			"ticket_id" => $ticket->id,
			"contenu"   => $request->input("contenu"),
		]);

		return redirect(route("web.scolarites.eleves.tickets.show", [$eleve, $ticket]));
	}


	/**
	 * GET - Affiche le formulaire d'édition d'un message
	 *
	 * @param Eleve         $eleve
	 * @param Ticket        $ticket
	 * @param TicketMessage $message
	 * @return View
	 */
	public function edit(Eleve $eleve, Ticket $ticket, TicketMessage $message): View
	{
		return view("web.scolarites.eleves.tickets.messages.edit", compact("eleve", "ticket", "message"));
	}


	/**
	 * PATCH - Met a jour le message
	 *
	 * @param Request       $request
	 * @param Eleve         $eleve
	 * @param Ticket        $ticket
	 * @param TicketMessage $message
	 * @return RedirectResponse
	 */
	public function update(Request $request, Eleve $eleve, Ticket $ticket, TicketMessage $message): RedirectResponse
	{
		$request->validate([
			"contenu" => "required",
		]);

		$message->update($request->all());

		return redirect(route("web.scolarites.eleves.tickets.show", [$eleve, $ticket]));
	}

	/**
	 * DELETE - Supprilme le message
	 *
	 * @param Eleve         $eleve
	 * @param Ticket        $ticket
	 * @param TicketMessage $message
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Eleve $eleve, Ticket $ticket, TicketMessage $message): RedirectResponse
	{
		$message->delete();

		return redirect(route("web.scolarites.eleves.tickets.show", [$eleve, $ticket]));
	}
}
