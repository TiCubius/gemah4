<?php

namespace App\Observers;

use App\Historique;
use App\Models\Responsable;
use Illuminate\Support\Facades\Session;

class ResponsableObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param Responsable $responsable
     */
    public function created(Responsable $responsable)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $responsable->id,
                "type" => "domaine_materiel_created",
                "contenue" => "Le domaine {$responsable->libelle} à été créé par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param Responsable $responsable
     */
    public function updated(Responsable $responsable)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $responsable->id,
                "type" => "domaine_materiel_updated",
                "contenue" => "Le domaine {$responsable->libelle} à été modifié par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param Responsable $responsable
     */
    public function deleted(Responsable $responsable)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine_materiel_deleted",
                "contenue" => "Le domaine {$responsable->libelle} à été supprimé par {$user->nom}"
            ]);
        }
    }
}
?>