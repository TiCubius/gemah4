<?php

namespace App\Observers;

use App\Historique;
use App\Models\DomaineMateriel;
use Illuminate\Support\Facades\Session;

class DomaineMaterielObserver
{
    /***
     * @param DomaineMateriel $domaineMateriel
     */
    public function created(DomaineMateriel $domaineMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $domaineMateriel->id,
                "type" => "domaine_materiel_created",
                "contenue" => "Le domaine {$domaineMateriel->libelle} à été créé par {$user->nom}"
            ]);
        }
    }

    /***
     * @param DomaineMateriel $domaineMateriel
     */
    public function updated(DomaineMateriel $domaineMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $domaineMateriel->id,
                "type" => "domaine_materiel_updated",
                "contenue" => "Le domaine {$domaineMateriel->libelle} à été modifié par {$user->nom}"
            ]);
        }
    }

    /***
     * @param DomaineMateriel $domaineMateriel
     */
    public function deleted(DomaineMateriel $domaineMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine_materiel_deleted",
                "contenue" => "Le domaine {$domaineMateriel->libelle} à été supprimé par {$user->nom}"
            ]);
        }
    }
}
?>