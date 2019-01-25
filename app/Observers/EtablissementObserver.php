<?php

namespace App\Observers;

use App\Historique;
use App\Models\DomaineMateriel;
use App\Models\Etablissement;
use Illuminate\Support\Facades\Session;

class EtablissementObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function created(Etablissement $etablissement)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $etablissement->id,
                "type" => "domaine_materiel_created",
                "contenue" => "Le domaine {$etablissement->nom} à été créé par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function updated(Etablissement $etablissement)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $etablissement->id,
                "type" => "domaine_materiel_updated",
                "contenue" => "Le domaine {$etablissement->nom} à été modifié par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function deleted(Etablissement $etablissement)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine_materiel_deleted",
                "contenue" => "Le domaine {$etablissement->nom} à été supprimé par {$user->nom}"
            ]);
        }
    }
}
?>