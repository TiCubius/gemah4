<?php

namespace App\Observers;

use App\Historique;
use App\Models\DomaineMateriel;
use App\Models\Materiel;
use Illuminate\Support\Facades\Session;

class MaterielObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function created(Materiel $materiel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $materiel->id,
                "type" => "domaine_materiel_created",
                "contenue" => "Le domaine {$materiel->libelle} à été créé par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function updated(Materiel $materiel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $materiel->id,
                "type" => "domaine_materiel_updated",
                "contenue" => "Le domaine {$materiel->libelle} à été modifié par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function deleted(Materiel $materiel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine_materiel_deleted",
                "contenue" => "Le domaine {$materiel->libelle} à été supprimé par {$user->nom}"
            ]);
        }
    }
}
?>