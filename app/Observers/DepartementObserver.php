<?php

namespace App\Observers;

use App\Historique;
use App\Models\Departement;
use Illuminate\Support\Facades\Session;

class DepartementObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu'un département est créé
     *
     * @param Departement $departement
     */
    public function created(Departement $departement)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $departement->id,
                "type" => "departement_created",
                "contenue" => "Le domaine {$departement->libelle} à été créé par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param Departement $departement
     */
    public function updated(Departement $departement)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $departement->id,
                "type" => "domaine_materiel_updated",
                "contenue" => "Le domaine {$departement->libelle} à été modifié par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param Departement $departement
     */
    public function deleted(Departement $departement)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine_materiel_deleted",
                "contenue" => "Le domaine {$departement->libelle} à été supprimé par {$user->nom}"
            ]);
        }
    }
}
?>