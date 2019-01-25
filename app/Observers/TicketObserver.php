<?php

namespace App\Observers;

use App\Historique;
use App\Models\Ticket;
use Illuminate\Support\Facades\Session;

class TicketObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param Ticket $ticket
     */
    public function created(Ticket $ticket)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $ticket->id,
                "type" => "domaine_materiel_created",
                "contenue" => "Le domaine {$ticket->libelle} à été créé par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param Ticket $ticket
     */
    public function updated(Ticket $ticket)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $ticket->id,
                "type" => "domaine_materiel_updated",
                "contenue" => "Le domaine {$ticket->libelle} à été modifié par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param Ticket $ticket
     */
    public function deleted(Ticket $ticket)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine_materiel_deleted",
                "contenue" => "Le domaine {$ticket->libelle} à été supprimé par {$user->nom}"
            ]);
        }
    }
}
?>