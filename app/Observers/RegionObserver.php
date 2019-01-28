<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\Region;
use Illuminate\Support\Facades\Session;

class RegionObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu'une région est créée
     *
     * @param Region $region
     */
    public function created(Region $region)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "region_id" => $region->id,
                "type" => "region/created",
                "contenue" => "La région {$region->nom} à été créée par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'une région est modifiée
     *
     * @param Region $region
     */
    public function updated(Region $region)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "region_id" => $region->id,
                "type" => "region/modified",
                "contenue" => "La région {$region->nom} à été modifiée par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'une région est supprimée
     *
     * @param Region $region
     */
    public function deleted(Region $region)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "region/deleted",
                "contenue" => "La région {$region->nom} à été supprimée par {$user->nom} {$user->prenom}"
            ]);
        }
    }
}
?>