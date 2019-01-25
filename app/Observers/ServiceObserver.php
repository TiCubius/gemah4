<?php

namespace App\Observers;

use App\Historique;
use App\Models\Service;
use Illuminate\Support\Facades\Session;

class ServiceObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param Service $service
     */
    public function created(Service $service)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $service->id,
                "type" => "domaine_materiel_created",
                "contenue" => "Le domaine {$service->libelle} à été créé par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param Service $service
     */
    public function updated(Service $service)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $service->id,
                "type" => "domaine_materiel_updated",
                "contenue" => "Le domaine {$service->libelle} à été modifié par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param Service $service
     */
    public function deleted(Service $service)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine_materiel_deleted",
                "contenue" => "Le domaine {$service->libelle} à été supprimé par {$user->nom}"
            ]);
        }
    }
}
?>