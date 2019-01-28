<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\Responsable;
use Illuminate\Support\Facades\Session;

class ResponsableObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu'un responsable est créé
     *
     * @param Responsable $responsable
     */
    public function created(Responsable $responsable)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "responsable_id" => $responsable->id,
                "type" => "responsable/created",
                "contenue" => "Le responsable {$responsable->nom} {$responsable->prenom} à été créé par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un responsable est modifié
     *
     * @param Responsable $responsable
     */
    public function updated(Responsable $responsable)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "responsable_id" => $responsable->id,
                "type" => "responsable/modified",
                "contenue" => "Le responsable {$responsable->nom} {$responsable->prenom} à été modifié par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un responsable est supprimé
     *
     * @param Responsable $responsable
     */
    public function deleted(Responsable $responsable)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "responsable/deleted",
                "contenue" => "Le responsable {$responsable->nom} {$responsable->prenom} à été supprimé par {$user->nom} {$user->prenom}"
            ]);
        }
    }
}
?>