<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\TicketMessage;
use Illuminate\Support\Facades\Session;

class TicketMessageObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu'un message est créé
     *
     * @param TicketMessage $ticketMessage
     */
    public function created(TicketMessage $ticketMessage)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "message_ticket_id" => $ticketMessage->id,
                "type" => "ticket/message/created",
                "contenue" => "Le ticket {$ticketMessage->ticket->libelle} à été modifié par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un message est modifié
     *
     * @param TicketMessage $ticketMessage
     */
    public function updated(TicketMessage $ticketMessage)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "message_ticket_id" => $ticketMessage->id,
                "type" => "ticket/message/modified",
                "contenue" => "Le ticket {$ticketMessage->ticket->libelle} à été modifié par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un message est supprimé
     *
     * @param TicketMessage $ticketMessage
     */
    public function deleted(TicketMessage $ticketMessage)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "ticket/message/deleted",
                "contenue" => "Le ticket {$ticketMessage->ticket->libelle} à été modifié par {$user->nom} {$user->prenom}"
            ]);
        }
    }
}
?>