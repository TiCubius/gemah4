<?php

namespace App\Http\Controllers\Scolarites;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\Ticket;
use App\Models\TypeTicket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{

	/**
	 * GET - Affiche la liste des tickets de l'élève
	 *
	 * @param Eleve $eleve
	 * @return View
	 */
	public function index(Eleve $eleve): View
	{
		$tickets = Ticket::with("type")->eleve($eleve)->get();

		return view("web.scolarites.eleves.tickets.index", compact("eleve", "tickets"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un ticket pour l'élève
	 *
	 * @param Eleve $eleve
	 * @return View
	 */
	public function create(Eleve $eleve): View
	{
		$typesTicket = TypeTicket::all();

		return view("web.scolarites.eleves.tickets.create", compact("eleve", "typesTicket"));
	}

	/**
	 * POST - Ajoute un nouveau ticket
	 *
	 * @param Request $request
	 * @param Eleve   $eleve
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Request $request, Eleve $eleve): RedirectResponse
	{
		$request->validate([
			"libelle"        => "required|max:255",
			"type_ticket_id" => "required|exists:types_tickets,id",
		]);

		Ticket::create([
			"eleve_id"       => $eleve->id,
			"type_ticket_id" => $request->input("type_ticket_id"),

			"libelle" => $request->input("libelle"),
		]);

		return redirect(route("web.scolarites.eleves.tickets.index", [$eleve]));
	}

	/**
	 * GET - Affiche les données du ticket
	 *
	 * @param Eleve  $eleve
	 * @param Ticket $ticket
	 * @return View
	 */
	public function show(Eleve $eleve, Ticket $ticket): View
	{
		return view("web.scolarites.eleves.tickets.show", compact("eleve", "ticket"));
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un ticket
	 *
	 * @param Eleve  $eleve
	 * @param Ticket $ticket
	 * @return View
	 */
	public function edit(Eleve $eleve, Ticket $ticket): View
	{
		$typesTicket = TypeTicket::all();

		return view("web.scolarites.eleves.tickets.edit", compact("eleve", "ticket", "typesTicket"));
	}

	/**
	 * PATCH - Enregistre les modifications apportés au ticket
	 *
	 * @param Request $request
	 * @param Eleve   $eleve
	 * @param Ticket  $ticket
	 * @return RedirectResponse
	 */
	public function update(Request $request, Eleve $eleve, Ticket $ticket): RedirectResponse
	{
		$request->validate([
			"libelle"        => "required|max:255",
			"type_ticket_id" => "required|exists:types_tickets,id",
		]);

		$ticket->update($request->only(["libelle", "type_ticket_id"]));

		return redirect(route("web.scolarites.eleves.tickets.show", [$eleve, $ticket]));
	}

	/**
	 * DETELE - Supprime le ticket et les messages associés
	 *
	 * @param Eleve  $eleve
	 * @param Ticket $ticket
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Eleve $eleve, Ticket $ticket): RedirectResponse
	{
		$ticket->messages()->delete();
		$ticket->delete();

		return redirect(route("web.scolarites.eleves.tickets.index", [$eleve]));
	}


}
