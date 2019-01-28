<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\Ticket;
use Illuminate\Support\Facades\Session;

class TicketObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu'un ticket est créé
     *
     * @param Ticket $ticket
     */
    public function created(Ticket $ticket)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "ticket_id" => $ticket->id,
                "type" => "ticket/created",
                "contenue" => "Le ticket {$ticket->libelle} à été créé par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un ticket est modifié
     *
     * @param Ticket $ticket
     */
    public function updated(Ticket $ticket)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "ticket_id" => $ticket->id,
                "type" => "ticket/modified",
                "contenue" => "Le ticket {$ticket->libelle} à été modifié par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un ticket est supprimé
     *
     * @param Ticket $ticket
     */
    public function deleted(Ticket $ticket)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "ticket/deleted",
                "contenue" => "Le ticket {$ticket->libelle} à été supprimé par {$user->nom} {$user->prenom}"
            ]);
        }
    }
}
?>