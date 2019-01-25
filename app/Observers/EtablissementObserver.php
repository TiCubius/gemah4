<?php

namespace App\Observers;

use App\Historique;
use App\Models\Etablissement;
use Illuminate\Support\Facades\Session;

class EtablissementObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu'un établissement est créé
     *
     * @param Etablissement $etablissement
     */
    public function created(Etablissement $etablissement)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "etablissement_id" => $etablissement->id,
                "type" => "etablissement/created",
                "contenue" => "L'établissement {$etablissement->nom} à été créé par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un établissement est modifié
     *
     * @param Etablissement $etablissement
     */
    public function updated(Etablissement $etablissement)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "etablissement_id" => $etablissement->id,
                "type" => "etablissement/modified",
                "contenue" => "L'établissement {$etablissement->nom} à été modifié par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un établissement est supprimé
     *
     * @param Etablissement $etablissement
     */
    public function deleted(Etablissement $etablissement)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "etablissement/deleted",
                "contenue" => "L'établissement {$etablissement->nom} à été supprimé par {$user->nom} {$user->prenom}"
            ]);
        }
    }
}
?>