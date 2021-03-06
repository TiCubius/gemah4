<?php

namespace App\Http\Controllers\Administrations\Types;

use App\Http\Controllers\Controller;
use App\Models\TypeTicket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TypeTicketController extends Controller
{
	/**
	 * GET - Affiche la liste des types de tickets
	 *
	 * @return View
	 */
	public function index(): View
	{
		$tickets = TypeTicket::all();

		return view("web.administrations.types.tickets.index", compact("tickets"));
	}

	/**
	 * GET - Affiche le formulaire de création d'un type de ticket
	 *
	 * @return View
	 */
	public function create(): View
	{
		return view("web.administrations.types.tickets.create");
	}

	/**
	 * POST - Ajoute un nouveau type de ticket
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return RedirectResponse
	 */
	public function store(Request $request): RedirectResponse
	{
		$request->validate([
			"libelle" => "required|max:191|unique:types_tickets",
		]);

		TypeTicket::create($request->only(["libelle"]));

		return redirect(route("web.administrations.types.tickets.index"));
	}

	/**
	 * GET - Affiche le formulaire d'édition d'un type de ticket
	 *
	 * @param TypeTicket $ticket
	 * @return View
	 */
	public function edit(TypeTicket $ticket): View
	{
		return view("web.administrations.types.tickets.edit", compact("ticket"));
	}

	/**
	 * PUT - Enregistre les modifications apportés au type de ticket
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param TypeTicket                $ticket
	 * @return RedirectResponse
	 */
	public function update(Request $request, TypeTicket $ticket): RedirectResponse
	{
		$request->validate([
			"libelle" => "required|max:191|unique:types_tickets,libelle,{$ticket->id}",
		]);

		$ticket->update($request->only(["libelle"]));

		return redirect(route("web.administrations.types.tickets.index"));
	}

	/**
	 * DELETE - Supprime le type de ticket
	 *
	 * @param TypeTicket $ticket
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(TypeTicket $ticket): RedirectResponse
	{
		if ($ticket->tickets->isNotEmpty()) {
			return back()->withErrors("Impossible de supprimer un type associé à des tickets");
		}

		$ticket->delete();

		return redirect(route("web.administrations.types.tickets.index"));
	}
}
