<?php

namespace App\Observers;

use App\Historique;
use App\Models\TypeTicket;
use Illuminate\Support\Facades\Session;

class TypeTicketObserver
{
    /***
     * @param TypeTicket $typeTicket
     */
    public function created(TypeTicket $typeTicket)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $typeTicket->id,
                "type" => "domaine_materiel_created",
                "contenue" => "Le domaine {$typeTicket->libelle} à été créé par {$user->nom}"
            ]);
        }
    }

    /***
     * @param TypeTicket $typeTicket
     */
    public function updated(TypeTicket $typeTicket)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $typeTicket->id,
                "type" => "domaine_materiel_updated",
                "contenue" => "Le domaine {$typeTicket->libelle} à été modifié par {$user->nom}"
            ]);
        }
    }

    /***
     * @param TypeTicket $typeTicket
     */
    public function deleted(TypeTicket $typeTicket)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine_materiel_deleted",
                "contenue" => "Le domaine {$typeTicket->libelle} à été supprimé par {$user->nom}"
            ]);
        }
    }
}
?>