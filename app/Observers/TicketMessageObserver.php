<?php

namespace App\Observers;

use App\Historique;
use App\Models\TicketMessage;
use Illuminate\Support\Facades\Session;

class TicketMessageObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param TicketMessage $ticketMessage
     */
    public function created(TicketMessage $ticketMessage)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $ticketMessage->id,
                "type" => "domaine_materiel_created",
                "contenue" => "Le domaine {$ticketMessage->libelle} à été créé par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param TicketMessage $ticketMessage
     */
    public function updated(TicketMessage $ticketMessage)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $ticketMessage->id,
                "type" => "domaine_materiel_updated",
                "contenue" => "Le domaine {$ticketMessage->libelle} à été modifié par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param TicketMessage $ticketMessage
     */
    public function deleted(TicketMessage $ticketMessage)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine_materiel_deleted",
                "contenue" => "Le domaine {$ticketMessage->libelle} à été supprimé par {$user->nom}"
            ]);
        }
    }
}
?>