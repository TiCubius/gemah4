<?php

namespace App\Http\Controllers\Administrations\Types;

use App\Models\TypeTicket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class TypeTicketController extends Controller
{
    /**
     * GET - Affiche la liste des Types Tickets
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
            "libelle"     => "required|max:191|unique:types_ticket",
        ]);

        TypeTicket::create($request->only(["libelle"]));

        return redirect(route("web.administrations.types.tickets.index"));
    }

    /**
     * GET - Affiche le formulaire d'édition d'un état matériel
     *
     * @param TypeTicket $ticket
     * @return View
     */
    public function edit(TypeTicket $ticket): View
    {
        return view("web.administrations.types.tickets.edit", compact("ticket"));
    }

    /**
     * PUT - Enregistre les modifications apportés à l'état matériel
     *
     * @param  \Illuminate\Http\Request $request
     * @param TypeTicket $type
     * @return RedirectResponse
     */
    public function update(Request $request, TypeTicket $ticket): RedirectResponse
    {
        $request->validate([
            "libelle"     => "required|max:191|unique:types_ticket,libelle,{$ticket->id}",
        ]);

        $ticket->update($request->only(["libelle"]));

        return redirect(route("web.administrations.types.tickets.index"));
    }

    /**
     * DELETE - Supprime l'état matériel
     *
     * @param TypeTicket $ticket
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(TypeTicket $ticket): RedirectResponse
    {
        if ($ticket->tickets->isNotEmpty()) {
            return back()->withErrors("Impossible de supprimer un type de ticket associé à des tickets");
        }

        $ticket->delete();

        return redirect(route("web.administrations.types.tickets.index"));
    }
}
