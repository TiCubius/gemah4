<?php

namespace App\Observers;

use App\Historique;
use App\Models\Region;
use Illuminate\Support\Facades\Session;

class RegionObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param Region $region
     */
    public function created(Region $region)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $region->id,
                "type" => "domaine_materiel_created",
                "contenue" => "Le domaine {$region->libelle} à été créé par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param Region $region
     */
    public function updated(Region $region)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $region->id,
                "type" => "domaine_materiel_updated",
                "contenue" => "Le domaine {$region->libelle} à été modifié par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param Region $region
     */
    public function deleted(Region $region)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine_materiel_deleted",
                "contenue" => "Le domaine {$region->libelle} à été supprimé par {$user->nom}"
            ]);
        }
    }
}
?>