<?php

namespace App\Observers;

use App\Models\Historique;
use App\Models\DomaineMateriel;
use Illuminate\Support\Facades\Session;

class DomaineMaterielObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu'un domaine matériel est créé
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function created(DomaineMateriel $domaineMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $domaineMateriel->id,
                "type" => "domaine/materiel/created",
                "contenue" => "Le domaine {$domaineMateriel->libelle} à été créé par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un domaine matériel est modifié
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function updated(DomaineMateriel $domaineMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $domaineMateriel->id,
                "type" => "domaine/materiel/modified",
                "contenue" => "Le domaine {$domaineMateriel->libelle} à été modifié par {$user->nom} {$user->prenom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu'un domaine matériel est supprimé
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function deleted(DomaineMateriel $domaineMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine/materiel/deleted",
                "contenue" => "Le domaine {$domaineMateriel->libelle} à été supprimé par {$user->nom} {$user->prenom}"
            ]);
        }
    }
}
?>