<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\Service;
use Illuminate\Support\Facades\Session;

class ServiceObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu'un service est créé
     *
     * @param Service $service
     */
    public function created(Service $service)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "service_id" => $service->id,
                "type" => "service/created",
                "contenue" => "Le service {$service->nom} à été créé par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un service est modifié
     *
     * @param Service $service
     */
    public function updated(Service $service)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "service_id" => $service->id,
                "type" => "service/modified",
                "contenue" => "Le service {$service->nom} à été modifié par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un service est supprimé
     *
     * @param Service $service
     */
    public function deleted(Service $service)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "service/deleted",
                "contenue" => "Le service {$service->nom} à été supprimé par {$user->nom} {$user->prenom}"
            ]);
        }
    }
}
?>