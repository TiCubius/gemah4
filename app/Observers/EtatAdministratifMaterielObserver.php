<?php

namespace App\Observers;

use App\Historique;
use App\Models\DomaineMateriel;
use App\Models\EtatAdministratifMateriel;
use Illuminate\Support\Facades\Session;

class EtatAdministratifMaterielObserver
{
    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function created(EtatAdministratifMateriel $etatAdministratifMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $etatAdministratifMateriel->id,
                "type" => "domaine_materiel_created",
                "contenue" => "Le domaine {$etatAdministratifMateriel->libelle} à été créé par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function updated(EtatAdministratifMateriel $etatAdministratifMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "domaine_id" => $etatAdministratifMateriel->id,
                "type" => "domaine_materiel_updated",
                "contenue" => "Le domaine {$etatAdministratifMateriel->libelle} à été modifié par {$user->nom}"
            ]);
        }
    }

    /***
     * Ajoute une ligne à l'historique dès qu
     *
     * @param DomaineMateriel $domaineMateriel
     */
    public function deleted(EtatAdministratifMateriel $etatAdministratifMateriel)
    {
        if(Session::has("user")){
            $user = session("user");
            Historique::create([
                "from_id" => $user["id"],
                "type" => "domaine_materiel_deleted",
                "contenue" => "Le domaine {$etatAdministratifMateriel->libelle} à été supprimé par {$user->nom}"
            ]);
        }
    }
}
?>